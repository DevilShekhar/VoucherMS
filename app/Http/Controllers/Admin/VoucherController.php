<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\VoucherImport;
use App\Models\Voucher;
use App\Models\VoucherVendor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(30);

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
            'purchase_date' => 'required',
            'expiry_date' => 'required',
            'purchase_price' => 'required',
            'cost' => 'required',
        ]);

        $hash = hash('sha256', strtoupper(trim($request->voucher_code)));
        if (Voucher::query()->where('voucher_code_hash', $hash)->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'voucher_code' => 'This voucher code already exists.',
                ]);
        }
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

        return view('admin.vouchers.edit', compact('voucher', 'vendors'));
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

    public function dashboard()
    {
        $vouchers = Voucher::with('vendor')
            ->latest()
            ->paginate(20);

        return view('dashboard', compact('vouchers'));
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        VoucherImport::$duplicates = [];
        VoucherImport::$vendors = [];

        Excel::import(new VoucherImport, $request->file('file'));

        $message = '<strong>✅ Vouchers uploaded successfully.</strong>';

        if (! empty(VoucherImport::$duplicates)) {
            $message .= '
            <div class="mt-2">
                <span class="text-danger fw-bold">Duplicate Voucher Codes (Skipped):</span>
                <ul class="mb-0 text-danger">';

            foreach (VoucherImport::$duplicates as $code) {
                $message .= "<li>{$code}</li>";
            }

            $message .= '</ul></div>';
        }

        if (! empty(VoucherImport::$vendors)) {
            $vendors = array_filter(array_unique(VoucherImport::$vendors));

            if (count($vendors)) {
                $message .= '
                <div class="mt-2">
                    <span class="text-danger fw-bold">Vendor Not Found:</span>
                    <ul class="mb-0 text-danger">';

                foreach ($vendors as $vendor) {
                    $message .= "<li>{$vendor}</li>";
                }

                $message .= '</ul></div>';
            }
        }

        return redirect()
            ->route('vouchers.index')
            ->with('success', $message);
    }
}
