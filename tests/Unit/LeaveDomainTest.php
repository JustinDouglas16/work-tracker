<?php

use App\Services\LeaveAccrualService;
use App\Services\LeaveCalculator;
use App\Services\OvertimeCalculator;

it('calculates missed accrual months', function (): void {
    $service = new LeaveAccrualService();

    expect($service->monthsBetween(2026, 6, 2026, 6))->toBe(0)
        ->and($service->monthsBetween(2026, 5, 2026, 6))->toBe(1)
        ->and($service->monthsBetween(2026, 3, 2026, 6))->toBe(3);
});

it('counts weekdays used across an inclusive date range', function (): void {
    $calculator = new LeaveCalculator();

    expect($calculator->weekdayDaysUsed('2026-06-01', '2026-06-07'))->toBe(5)
        ->and($calculator->weekdayDaysUsed('2026-06-06', '2026-06-07'))->toBe(0);
});

it('computes overtime including crossing midnight', function (): void {
    $calculator = new OvertimeCalculator();

    expect($calculator->hoursWorked('08:00', '13:00'))->toBe(5.0)
        ->and($calculator->hoursWorked('22:00', '02:00'))->toBe(4.0);
});

it('rejects identical overtime start and end times', function (): void {
    (new OvertimeCalculator())->hoursWorked('08:00', '08:00');
})->throws(InvalidArgumentException::class);
