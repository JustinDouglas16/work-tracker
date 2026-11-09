<?php

namespace Database\Seeders;

use App\Models\LeaveSetting;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class JustinUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'justin@bitdynamics.sr'],
            [
                'name' => 'Justin',
                'username' => 'justin',
                'password' => Hash::make('H5jMAQRfQ*2kmmXe!Jo5AF3!'),
                'email_verified_at' => now(),
            ],
        );

        LeaveSetting::query()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'paid_leave_balance' => 0,
                'last_accrued_year' => now()->year,
                'last_accrued_month' => now()->month,
            ],
        );

        foreach ([
            'paid_leave' => true,
            'vacation' => true,
            'emergency' => false,
        ] as $name => $affectsBalance) {
            LeaveType::query()->updateOrCreate(
                ['user_id' => $user->id, 'name' => $name],
                ['affects_balance' => $affectsBalance],
            );
        }
    }
}
