<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use InvalidArgumentException;

class OvertimeCalculator
{
    public function hoursWorked(string $startTime, string $endTime): float
    {
        if ($startTime === $endTime) {
            throw new InvalidArgumentException('Start time and end time must be different.');
        }

        $start = CarbonImmutable::parse('2000-01-01 '.$startTime);
        $end = CarbonImmutable::parse('2000-01-01 '.$endTime);

        if ($end->lessThan($start)) {
            $end = $end->addDay();
        }

        return round($start->diffInMinutes($end) / 60, 2);
    }
}
