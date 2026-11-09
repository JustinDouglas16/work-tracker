<?php

use App\Models\Earning;
use App\Models\Leave;
use App\Models\LeaveSetting;
use App\Models\LeaveType;
use App\Models\OvertimeEntry;
use App\Models\User;
use Database\Seeders\JustinUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use PragmaRX\Google2FA\Google2FA;

uses(RefreshDatabase::class);

it('offers SRD and USD with SRD selected for new earnings', function (): void {
    $this->actingAs(User::factory()->create())
        ->get(route('dashboard'))
        ->assertSuccessful()
        ->assertSee('<select name="currency"', false)
        ->assertSee('<option value="SRD" selected>SRD</option>', false)
        ->assertSee('<option value="USD" >USD</option>', false)
        ->assertDontSee('<input name="currency"', false);
});

it('preserves the currency selection after earnings validation fails', function (string $currency): void {
    $this->actingAs(User::factory()->create())
        ->from(route('dashboard'))
        ->post(route('earnings.store'), [
            'pay_date' => '2026-11-09',
            'base_amount' => -1,
            'currency' => $currency,
        ])
        ->assertRedirect(route('dashboard'))
        ->assertSessionHasErrors('base_amount')
        ->assertSessionHasInput('currency', $currency);

    $this->get(route('dashboard'))
        ->assertSuccessful()
        ->assertSee('<option value="'.$currency.'" selected>'.$currency.'</option>', false);

    expect(Earning::query()->count())->toBe(0);
})->with(['SRD', 'USD']);

it('defaults omitted and blank earnings currencies to SRD', function (array $currencyInput): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('earnings.store'), [
            'pay_date' => '2026-11-09',
            'base_amount' => 100,
            ...$currencyInput,
        ])
        ->assertCreated()
        ->assertJsonPath('earning.currency', 'SRD');

    expect($user->earnings()->sole()->currency)->toBe('SRD');
})->with([
    'omitted' => [[]],
    'null' => [['currency' => null]],
    'blank' => [['currency' => '']],
]);

it('stores the selected earnings currency and uppercases supplied codes', function (string $currency, string $storedCurrency): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('earnings.store'), [
            'pay_date' => '2026-11-09',
            'base_amount' => 100,
            'currency' => $currency,
        ])
        ->assertCreated()
        ->assertJsonPath('earning.currency', $storedCurrency);

    expect($user->earnings()->sole()->currency)->toBe($storedCurrency);
})->with([
    ['SRD', 'SRD'],
    ['USD', 'USD'],
    ['usd', 'USD'],
]);

it('defaults new earning models and factory records to SRD', function (): void {
    expect((new Earning)->currency)->toBe('SRD')
        ->and(Earning::factory()->create()->refresh()->currency)->toBe('SRD');
});

it('changes the database currency default without relabeling stored earnings', function (): void {
    $migration = require database_path('migrations/2026_11_09_133008_change_earnings_currency_default_to_srd.php');
    $migration->down();

    $earning = Earning::factory()->create(['currency' => 'USD']);
    $migration->up();

    $earningId = DB::table((new Earning)->getTable())->insertGetId([
        'user_id' => $earning->user_id,
        'pay_date' => '2026-11-09',
    ]);

    expect($earning->refresh()->currency)->toBe('USD')
        ->and(Earning::query()->findOrFail($earningId)->currency)->toBe('SRD');

    $migration->down();

    expect($earning->refresh()->currency)->toBe('USD')
        ->and(Earning::query()->findOrFail($earningId)->currency)->toBe('SRD');

    $migration->up();
});

it('shows a login screen and can log out', function (): void {
    $this->seed(JustinUserSeeder::class);

    $this->get(route('login'))
        ->assertSuccessful()
        ->assertSee('Log in')
        ->assertSee('data-theme-toggle', false);

    $this->post(route('login.store'), [
        'login' => 'justin',
        'password' => 'H5jMAQRfQ*2kmmXe!Jo5AF3!',
    ])
        ->assertRedirect(route('dashboard'));

    $this->post(route('logout'))
        ->assertRedirect('/');
});

