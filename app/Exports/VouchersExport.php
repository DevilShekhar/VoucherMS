<?php

namespace App\Exports;

use App\Models\Voucher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class VouchersExport implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings
{
    public function collection()
    {
        return Voucher::with('vendor')->get()->map(function ($voucher) {
            return [
                'Voucher Code' => $voucher->voucher_code,
                'Vendor' => $voucher->vendor->vendor_name ?? '-',
                'Purchase Date' => $voucher->purchase_date,
                'Expiry Date' => $voucher->expiry_date,
                'Purchase Price' => $voucher->purchase_price,
                'Cost' => $voucher->cost,
                'Status' => $voucher->status,
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

                // =============================
                // Voucher Status Legend
                // =============================
                $sheet->setCellValue('I1', 'Voucher Status Legend');
                $sheet->getStyle('I1')->getFont()->setBold(true)->setSize(13);

                // Available
                $sheet->setCellValue('I2', 'Available');
                $sheet->getStyle('I2')->getFont()->getColor()->setARGB('008000');
                $sheet->getStyle('I2')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('I2')
                    ->getFill()
                    ->getStartColor()
                    ->setARGB('C6EFCE');

                // Allocated
                // Allocated
                $sheet->setCellValue('I3', 'Allocated');
                $sheet->getStyle('I3')->getFont()->getColor()->setARGB('1F4E78');
                $sheet->getStyle('I3')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('I3')
                    ->getFill()
                    ->getStartColor()
                    ->setARGB('D9EAF7');

                // Used
                $sheet->setCellValue('I4', 'Used');
                $sheet->getStyle('I4')->getFont()->getColor()->setARGB('FF0000');
                $sheet->getStyle('I4')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('I4')
                    ->getFill()
                    ->getStartColor()
                    ->setARGB('FFFFC7CE');
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
                    } elseif ($status == 'Available') {

                        // Green text with light green background
                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFont()
                            ->getColor()
                            ->setARGB('008000');

                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID);

                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->getStartColor()
                            ->setARGB('C6EFCE');
                    } elseif ($status == 'Allocated') {

                        // Blue text with light blue background
                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFont()
                            ->getColor()
                            ->setARGB('1F4E78');

                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID);

                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->getStartColor()
                            ->setARGB('D9EAF7');
                    }
                }
            },
        ];
    }
}
