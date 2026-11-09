<?php

namespace App\Services;

use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;

class LeaveCalculator
{
    public function weekdayDaysUsed(CarbonInterface|string $startDate, CarbonInterface|string $endDate): int
    {
        $daysUsed = 0;

        foreach (CarbonPeriod::create($startDate, $endDate) as $date) {
            if ($date->isWeekday()) {
                $daysUsed++;
            }
        }

        return $daysUsed;
    }
}
