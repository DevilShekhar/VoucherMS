<?php

namespace App\Http\Controllers\Admin;

use App\Models\VoucherVendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class VoucherVendorController extends Controller
{
    /**
     * Display Create Form
     */
    public function create()
    {
        return view('admin.voucher-vendors.create');
    }

    public function index()
    {
        $voucherVendors = VoucherVendor::query()->latest()->paginate(10);

        return view('admin.voucher-vendors.index', compact('voucherVendors'));
    }

    /**
     * Store Vendor
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        VoucherVendor::create($validated);

        return redirect()
            ->route('voucher-vendors.create')
            ->with('success', 'Voucher Vendor added successfully.');
    }

    public function edit($id)
    {
        $voucherVendor = VoucherVendor::findOrFail($id);

        return view('admin.voucher-vendors.edit', compact('voucherVendor'));
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $voucherVendor = VoucherVendor::findOrFail($id);
        $voucherVendor->update($validated);

        return redirect()
            ->route('voucher-vendors.index')
            ->with('success', 'Voucher Vendor udated successfully.');
    }

    public function destroy($id)
    {
        $vendor = VoucherVendor::findOrFail($id);

        $vendor->delete();

        return redirect()
            ->route('voucher-vendors.index')
            ->with('success', 'Voucher Vendor deleted successfully.');
    }
}
