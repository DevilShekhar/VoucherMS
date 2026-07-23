<?php

namespace App\Exports;

use App\Models\Voucher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class VouchersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        return Voucher::with('vendor')->get()->map(function ($voucher) {
            return [
                'Voucher Code'   => $voucher->voucher_code,
                'Vendor'         => $voucher->vendor->vendor_name ?? '-',
                'Purchase Date'  => $voucher->purchase_date,
                'Expiry Date'    => $voucher->expiry_date,
                'Purchase Price' => $voucher->purchase_price,
                'Cost'           => $voucher->cost,
                'Status'         => $voucher->status,
            ];
        });
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
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();

                // Make header bold
                $sheet->getStyle('A1:G1')->getFont()->setBold(true);

                // Highlight Used vouchers
                for ($row = 2; $row <= $highestRow; $row++) {

                    $status = $sheet->getCell("G{$row}")->getValue();

                    if ($status == 'Used') {

                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFont()
                            ->getColor()
                            ->setARGB('FF0000');

                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID);

                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->getStartColor()
                            ->setARGB('FFFFC7CE');
                    }
                }
            },
        ];
    }
}
