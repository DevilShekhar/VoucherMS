<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use App\Models\Candidate;
use App\Models\Center;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = ExamSchedule::with([
            'candidate.course',
            'center',
            'createdBy'
        ]);

        // Center Executive
        if ($user->role_id == 5) {

            $centerId = Center::query()->where('center_exe_id', $user->id)->value('id');
            if ($centerId) {
                $query->where('center_id', $centerId);
            } else {
                $query->whereRaw('1 = 0');
            }
        }
        $examSchedules = $query->latest()->get();

        return view('admin.exam-schdule.index', compact('examSchedules'));
    }
    public function show(ExamSchedule $examSchedule)
    {
        // Center Executive can only view schedules of their own center
        if (Auth::user()->role_id == 5) {
            $center = Center::query()->where('center_exe_id', Auth::id())->first();
            if (!$center || $examSchedule->center_id != $center->id) {
                abort(403, 'Unauthorized access.');
            }
        }
        $examSchedule->load(['candidate.course','center','createdBy',]);
        return view('admin.exam-schdule.show', compact('examSchedule'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'center_id'    => 'required|exists:centers,id',
            'voucher_id'   => 'nullable|exists:vouchers,id',
            'exam_date'    => 'required|date',
            'exam_time'    => 'required',
        ]);

        // Prevent duplicate exam schedule
        $exists = ExamSchedule::query()->where('candidate_id', $request->candidate_id)->first();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Exam schedule already exists for this candidate.'
            ], 422);
        }

        DB::transaction(function () use ($request) {

            ExamSchedule::create([
                'candidate_id' => $request->candidate_id,
                'center_id'    => $request->center_id,
                'voucher_id'   => $request->voucher_id,
                'exam_date'    => $request->exam_date,
                'exam_time'    => $request->exam_time,
                'exam_status'  => 'Scheduled',
                'created_by'   => Auth::id(),
            ]);

            Candidate::query()->where('id', $request->candidate_id)
                ->update([
                    'status' => 'Exam Scheduled'
                ]);
        });

        return response()->json([
            'status' => true,
            'message' => 'Exam schedule created successfully.'
        ]);
    }
}
