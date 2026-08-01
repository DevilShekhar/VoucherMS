<?php

namespace App\Exports;

use App\Models\Voucher;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class FilteredVouchersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Voucher::with([
            'vendor',
            'voucherRequests.center',
            'voucherRequests.requestedBy',
        ]);

        if ($this->request->filled('from_date')) {
            $query->whereDate('purchase_date', '>=', $this->request->from_date);
        }

        if ($this->request->filled('to_date')) {
            $query->whereDate('purchase_date', '<=', $this->request->to_date);
        }

        if ($this->request->filled('vendor_id')) {
            $query->where('vendor_id', $this->request->vendor_id);
        }

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
            'Center Name',
            'Sales Executive',
        ];
    }

    public function map($voucher): array
    {
        $voucherRequest = $voucher->voucherRequests->first();

        return [

            $voucher->voucher_code,

            $voucher->vendor
                ? $voucher->vendor->vendor_name
                : '-',

            $voucher->purchase_date
                ? Carbon::parse($voucher->purchase_date)->format('d M Y')
                : '-',

            $voucher->expiry_date
                ? Carbon::parse($voucher->expiry_date)->format('d M Y')
                : '-',

            number_format($voucher->purchase_price, 2),

            number_format($voucher->cost, 2),

            $voucher->status,

            $voucherRequest && $voucherRequest->center
                ? $voucherRequest->center->center_name
                : '-',

            $voucherRequest && $voucherRequest->requestedBy
                ? $voucherRequest->requestedBy->name
                : '-',
        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();

                // Header
                $sheet->getStyle('A1:I1')->getFont()->setBold(true);

                // Legend Title
                $sheet->setCellValue('K1', 'Voucher Status Legend');
                $sheet->getStyle('K1')->getFont()->setBold(true)->setSize(13);

                // Available
                $sheet->setCellValue('K2', 'Available');
                $sheet->getStyle('K2')->getFont()->getColor()->setARGB('008000');
                $sheet->getStyle('K2')->getFill()->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('K2')->getFill()->getStartColor()->setARGB('C6EFCE');

                // Allocated
                $sheet->setCellValue('K3', 'Allocated');
                $sheet->getStyle('K3')->getFont()->getColor()->setARGB('1F4E78');
                $sheet->getStyle('K3')->getFill()->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('K3')->getFill()->getStartColor()->setARGB('D9EAF7');

                // Used
                $sheet->setCellValue('K4', 'Used');
                $sheet->getStyle('K4')->getFont()->getColor()->setARGB('FF0000');
                $sheet->getStyle('K4')->getFill()->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('K4')->getFill()->getStartColor()->setARGB('FFC7CE');

                // Expired
                $sheet->setCellValue('K5', 'Expired');
                $sheet->getStyle('K5')->getFont()->getColor()->setARGB('9C6500');
                $sheet->getStyle('K5')->getFill()->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('K5')->getFill()->getStartColor()->setARGB('FFEB9C');

                // Cancelled
                $sheet->setCellValue('K6', 'Cancelled');
                $sheet->getStyle('K6')->getFont()->getColor()->setARGB('FFFFFF');
                $sheet->getStyle('K6')->getFill()->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('K6')->getFill()->getStartColor()->setARGB('808080');

                // Apply Row Colors
                for ($row = 2; $row <= $highestRow; $row++) {

                    $status = $sheet->getCell("G{$row}")->getValue();

                    switch ($status) {

                        case 'Available':
                            $fontColor = '008000';
                            $bgColor = 'C6EFCE';
                            break;

                        case 'Allocated':
                            $fontColor = '1F4E78';
                            $bgColor = 'D9EAF7';
                            break;

                        case 'Used':
                            $fontColor = 'FF0000';
                            $bgColor = 'FFC7CE';
                            break;

                        case 'Expired':
                            $fontColor = '9C6500';
                            $bgColor = 'FFEB9C';
                            break;

                        case 'Cancelled':
                            $fontColor = 'FFFFFF';
                            $bgColor = '808080';
                            break;

                        default:
                            continue 2;
                    }

                    $sheet->getStyle("A{$row}:I{$row}")
                        ->getFont()
                        ->getColor()
                        ->setARGB($fontColor);

                    $sheet->getStyle("A{$row}:I{$row}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID);

                    $sheet->getStyle("A{$row}:I{$row}")
                        ->getFill()
                        ->getStartColor()
                        ->setARGB($bgColor);
                }
            },

        ];
    }
}