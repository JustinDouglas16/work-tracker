<?php

namespace Database\Factories;

use App\Models\LeaveSetting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveSetting>
 */
class LeaveSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now = now();

        return [
            'user_id' => User::factory(),
            'paid_leave_balance' => 0,
            'last_accrued_year' => $now->year,
            'last_accrued_month' => $now->month,
        ];
    }
}
