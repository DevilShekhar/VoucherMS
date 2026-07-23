<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LeadsExport;
use App\Exports\VouchersExport;
use App\Http\Controllers\Controller;
use App\Models\LeadFollowUp;
use App\Models\Location;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Candidate;
use App\Models\Course;
use App\Models\ExamSchedule;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $locations = Location::orderBy('name')->get();

        // Today's Follow-ups
        $todayLeads = LeadFollowUp::with([
            'lead.assignedUser',
            'lead.course',
            'lead.location',
        ])
            ->whereDate('followup_date', today())
            ->when($request->location_id, function ($query) use ($request) {
                $query->whereHas('lead', function ($q) use ($request) {
                    $q->where('location_id', $request->location_id);
                });
            })
            ->latest('followup_date')
            ->get();

        // Dashboard Counts
        $counts = [
            'total' => LeadFollowUp::whereDate('followup_date', $today)->count(),
            'new' => LeadFollowUp::whereDate('followup_date', $today)->where('status', 'New')->count(),
            'contacted' => LeadFollowUp::whereDate('followup_date', $today)->where('status', 'Contacted')->count(),
            'interested' => LeadFollowUp::whereDate('followup_date', $today)->where('status', 'Interested')->count(),
            'not_interested' => LeadFollowUp::whereDate('followup_date', $today)->where('status', 'Not Interested')->count(),
            'converted' => LeadFollowUp::whereDate('followup_date', $today)->where('status', 'Converted')->count(),
            'closed' => LeadFollowUp::whereDate('followup_date', $today)->where('status', 'Closed')->count(),
        ];

        $totalStudents = Candidate::count();
        $activeCourses = Course::query()->where('status', 1)->count();
        $pendingLeads = LeadFollowUp::query()->where('status', '!=', 'Converted')
            ->where('status', '!=', 'Closed')
            ->count();

        $scheduledExams = ExamSchedule::query()->where('exam_status', 'Scheduled')
            ->count();


        $recentEnrollments = Candidate::with(['course', 'center'])
            ->latest()
            ->take(5)
            ->get();

        $vouchers = Voucher::with('vendor')->latest()->paginate(10);

        return view('dashboard', compact(
            'todayLeads',
            'counts',
            'vouchers',
            'locations',
            'totalStudents',
            'activeCourses',
            'pendingLeads',
            'scheduledExams',
            'recentEnrollments'
        ));
    }

    public function exportLeads()
    {
        return Excel::download(
            new LeadsExport,
            'Leads_'.now()->format('d-m-Y_H-i-s').'.xlsx'
        );
    }

    public function exportVouchers()
    {
        return Excel::download(
            new VouchersExport,
            'Vouchers_'.now()->format('d-m-Y_H-i-s').'.xlsx'
        );
    }
}
