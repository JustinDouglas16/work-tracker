<?php

namespace App\Services;

use App\Models\LeaveSetting;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

class LeaveAccrualService
{
    public function ensurePaidLeaveAccrued(User $user, ?CarbonInterface $now = null): LeaveSetting
    {
        $now ??= now();

        return DB::transaction(function () use ($now, $user): LeaveSetting {
            $setting = LeaveSetting::query()
                ->whereBelongsTo($user)
                ->lockForUpdate()
                ->first();

            if (! $setting) {
                return LeaveSetting::query()->create([
                    'user_id' => $user->id,
                    'paid_leave_balance' => 0,
                    'last_accrued_year' => $now->year,
                    'last_accrued_month' => $now->month,
                ]);
            }

            $monthsMissed = $this->monthsBetween(
                $setting->last_accrued_year,
                $setting->last_accrued_month,
                $now->year,
                $now->month,
            );

            if ($monthsMissed > 0) {
                $setting->update([
                    'paid_leave_balance' => (float) $setting->paid_leave_balance + $monthsMissed,
                    'last_accrued_year' => $now->year,
                    'last_accrued_month' => $now->month,
                ]);
            }

            return $setting->refresh();
        });
    }

    public function monthsBetween(int $lastYear, int $lastMonth, int $nowYear, int $nowMonth): int
    {
        return max(0, (($nowYear * 12) + $nowMonth) - (($lastYear * 12) + $lastMonth));
    }
}
