<x-layouts.app title="Work Tracker">
        <header class="flex flex-col gap-4 border-b border-zinc-300 pb-5 sm:flex-row sm:items-end sm:justify-between dark:border-zinc-800">
            <div>
                <p class="text-sm font-medium text-teal-700 dark:text-teal-400">{{ now()->format('F j, Y') }}</p>
                <h1 class="text-3xl font-semibold tracking-normal text-zinc-950 dark:text-zinc-50">Work Tracker</h1>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                <x-theme-toggle />
                <x-privacy-toggle />
                <span data-private class="rounded-md border border-zinc-300 bg-white px-3 py-2 transition duration-200 dark:border-zinc-700 dark:bg-zinc-900">{{ auth()->user()->email }}</span>
                <a href="{{ route('settings.edit') }}" class="rounded-md border border-zinc-300 bg-white px-3 py-2 font-semibold text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-md border border-zinc-300 bg-white px-3 py-2 font-semibold text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        Log out
                    </button>
                </form>
            </div>
        </header>

        <x-page-alerts />

        <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">Paid leave balance</p>
                <p class="mt-2 text-4xl font-semibold text-zinc-950 dark:text-zinc-50">{{ number_format((float) $leaveSetting->paid_leave_balance, 2) }}</p>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Last accrued {{ $leaveSetting->last_accrued_month }}/{{ $leaveSetting->last_accrued_year }}</p>
            </div>
            <div class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">Overtime hours</p>
                <p class="mt-2 text-4xl font-semibold text-zinc-950 dark:text-zinc-50">{{ number_format((float) $overtimeHours, 2) }}</p>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $overtimeEntries->count() }} entries</p>
            </div>
            <div class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">Earnings total</p>
                <p data-private class="mt-2 text-4xl font-semibold text-zinc-950 transition duration-200 dark:text-zinc-50">${{ number_format((float) $earningsTotal, 2) }}</p>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $earnings->count() }} records</p>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_1.4fr]">
            <div class="flex flex-col gap-6">
                <form method="POST" action="{{ route('leave-settings.update') }}" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    @csrf
                    @method('PUT')
                    <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Balance</h2>
                    <div class="mt-4 flex gap-3">
                        <label class="min-w-0 flex-1">
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Paid days</span>
                            <input name="paid_leave_balance" type="number" min="0" step="0.25" value="{{ old('paid_leave_balance', $leaveSetting->paid_leave_balance) }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <button class="mt-6 rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">Save</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('leaves.store') }}" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    @csrf
                    <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Leave</h2>
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Type</span>
                            <select name="leave_type_id" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                                @foreach ($leaveTypes as $leaveType)
                                    <option value="{{ $leaveType->id }}" @selected(old('leave_type_id') == $leaveType->id)>{{ str_replace('_', ' ', $leaveType->name) }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Start</span>
                            <input name="start_date" type="date" value="{{ old('start_date', now()->toDateString()) }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">End</span>
                            <input name="end_date" type="date" value="{{ old('end_date', now()->toDateString()) }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Reason</span>
                            <input name="reason" value="{{ old('reason') }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                    </div>
                    <button class="mt-4 rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">Add leave</button>
                </form>

                <form method="POST" action="{{ route('overtime-entries.store') }}" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    @csrf
                    <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Overtime</h2>
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Date</span>
                            <input name="work_date" type="date" value="{{ old('work_date', now()->toDateString()) }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Start</span>
                            <input name="start_time" type="time" value="{{ old('start_time', '17:00') }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">End</span>
                            <input name="end_time" type="time" value="{{ old('end_time', '19:00') }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                    </div>
                    <label class="mt-3 block">
                        <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Notes</span>
                        <input name="notes" value="{{ old('notes') }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                    </label>
                    <button class="mt-4 rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">Add overtime</button>
                </form>

                <form method="POST" action="{{ route('earnings.store') }}" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    @csrf
                    <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Earnings</h2>
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Pay date</span>
                            <input name="pay_date" type="date" value="{{ old('pay_date', now()->toDateString()) }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Currency</span>
                            <select name="currency" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                                <option value="SRD" @selected(old('currency', 'SRD') === 'SRD')>SRD</option>
                                <option value="USD" @selected(old('currency', 'SRD') === 'USD')>USD</option>
                            </select>
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Base</span>
                            <input name="base_amount" type="number" min="0" step="0.01" value="{{ old('base_amount', 0) }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Bonus</span>
                            <input name="bonus_amount" type="number" min="0" step="0.01" value="{{ old('bonus_amount', 0) }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label class="sm:col-span-2">
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Overtime pay</span>
                            <input name="overtime_pay_amount" type="number" min="0" step="0.01" value="{{ old('overtime_pay_amount', 0) }}" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                    </div>
                    <button class="mt-4 rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">Add earnings</button>
                </form>
            </div>

            <div class="flex flex-col gap-6">
                <section class="rounded-md border border-zinc-300 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                        <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Leave history</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-170 text-left text-sm">
                            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-950 dark:text-zinc-400">
                                <tr>
                                    <th class="px-5 py-3">Type</th>
                                    <th class="px-5 py-3">Dates</th>
                                    <th class="px-5 py-3">Days</th>
                                    <th class="px-5 py-3">Reason</th>
                                    <th class="px-5 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                @forelse ($leaves as $leave)
                                    <tr>
                                        <td class="px-5 py-3 font-medium">{{ str_replace('_', ' ', $leave->leaveType->name) }}</td>
                                        <td class="px-5 py-3 text-zinc-600 dark:text-zinc-300">{{ $leave->start_date->toDateString() }} to {{ $leave->end_date->toDateString() }}</td>
                                        <td class="px-5 py-3">{{ $leave->days_used }}</td>
                                        <td class="max-w-55 truncate px-5 py-3 text-zinc-600 dark:text-zinc-300">{{ $leave->reason ?: 'None' }}</td>
                                        <td class="px-5 py-3 text-right">
                                            <form method="POST" action="{{ route('leaves.destroy', $leave) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="rounded-md border border-red-300 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50 dark:border-red-800 dark:text-red-300 dark:hover:bg-red-950">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-zinc-500 dark:text-zinc-400">No leave entries</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div class="rounded-md border border-zinc-300 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                            <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Overtime</h2>
                        </div>
                        <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @forelse ($overtimeEntries as $entry)
                                <div class="px-5 py-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="font-medium">{{ $entry->work_date->toDateString() }}</p>
                                        <p class="text-sm font-semibold text-teal-700 dark:text-teal-400">{{ number_format((float) $entry->hours_worked, 2) }}h</p>
                                    </div>
                                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">{{ substr($entry->start_time, 0, 5) }} to {{ substr($entry->end_time, 0, 5) }}</p>
                                </div>
                            @empty
                                <p class="px-5 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">No overtime entries</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-md border border-zinc-300 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                            <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Earnings</h2>
                        </div>
                        <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @forelse ($earnings as $earning)
                                <div class="px-5 py-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="font-medium">{{ $earning->pay_date->toDateString() }}</p>
                                        <p data-private class="text-sm font-semibold text-teal-700 transition duration-200 dark:text-teal-400">{{ $earning->currency }} {{ number_format((float) $earning->base_amount + (float) $earning->bonus_amount + (float) $earning->overtime_pay_amount, 2) }}</p>
                                    </div>
                                    <p data-private class="mt-1 text-sm text-zinc-600 transition duration-200 dark:text-zinc-300">Base {{ number_format((float) $earning->base_amount, 2) }} · Bonus {{ number_format((float) $earning->bonus_amount, 2) }} · OT {{ number_format((float) $earning->overtime_pay_amount, 2) }}</p>
                                </div>
                            @empty
                                <p class="px-5 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">No earnings records</p>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>
        </section>
</x-layouts.app>


