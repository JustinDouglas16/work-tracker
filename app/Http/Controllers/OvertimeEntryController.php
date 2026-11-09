<?php

namespace App\Http\Controllers;

use App\Models\OvertimeEntry;
use App\Services\OvertimeCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class OvertimeEntryController extends Controller
{
    public function store(Request $request, OvertimeCalculator $overtimeCalculator): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'work_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            $hoursWorked = $overtimeCalculator->hoursWorked($validated['start_time'], $validated['end_time']);
        } catch (InvalidArgumentException) {
            throw ValidationException::withMessages([
                'end_time' => ['End time must be different from start time.'],
            ]);
        }

        $entry = OvertimeEntry::query()->create([
            'user_id' => $request->user()->id,
            'work_date' => $validated['work_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'hours_worked' => $hoursWorked,
            'notes' => $validated['notes'] ?? null,
        ]);

        if (! $request->expectsJson()) {
            return back()->with('status', 'Overtime entry saved.');
        }

        return response()->json(['overtime_entry' => $entry], 201);
    }
}
