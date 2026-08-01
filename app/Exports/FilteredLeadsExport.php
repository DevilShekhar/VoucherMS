<?php

namespace App\Exports;

use App\Models\Lead;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FilteredLeadsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Lead::with([
            'location',
            'center',
            'course',
            'assignedUser',
            'latestFollowup',
        ]);

        // Sales Executive
        if ($this->request->filled('executive_id')) {
            $query->where('assigned_to', $this->request->executive_id);
        }

        // Location
        if ($this->request->filled('location_id')) {
            $query->where('location_id', $this->request->location_id);
        }

        // From Date
        if ($this->request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $this->request->from_date);
        }

        // To Date
        if ($this->request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $this->request->to_date);
        }

        // Status
        if ($this->request->filled('status')) {
            $query->whereHas('latestFollowup', function ($q) {
                $q->where('status', $this->request->status);
            });
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Lead No',
            'Candidate Name',
            'Email',
            'Mobile',
            'Location',
            'Center',
            'Course',
            'Sales Executive',
            'Status',
            'Created Date',
        ];
    }

    public function map($lead): array
    {
        return [
            $lead->lead_no ?? '-',

            $lead->candidate_name ?? '-',

            $lead->email ?? '-',

            $lead->mobile ?? '-',

            optional($lead->location)->name ?? '-',

            optional($lead->center)->center_name ?? '-',

            optional($lead->course)->course_name ?? '-',

            optional($lead->assignedUser)->name ?? '-',

            optional($lead->latestFollowup)->status ?? ($lead->status ?? '-'),

            $lead->created_at
                ? Carbon::parse($lead->created_at)->format('d M Y')
                : '-',
        ];
    }
}