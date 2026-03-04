@extends('admin.layout.app')
@section('admin-content')
    <!-- Greeting card -->
    @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
        $displayName = auth()->user()?->name ?? 'admin';
        $range = $range ?? '7d';
        $scope = $scope ?? 'all';
    @endphp

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="text-lg font-bold">{{ $greeting }}, {{ $displayName }} 👋</div>
                <div class="text-sm text-slate-500">
                    Here's your overview for {{ now()->format('F j, Y') }}.
                </div>
            </div>

            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-center gap-2">
                <select name="range" onchange="this.form.submit()"
                    class="w-full sm:w-auto rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 outline-none ring-blue-200 focus:ring-4">
                    <option value="7d" {{ $range === '7d' ? 'selected' : '' }}>Last 7 days</option>
                    <option value="30d" {{ $range === '30d' ? 'selected' : '' }}>Last 30 days</option>
                    <option value="month" {{ $range === 'month' ? 'selected' : '' }}>This month</option>
                </select>
                <select name="scope" onchange="this.form.submit()"
                    class="w-full sm:w-auto rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 outline-none ring-blue-200 focus:ring-4">
                    <option value="my" {{ $scope === 'my' ? 'selected' : '' }}>My data</option>
                    <option value="team" {{ $scope === 'team' ? 'selected' : '' }}>Team</option>
                    <option value="all" {{ $scope === 'all' ? 'selected' : '' }}>All</option>
                </select>
            </form>
        </div>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-slate-500">Total Income</div>
            <div class="mt-2 text-2xl font-bold text-slate-900">
                {{ number_format($totalIncome ?? 0, 2) }}
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-slate-500">Total Expense</div>
            <div class="mt-2 text-2xl font-bold text-slate-900">
                {{ number_format($totalExpense ?? 0, 2) }}
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-slate-500">Total Account Balance</div>
            <div class="mt-2 text-2xl font-bold text-slate-900">
                {{ number_format($totalAccountBalance ?? 0, 2) }}
            </div>
        </div>
    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="text-base font-semibold text-slate-900">Account Balances</div>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-500">
                        <th class="px-2 py-2 font-semibold">Account</th>
                        <th class="px-2 py-2 font-semibold">Type</th>
                        <th class="px-2 py-2 text-right font-semibold">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($accounts ?? [] as $account)
                        <tr class="border-b border-slate-100">
                            <td class="px-2 py-2 font-medium text-slate-800">{{ $account->name }}</td>
                            <td class="px-2 py-2 text-slate-600">{{ ucfirst($account->type ?? 'n/a') }}</td>
                            <td class="px-2 py-2 text-right font-semibold text-slate-900">
                                {{ number_format($account->current_balance ?? 0, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-2 py-4 text-center text-slate-500" colspan="3">No accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
