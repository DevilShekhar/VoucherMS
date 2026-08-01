<?php

namespace App\Exports;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FilteredVouchersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Voucher::with('vendor');

        // From Date
        if ($this->request->filled('from_date')) {
            $query->whereDate('purchase_date', '>=', $this->request->from_date);
        }

        // To Date
        if ($this->request->filled('to_date')) {
            $query->whereDate('purchase_date', '<=', $this->request->to_date);
        }

        // Vendor
        if ($this->request->filled('vendor_id')) {
            $query->where('vendor_id', $this->request->vendor_id);
        }

        // Status
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Voucher Code',
            'Vendor',
            'Purchase Date',
            'Expiry Date',
            'Purchase Price',
            'Cost',
            'Status',
            'Remarks',
            'Created Date',
        ];
    }

    public function map($voucher): array
{
    return [
        $voucher->voucher_code,

        $voucher->vendor
            ? $voucher->vendor->vendor_name
            : '-',

        $voucher->certification
            ? $voucher->certification->certification_name
            : '-',

        $voucher->purchase_date
            ? \Carbon\Carbon::parse($voucher->purchase_date)->format('d M Y')
            : '-',

        $voucher->expiry_date
            ? \Carbon\Carbon::parse($voucher->expiry_date)->format('d M Y')
            : '-',

        $voucher->purchase_price,

        $voucher->cost,

        $voucher->status,

        $voucher->remarks ?? '-',

        $voucher->created_at
            ? $voucher->created_at->format('d M Y')
            : '-',
    ];
}
}