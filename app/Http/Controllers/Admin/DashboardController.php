<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LeadsExport;
use App\Exports\VouchersExport;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Course;
use App\Models\ExamSchedule;
use App\Models\LeadFollowUp;
use App\Models\Location;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $leadFollowupQuery = LeadFollowUp::query();

        if (Auth::user()->role_id == 4) {
            $leadFollowupQuery->whereHas('lead', function ($q) {
                $q->where('assigned_to', Auth::id());
            });
        }
        $locations = Location::orderBy('name')->get();
        $todayLeads = (clone $leadFollowupQuery)
            ->with([
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
            'total' => (clone $leadFollowupQuery)
                ->whereDate('followup_date', $today)
                ->count(),

            'new' => (clone $leadFollowupQuery)
                ->whereDate('followup_date', $today)
                ->where('status', 'New')
                ->count(),

            'contacted' => (clone $leadFollowupQuery)
                ->whereDate('followup_date', $today)
                ->where('status', 'Contacted')
                ->count(),

            'interested' => (clone $leadFollowupQuery)
                ->whereDate('followup_date', $today)
                ->where('status', 'Interested')
                ->count(),

            'not_interested' => (clone $leadFollowupQuery)
                ->whereDate('followup_date', $today)
                ->where('status', 'Not Interested')
                ->count(),

            'converted' => (clone $leadFollowupQuery)
                ->whereDate('followup_date', $today)
                ->where('status', 'Converted')
                ->count(),

            'closed' => (clone $leadFollowupQuery)
                ->whereDate('followup_date', $today)
                ->where('status', 'Closed')
                ->count(),
        ];

        $totalStudentsQuery = Candidate::query();

        if (Auth::user()->role_id == 4) {
            $totalStudentsQuery->where('executive_id', Auth::id()); // or assigned_to if that's your column
        }

        $totalStudents = $totalStudentsQuery->count();
        $activeCourses = Course::query()->where('status', 1)->count();
        $pendingLeadQuery = LeadFollowUp::query();

        if (Auth::user()->role_id == 4) {
            $pendingLeadQuery->whereHas('lead', function ($q) {
                $q->where('assigned_to', Auth::id());
            });
        }

        $pendingLeads = $pendingLeadQuery
            ->whereNotIn('status', ['Converted', 'Closed'])
            ->count();

        $scheduledExams = ExamSchedule::query()->where('exam_status', 'Scheduled')
            ->count();

        $recentEnrollments = Candidate::with(['course', 'center'])
            ->when(Auth::user()->role_id == 4, function ($query) {
                $query->where('executive_id', Auth::id()); // or assigned_to
            })
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
