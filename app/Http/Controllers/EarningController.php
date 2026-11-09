<?php

namespace App\Http\Controllers;

use App\Models\Earning;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'pay_date' => ['required', 'date'],
            'base_amount' => ['required', 'numeric', 'min:0'],
            'bonus_amount' => ['nullable', 'numeric', 'min:0'],
            'overtime_pay_amount' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'size:3'],
        ]);

        $earning = Earning::query()->create([
            'user_id' => $request->user()->id,
            'pay_date' => $validated['pay_date'],
            'base_amount' => $validated['base_amount'],
            'bonus_amount' => $validated['bonus_amount'] ?? 0,
            'overtime_pay_amount' => $validated['overtime_pay_amount'] ?? 0,
            'currency' => strtoupper($validated['currency'] ?? 'USD'),
        ]);

        if (! $request->expectsJson()) {
            return back()->with('status', 'Earnings record saved.');
        }

        return response()->json(['earning' => $earning], 201);
    }
}
