<?php

namespace Database\Factories;

use App\Models\Earning;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Earning>
 */
class EarningFactory extends Factory
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
            'pay_date' => fake()->date(),
            'base_amount' => fake()->randomFloat(2, 1000, 5000),
            'bonus_amount' => fake()->randomFloat(2, 0, 500),
            'overtime_pay_amount' => fake()->randomFloat(2, 0, 300),
            'currency' => 'USD',
        ];
    }
}