it('shows the theme toggle on authenticated pages', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertSuccessful()
        ->assertSee('data-theme-toggle', false);

    $this->actingAs($user)
        ->get(route('settings.edit'))
        ->assertSuccessful()
        ->assertSee('data-theme-toggle', false);
});

it('marks dashboard sensitive values for privacy mode', function (): void {
    $user = User::factory()->create();
    Earning::factory()->for($user)->create([
        'base_amount' => 100,
        'bonus_amount' => 25,
        'overtime_pay_amount' => 10,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertSuccessful()
        ->assertSee('data-privacy-toggle', false)
        ->assertSee('data-private', false)
        ->assertSee($user->email)
        ->assertSee('$135.00')
        ->assertSee('SRD 135.00')
        ->assertSee('Base 100.00');
});

it('requires a two factor code after password when enabled', function (): void {
    $this->seed(JustinUserSeeder::class);
    $user = User::query()->where('username', 'justin')->firstOrFail();
    $secret = 'JBSWY3DPEHPK3PXP';

    app(EnableTwoFactorAuthentication::class)($user, true);
    $user->forceFill([
        'two_factor_secret' => encrypt($secret),
    ])->save();
    app(ConfirmTwoFactorAuthentication::class)(
        $user,
        app(Google2FA::class)->getCurrentOtp($secret),
    );

    $this->post(route('login.store'), [
        'login' => 'justin',
        'password' => 'H5jMAQRfQ*2kmmXe!Jo5AF3!',
    ])
        ->assertRedirect(route('two-factor.login'));

    $this->get(route('two-factor.login'))
        ->assertSuccessful()
        ->assertSee('Enter your code')
        ->assertSee('resources/js/app.js');
});

it('accrues missed paid leave months when dashboard is opened', function (): void {
    Carbon::setTestNow('2026-06-03');
    $user = User::factory()->create();
    LeaveSetting::factory()->for($user)->create([
        'paid_leave_balance' => 2,
        'last_accrued_year' => 2026,
        'last_accrued_month' => 3,
    ]);

    $this->actingAs($user)
        ->getJson(route('dashboard'))
        ->assertSuccessful()
        ->assertJsonPath('leave_setting.paid_leave_balance', '5.00')
        ->assertJsonPath('leave_setting.last_accrued_month', 6);

    $this->actingAs($user)
        ->getJson(route('dashboard'))
        ->assertSuccessful()
        ->assertJsonPath('leave_setting.paid_leave_balance', '5.00');
});

it('returns dashboard summary totals without requiring history rendering', function (): void {
    $user = User::factory()->create();
    LeaveSetting::factory()->for($user)->create(['paid_leave_balance' => 4]);
    $leaveType = LeaveType::factory()->for($user)->create(['affects_balance' => true]);
    Leave::factory()->for($user)->for($leaveType)->count(2)->create();
    OvertimeEntry::factory()->for($user)->create(['hours_worked' => 1.25]);
    OvertimeEntry::factory()->for($user)->create(['hours_worked' => 2.50]);
    Earning::factory()->for($user)->create([
        'base_amount' => 100,
        'bonus_amount' => 25,
        'overtime_pay_amount' => 10,
    ]);
    Earning::factory()->for($user)->create([
        'base_amount' => 50,
        'bonus_amount' => 0,
        'overtime_pay_amount' => 5,
    ]);

    $this->actingAs($user)
        ->getJson(route('dashboard'))
        ->assertSuccessful()
        ->assertJsonPath('leave_count', 2)
        ->assertJsonPath('overtime_hours', 3.75)
        ->assertJsonPath('earnings_total', 190);
});

it('updates paid leave balance manually and rejects negative values', function (): void {
    $user = User::factory()->create();
    LeaveSetting::factory()->for($user)->create(['paid_leave_balance' => 1]);

    $this->actingAs($user)
        ->putJson(route('leave-settings.update'), ['paid_leave_balance' => 3])
        ->assertSuccessful()
        ->assertJsonPath('leave_setting.paid_leave_balance', '3.00');

    $this->actingAs($user)
        ->putJson(route('leave-settings.update'), ['paid_leave_balance' => -1])
        ->assertStatus(422);

    expect($user->leaveSetting()->first()->paid_leave_balance)->toBe('3.00');
});

it('creates paid leave using weekdays and deducts balance', function (): void {
    $user = User::factory()->create();
    LeaveSetting::factory()->for($user)->create(['paid_leave_balance' => 5]);
    $leaveType = LeaveType::factory()->for($user)->create([
        'name' => 'paid_leave',
        'affects_balance' => true,
    ]);

    $this->actingAs($user)
        ->postJson(route('leaves.store'), [
            'leave_type_id' => $leaveType->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-07',
        ])
        ->assertCreated()
        ->assertJsonPath('leave.days_used', 5);

    expect($user->leaveSetting()->first()->paid_leave_balance)->toBe('0.00');
});

it('rejects weekend only paid leave and insufficient balance', function (): void {
    $user = User::factory()->create();
    LeaveSetting::factory()->for($user)->create(['paid_leave_balance' => 1]);
    $leaveType = LeaveType::factory()->for($user)->create(['affects_balance' => true]);

    $this->actingAs($user)
        ->postJson(route('leaves.store'), [
            'leave_type_id' => $leaveType->id,
            'start_date' => '2026-06-06',
            'end_date' => '2026-06-07',
        ])
        ->assertStatus(422);

    $this->actingAs($user)
        ->postJson(route('leaves.store'), [
            'leave_type_id' => $leaveType->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-02',
        ])
        ->assertStatus(422);

    expect($user->leaveSetting()->first()->paid_leave_balance)->toBe('1.00')
        ->and(Leave::query()->count())->toBe(0);
});

it('stores emergency leave without changing paid balance', function (): void {
    $user = User::factory()->create();
    LeaveSetting::factory()->for($user)->create(['paid_leave_balance' => 1]);
    $leaveType = LeaveType::factory()->for($user)->create([
        'name' => 'emergency',
        'affects_balance' => false,
    ]);

    $this->actingAs($user)
        ->postJson(route('leaves.store'), [
            'leave_type_id' => $leaveType->id,
            'start_date' => '2026-06-06',
            'end_date' => '2026-06-07',
        ])
        ->assertCreated()
        ->assertJsonPath('leave.days_used', 0);

    expect($user->leaveSetting()->first()->paid_leave_balance)->toBe('1.00');
});

it('restores balance when paid leave is deleted', function (): void {
    $user = User::factory()->create();
    LeaveSetting::factory()->for($user)->create(['paid_leave_balance' => 0]);
    $leaveType = LeaveType::factory()->for($user)->create(['affects_balance' => true]);
    $leave = Leave::factory()->for($user)->for($leaveType)->create(['days_used' => 2]);

    $this->actingAs($user)
        ->deleteJson(route('leaves.destroy', $leave))
        ->assertNoContent();

    expect($user->leaveSetting()->first()->paid_leave_balance)->toBe('2.00');
});

it('computes overtime across midnight and rejects identical times', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('overtime-entries.store'), [
            'work_date' => '2026-06-03',
            'start_time' => '22:00',
            'end_time' => '02:00',
        ])
        ->assertCreated()
        ->assertJsonPath('overtime_entry.hours_worked', '4.00');

    $this->actingAs($user)
        ->postJson(route('overtime-entries.store'), [
            'work_date' => '2026-06-03',
            'start_time' => '08:00',
            'end_time' => '08:00',
        ])
        ->assertStatus(422);
});

it('denies unauthenticated and cross-user access', function (): void {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $leaveType = LeaveType::factory()->for($owner)->create(['affects_balance' => true]);
    $leave = Leave::factory()->for($owner)->for($leaveType)->create();

    $this->getJson(route('dashboard'))->assertUnauthorized();

    $this->actingAs($other)
        ->deleteJson(route('leaves.destroy', $leave))
        ->assertNotFound();

    $this->actingAs($other)
        ->postJson(route('leaves.store'), [
            'user_id' => $owner->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-01',
        ])
        ->assertNotFound();
});
