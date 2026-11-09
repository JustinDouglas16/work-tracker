<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EarningController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveSettingController;
use App\Http\Controllers\OvertimeEntryController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::get('/leave-settings', [LeaveSettingController::class, 'show'])->name('leave-settings.show');
    Route::put('/leave-settings', [LeaveSettingController::class, 'update'])->name('leave-settings.update');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::put('/leaves/{leave}', [LeaveController::class, 'update'])->name('leaves.update');
    Route::delete('/leaves/{leave}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
    Route::post('/overtime-entries', [OvertimeEntryController::class, 'store'])->name('overtime-entries.store');
    Route::post('/earnings', [EarningController::class, 'store'])->name('earnings.store');
});
