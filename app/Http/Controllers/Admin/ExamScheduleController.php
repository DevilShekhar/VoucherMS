<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Center;
use App\Models\ExamSchedule;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = ExamSchedule::with([
            'candidate.course',
            'center',
            'createdBy',
        ]);
        if (in_array($user->role_id, [1, 2])) {

        }
        elseif ($user->role_id == 5) {
            $query->where('center_admin_id', $user->id);
        }
        else {
            $query->where('created_by', $user->id);
        }
        $examSchedules = $query->latest()->get();
        return view('admin.exam-schdule.index', compact('examSchedules'));
    }
    public function center()
    {
        $user = Auth::user();
        $query = ExamSchedule::with([
            'candidate.course',
            'center',
            'createdBy',
        ])->where('exam_mode', 'center');
        // Super Admin & Admin
        if (in_array($user->role_id, [1, 2])) {
            // Show all records
        }
        // Center Admin
        elseif ($user->role_id == 5) {
            $query->where('center_admin_id', $user->id);
        }
        // Manager, Sales Executive, Accounts
        else {
            $query->where('created_by', $user->id);
        }
        $examSchedules = $query->latest()->get();
        return view('admin.exam-schdule.center', compact('examSchedules'));
    }

    public function online()
    {
        $user = Auth::user();
        $query = ExamSchedule::with([
            'candidate.course',
            'createdBy',
        ])->where('exam_mode', 'online');
        // Super Admin & Admin
        if (in_array($user->role_id, [1, 2])) {
            // Show all records
        }
        // Center Admin
        elseif ($user->role_id == 5) {
            // If online exams are assigned to a center admin
            $query->where('center_admin_id', $user->id);
        }
        // Manager, Sales Executive, Accounts
        else {
            $query->where('created_by', $user->id);
        }
        $examSchedules = $query->latest()->get();
        return view('admin.exam-schdule.online', compact('examSchedules'));
    }

    public function show(ExamSchedule $examSchedule)
    {
        // Center Executive can only view schedules of their own center
        if (Auth::user()->role_id == 5) {
            $center = Center::query()->where('center_exe_id', Auth::id())->first();
            if (! $center || $examSchedule->center_id != $center->id) {
                abort(403, 'Unauthorized access.');
            }
        }
        $query = ExamSchedule::with([
            'candidate.course',
            'center',
            'createdBy',
            'voucher',
        ]);
        $examSchedule->load(['candidate.course', 'center', 'createdBy']);
        return view('admin.exam-schdule.show', compact('examSchedule', 'query'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'voucher_id'   => 'nullable|exists:vouchers,id',
            'exam_mode'    => 'required|in:center,online',
            'center_id'    => 'required_if:exam_mode,center|nullable|exists:centers,id',
            'exam_date'    => 'required|date',
            'exam_time'    => 'required',
        ]);
        $exists = ExamSchedule::where('candidate_id', $request->candidate_id)->exists();
        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Exam schedule already exists for this candidate.',
            ], 422);
        }
        DB::transaction(function () use ($request) {
            $centerAdminId = null;
            if ($request->exam_mode == 'center') {
                $center = Center::findOrFail($request->center_id);
                $centerAdminId = $center->center_exe_id;
            }
            ExamSchedule::create([
                'candidate_id'    => $request->candidate_id,
                'voucher_id'      => $request->voucher_id,
                'exam_mode'       => $request->exam_mode,
                'center_id'       => $request->exam_mode == 'center' ? $request->center_id : null,
                'exam_date'       => $request->exam_date,
                'exam_time'       => $request->exam_time,
                'exam_status'     => 'Scheduled',
                'created_by'      => Auth::id(),
                'center_admin_id' => $centerAdminId,
            ]);
            Candidate::where('id', $request->candidate_id)->update([
                'status' => 'Exam Scheduled',
            ]);
        });
        return response()->json([
            'status' => true,
            'message' => 'Exam schedule created successfully.',
        ]);
    }

    public function markUsed(Request $request, Voucher $voucher)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);
        $voucher->update([
            'status' => 'Used',
            'remarks' => $request->remarks,
        ]);
        return back()->with('success', 'Voucher marked as Used successfully.');
    }
}
