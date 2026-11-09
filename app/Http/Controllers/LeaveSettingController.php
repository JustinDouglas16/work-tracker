<?php

namespace App\Http\Controllers;

use App\Models\LeaveSetting;
use App\Services\LeaveAccrualService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeaveSettingController extends Controller
{
    public function show(Request $request, LeaveAccrualService $leaveAccrualService): JsonResponse
    {
        return response()->json([
            'leave_setting' => $leaveAccrualService->ensurePaidLeaveAccrued($request->user()),
        ]);
    }

    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'paid_leave_balance' => ['required', 'numeric', 'min:0'],
        ]);

        $setting = LeaveSetting::query()->firstOrCreate(
            ['user_id' => $request->user()->id],
            [
                'paid_leave_balance' => 0,
                'last_accrued_year' => now()->year,
                'last_accrued_month' => now()->month,
            ],
        );

        $setting->update([
            'paid_leave_balance' => $validated['paid_leave_balance'],
        ]);

        if (! $request->expectsJson()) {
            return back()->with('status', 'Paid leave balance updated.');
        }

        return response()->json(['leave_setting' => $setting->refresh()]);
    }
}
