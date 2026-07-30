<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LeadsExport;
use App\Exports\VouchersExport;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Course;
use App\Models\ExamSchedule;
use App\Models\Lead;
use App\Models\LeadFollowUp;
use App\Models\Location;
use App\Models\Payment;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $voucherPurchaseQuery = Voucher::query();
        $totalVoucherPurchase = $voucherPurchaseQuery->sum('purchase_price');
        $paymentQuery = Payment::query();
        if (Auth::user()->role_id == 4) {
            $paymentQuery->whereHas('candidate', function ($q) {
                $q->where('executive_id', Auth::id());
            });
        }
        $totalSellingAmount = $paymentQuery->sum('paid_amount');
        $totalEarning = $totalSellingAmount - $totalVoucherPurchase;

        $voucherQuery = Voucher::query();
        $totalVouchers = $voucherQuery->count();
        $availableCount = Voucher::query()->where('status', 'Available')->count();
        $allocatedCount = Voucher::query()->where('status', 'Allocated')->count();
        $usedCount = Voucher::query()->where('status', 'Used')->count();
        $expiredCount = Voucher::query()->where('status', 'Expired')->count();
        $cancelledCount = Voucher::query()->where('status', 'Cancelled')->count();

        $vouchers = Voucher::with('vendor')
            ->latest()
            ->paginate(30);

        return view('dashboard', compact(
            'todayLeads',
            'counts',
            'vouchers',
            'locations',
            'totalStudents',
            'activeCourses',
            'pendingLeads',
            'scheduledExams',
            'recentEnrollments',
            'totalVoucherPurchase',
            'totalSellingAmount',
            'totalEarning', 'vouchers',
            'totalVouchers',
            'availableCount',
            'allocatedCount',
            'usedCount',
            'expiredCount', 'cancelledCount'
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

    public function reports()
    {
        $report = [
            'total_leads' => Lead::count(),
            'new_leads' => Lead::whereHas('latestFollowup', fn ($q) => $q->where('status', 'New'))->count(),
            'contacted_leads' => Lead::whereHas('latestFollowup', fn ($q) => $q->where('status', 'Contacted'))->count(),
            'interested_leads' => Lead::whereHas('latestFollowup', fn ($q) => $q->where('status', 'Interested'))->count(),
            'not_interested_leads' => Lead::whereHas('latestFollowup', fn ($q) => $q->where('status', 'Not Interested'))->count(),
            'converted_leads' => Lead::whereHas('latestFollowup', fn ($q) => $q->where('status', 'Converted'))->count(),
            'closed_leads' => Lead::whereHas('latestFollowup', fn ($q) => $q->where('status', 'Closed'))->count(),
            'total_candidates' => Candidate::count(),
            'total_vouchers' => Voucher::count(),
            'available_vouchers' => Voucher::where('status', 'Available')->count(),
            'used_vouchers' => Voucher::where('status', 'Used')->count(),
            'expired_vouchers' => Voucher::where('status', 'Expired')->count(),
        ];

        $executives = User::where('role_id', 4)
            ->orderBy('name')
            ->get()
            ->map(function ($executive) {
                return [
                    'id' => $executive->id,
                    'name' => $executive->name,
                    'total_leads' => Lead::where('assigned_to', $executive->id)->count(),
                    'converted' => Lead::where('assigned_to', $executive->id)
                        ->whereHas('latestFollowup', fn ($q) => $q->where('status', 'Converted'))
                        ->count(),
                    'candidates' => Candidate::where('executive_id', $executive->id)->count(),
                ];
            });

        $recentCandidates = Candidate::with(['course', 'center', 'executive'])
            ->latest()
            ->take(5)
            ->get();

        $monthlyReport = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $monthlyReport[] = [
                'month' => $date->format('M Y'),
                'leads' => Lead::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'candidates' => Candidate::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'converted' => Lead::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->whereHas('latestFollowup', fn ($q) => $q->where('status', 'Converted'))
                    ->count(),
            ];
        }

        return view('admin.reports.index', compact(
            'report',
            'executives',
            'recentCandidates',
            'monthlyReport'
        ));
    }

    public function checkUnique(Request $request)
    {
        // dd($request->all());
        $exists = DB::table($request->table)
            ->where($request->column, $request->value)
            ->when($request->id, function ($query) use ($request) {
                $query->where('id', '!=', $request->id);
            })
            ->exists();

        return response()->json([
            'exists' => $exists,
        ]);
    }
}
