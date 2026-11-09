<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $qrCodeSvg = null;
        $secretKey = null;

        if ($user->two_factor_secret && ! $user->hasEnabledTwoFactorAuthentication()) {
            $qrCodeSvg = $user->twoFactorQrCodeSvg();
            $secretKey = decrypt($user->two_factor_secret);
        }

        return view('settings', [
            'qrCodeSvg' => $qrCodeSvg,
            'secretKey' => $secretKey,
            'twoFactorEnabled' => $user->hasEnabledTwoFactorAuthentication(),
            'twoFactorPending' => $user->two_factor_secret && ! $user->hasEnabledTwoFactorAuthentication(),
        ]);
    }
}
