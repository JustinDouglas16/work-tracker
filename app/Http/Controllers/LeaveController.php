<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveSetting;
use App\Models\LeaveType;
use App\Services\LeaveCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class LeaveController extends Controller
{
    public function store(Request $request, LeaveCalculator $leaveCalculator): JsonResponse|RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $leave = DB::transaction(function () use ($leaveCalculator, $request, $validated): Leave {
            $leaveType = $this->leaveTypeForUser($request, (int) $validated['leave_type_id']);
            $daysUsed = $leaveCalculator->weekdayDaysUsed($validated['start_date'], $validated['end_date']);

            $this->validateBalanceImpact($request, $leaveType, $daysUsed);

            if ($leaveType->affects_balance) {
                $this->settingForUser($request)->decrement('paid_leave_balance', $daysUsed);
            }

            return Leave::query()->create([
                'user_id' => $request->user()->id,
                'leave_type_id' => $leaveType->id,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'days_used' => $daysUsed,
                'reason' => $validated['reason'] ?? null,
            ]);
        });

        if (! $request->expectsJson()) {
            return back()->with('status', 'Leave entry saved.');
        }

        return response()->json(['leave' => $leave], 201);
    }

    /**
     * @throws Throwable
     */
    public function update(Request $request, Leave $leave, LeaveCalculator $leaveCalculator): JsonResponse|RedirectResponse
    {
        $this->abortUnlessOwned($request, $leave);
        $validated = $request->validate($this->rules());

        $leave = DB::transaction(function () use ($leave, $leaveCalculator, $request, $validated): Leave {
            $setting = $this->settingForUser($request);
            $currentType = $leave->leaveType;

            if ($currentType->affects_balance) {
                $setting->increment('paid_leave_balance', $leave->days_used);
                $setting->refresh();
            }

            $leaveType = $this->leaveTypeForUser($request, (int) $validated['leave_type_id']);
            $daysUsed = $leaveCalculator->weekdayDaysUsed($validated['start_date'], $validated['end_date']);

            $this->validateBalanceImpact($request, $leaveType, $daysUsed);

            if ($leaveType->affects_balance) {
                $setting->decrement('paid_leave_balance', $daysUsed);
            }

            $leave->update([
                'leave_type_id' => $leaveType->id,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'days_used' => $daysUsed,
                'reason' => $validated['reason'] ?? null,
            ]);

            return $leave->refresh();
        });

        if (! $request->expectsJson()) {
            return back()->with('status', 'Leave entry updated.');
        }

        return response()->json(['leave' => $leave]);
    }

    public function destroy(Request $request, Leave $leave): JsonResponse|RedirectResponse
    {
        $this->abortUnlessOwned($request, $leave);

        DB::transaction(function () use ($leave, $request): void {
            if ($leave->leaveType->affects_balance) {
                $this->settingForUser($request)->increment('paid_leave_balance', $leave->days_used);
            }

            $leave->delete();
        });

        if (! $request->expectsJson()) {
            return back()->with('status', 'Leave entry deleted.');
        }

        return response()->json(status: 204);
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function rules(): array
    {
        return [
            'leave_type_id' => ['required', 'integer', 'exists:leave_types,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ];
    }

    private function leaveTypeForUser(Request $request, int $leaveTypeId): LeaveType
    {
        return LeaveType::query()
            ->whereBelongsTo($request->user())
            ->findOrFail($leaveTypeId);
    }

    private function settingForUser(Request $request): LeaveSetting
    {
        return LeaveSetting::query()->firstOrCreate(
            ['user_id' => $request->user()->id],
            [
                'paid_leave_balance' => 0,
                'last_accrued_year' => now()->year,
                'last_accrued_month' => now()->month,
            ],
        );
    }

    private function validateBalanceImpact(Request $request, LeaveType $leaveType, int $daysUsed): void
    {
        if (! $leaveType->affects_balance) {
            return;
        }

        if ($daysUsed === 0) {
            throw ValidationException::withMessages([
                'start_date' => ['Paid leave must include at least one weekday.'],
            ]);
        }

        $balance = (float) $this->settingForUser($request)->paid_leave_balance;

        if ($daysUsed > $balance) {
            throw ValidationException::withMessages([
                'leave_type_id' => ['Paid leave balance is insufficient.'],
            ]);
        }
    }

    private function abortUnlessOwned(Request $request, Leave $leave): void
    {
        abort_unless($leave->user_id === $request->user()->id, 404);
    }
}
