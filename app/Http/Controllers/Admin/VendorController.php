<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketPurchases;
use App\Models\Vendors;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function index(Request $request): View
    {
        $vendors = Vendors::latest()->get();

        return view('admin.vendors.index', [
            'vendors' => $vendors,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:2000'],
        ]);

        Vendors::create($validated);

        return redirect()
            ->route('vendors.index')
            ->with('success', 'Vendor created successfully.');
    }

    public function edit(Request $request, int $vendor): View
    {
        $vendor = Vendors::findOrFail($vendor);

        return view('admin.vendors.edit', [
            'vendor' => $vendor,
        ]);
    }

    public function update(Request $request, int $vendor): RedirectResponse
    {
        $vendor = Vendors::findOrFail($vendor);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:2000'],
        ]);

        $vendor->update($validated);

        return redirect()
            ->route('vendors.index')
            ->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Request $request, int $vendor): RedirectResponse
    {
        $vendor = Vendors::findOrFail($vendor);
        $vendor->delete();

        return redirect()
            ->route('vendors.index')
            ->with('success', 'Vendor deleted successfully.');
    }


    public function history(Request $request, int $vendor): View
    {
        $vendor = Vendors::findOrFail($vendor);

        $ticketPurchases = TicketPurchases::with([
            'customer:id,name',
            'account:id,name',
        ])
            ->where('vendor_id', $vendor->id)
            ->latest()
            ->get();

        $totalTickets = $ticketPurchases->count();
        $totalPaid = (float) $ticketPurchases->sum('paid_amount');
        $totalDue = (float) $ticketPurchases->sum('due_amount');

        return view('admin.vendors.history', [
            'vendor' => $vendor,
            'ticketPurchases' => $ticketPurchases,
            'totalTickets' => $totalTickets,
            'totalPaid' => $totalPaid,
            'totalDue' => $totalDue,
        ]);
    }
}
