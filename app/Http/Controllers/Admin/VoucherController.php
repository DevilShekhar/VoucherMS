<?php

namespace App\Http\Controllers\Admin;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\VoucherVendor;

use App\Http\Controllers\Controller;


class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(10);

        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $vendors = VoucherVendor::orderBy('vendor_name')->get();
        

        return view('admin.vouchers.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required',
            'vendor_id' => 'required',
           
        ]);

        Voucher::create($request->all());

        return redirect()
            ->route('vouchers.index')
            ->with('success', 'Voucher created successfully.');
    }

    public function show(Voucher $voucher)
    {
        return view('admin.vouchers.show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
         $vendors = VoucherVendor::orderBy('vendor_name')->get();
        return view('admin.vouchers.edit', compact('voucher','vendors'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'voucher_code' => 'required',
            'vendor_id' => 'required',
            
        ]);

        $voucher->update($request->all());

        return redirect()
            ->route('vouchers.index')
            ->with('success', 'Voucher updated successfully.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()
            ->route('vouchers.index')
            ->with('success', 'Voucher deleted successfully.');
    }
}