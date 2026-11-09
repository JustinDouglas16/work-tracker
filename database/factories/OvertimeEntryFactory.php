<?php

namespace Database\Factories;

use App\Models\OvertimeEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OvertimeEntry>
 */
class OvertimeEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'work_date' => fake()->date(),
            'start_time' => '17:00',
            'end_time' => '19:00',
            'hours_worked' => 2,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
