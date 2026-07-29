<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeadsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Lead::with(['center', 'course', 'assignedUser'])->get();
    }

    public function headings(): array
    {
        return [
            'Lead ID',
            'Candidate Name',
            'Email',
            'Mobile',
            'Center',
            'Course',
            'Assigned To',
            'Status',
            'Created At',
        ];
    }

    public function map($lead): array
    {
        return [
            $lead->id,
            $lead->name,
            $lead->email,
            $lead->mobile,
            optional($lead->center)->name,
            optional($lead->course)->name,
            optional($lead->assignedUser)->name,
            $lead->status,
            $lead->created_at?->format('d M Y'),
        ];
    }
}
