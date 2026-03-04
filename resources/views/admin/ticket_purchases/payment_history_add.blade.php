@extends('admin.layout.app')

@section('admin-content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Add Payment</h1>
                    <p class="mt-1 text-sm text-slate-500">Add a new payment under this ticket purchase.</p>
                </div>

                <a href="{{ route('ticket_purchases.payment_history', $ticketPurchase->id) }}"
                   class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Back
                </a>
            </div>

            @if ($errors->any())
                <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Purchase Summary --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-1">
                <div class="text-sm font-bold text-slate-900">Purchase summary</div>

                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Net fare</span>
                        <span class="font-semibold text-slate-900">
                            {{ number_format((float) $ticketPurchase->net_fare, 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Paid (current)</span>
                        <span class="font-semibold text-slate-900">
                            {{ number_format((float) $ticketPurchase->paid_amount, 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Due (current)</span>
                        <span class="font-semibold text-slate-900">
                            {{ number_format((float) $ticketPurchase->due_amount, 2) }}
                        </span>
                    </div>
                </div>

                <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-600">
                    Tip: Add payments like cash/bKash/bank as separate entries for accurate tracking.
                </div>
            </div>

            {{-- Add Payment Form --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="text-sm font-bold text-slate-900">New payment</div>

                <form class="mt-5 space-y-4"
                      method="POST"
                      action="{{ route('ticket_purchases.payment_history.store', $ticketPurchase->id) }}">
                    @csrf

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Account</label>
                        <select name="account_id"
                                class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                                required>
                            <option value="">Select account</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" @selected(old('account_id') == $account->id)>
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="mt-1 text-xs text-slate-500">
                            Choose from where you paid (Cash/Bank/bKash).
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Paid amount</label>
                        <input type="number" name="paid" step="0.01" min="0.01"
                               value="{{ old('paid', 0) }}"
                               class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm outline-none ring-blue-200 focus:border-blue-300 focus:ring-4"
                               required>
                    </div>

                    <button type="submit"
                            class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                        Add payment
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection