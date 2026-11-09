<?php

namespace App\Http\Controllers;

use App\Models\Earning;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\OvertimeEntry;
use App\Services\LeaveAccrualService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(Request $request, LeaveAccrualService $leaveAccrualService): JsonResponse|View
    {
        $user = $request->user();
        $setting = $leaveAccrualService->ensurePaidLeaveAccrued($user);

        $leaveCount = Leave::query()
            ->whereBelongsTo($user)
            ->count();
        $overtimeHours = OvertimeEntry::query()
            ->whereBelongsTo($user)
            ->sum('hours_worked');
        $earningsTotal = Earning::query()
            ->whereBelongsTo($user)
            ->selectRaw('COALESCE(SUM(base_amount + bonus_amount + overtime_pay_amount), 0) as total')
            ->value('total');

        if ($request->expectsJson()) {
            return response()->json([
                'leave_setting' => $setting,
                'leave_count' => $leaveCount,
                'overtime_hours' => $overtimeHours,
                'earnings_total' => $earningsTotal,
            ]);
        }

        $leaves = Leave::query()
            ->with('leaveType')
            ->whereBelongsTo($user)
            ->latest()
            ->get();
        $overtimeEntries = OvertimeEntry::query()
            ->whereBelongsTo($user)
            ->latest('work_date')
            ->get();
        $earnings = Earning::query()
            ->whereBelongsTo($user)
            ->latest('pay_date')
            ->get();

        return view('dashboard', [
            'earnings' => $earnings,
            'earningsTotal' => $earningsTotal,
            'leaves' => $leaves,
            'leaveSetting' => $setting,
            'leaveTypes' => LeaveType::query()->whereBelongsTo($user)->orderBy('name')->get(),
            'overtimeEntries' => $overtimeEntries,
            'overtimeHours' => $overtimeHours,
        ]);
    }
}
