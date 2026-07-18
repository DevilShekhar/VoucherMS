<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Center;
use App\Models\Course;
use App\Models\Lead;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with(['lead', 'center', 'executive', 'course'])
            ->whereHas('lead.followups', function ($query) {
                $query->where('status', 'Converted');
            })
            ->latest()
            ->paginate(15);

        return view('admin.candidates.index', compact('candidates'));
    }

    public function create()
    {
        $leads = Lead::whereHas('followups', function ($q) {
            $q->where('status', 'Converted');
        })
            ->whereDoesntHave('candidate')
            ->get();

        $centers = Center::query()->where('status', 1)->get();
        $courses = Course::query()->where('status', 1)->get();

        return view('admin.candidates.create', compact('leads', 'centers', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'center_id' => 'required|exists:centers,id',
            'course_id' => 'required|exists:courses,id',
            'first_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|unique:candidates,email',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female,Other',
            'dob' => 'nullable|date',
        ]);

        $lead = Lead::findOrFail($request->lead_id);

        // Generate Candidate Code
        $date = now()->format('Ymd');
        $last = Candidate::latest('id')->first();
        $next = $last ? str_pad(((int) substr($last->candidate_code ?? '', -4)) + 1, 4, '0', STR_PAD_LEFT) : '0001';
        $candidateCode = "C-{$date}-{$next}";

        Candidate::create([
            'candidate_code' => $candidateCode,
            'lead_id' => $request->lead_id,
            'center_id' => $request->center_id,
            'executive_id' => $lead->assigned_to,
            'course_id' => $request->course_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'company' => $request->company,
            'gst_number' => $request->gst_number,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'status' => 'Active',
        ]);

        return redirect()->route('candidates.index')
            ->with('success', 'Candidate created successfully from lead.');
    }

    public function getLeadDetails(Lead $lead)
    {
        return response()->json([
            'candidate_name' => $lead->candidate_name,
            'center_id' => $lead->center_id,
            'course_id' => $lead->course_id,
            'email' => $lead->email,
            'mobile' => $lead->mobile,
            'company' => $lead->company,
            'city' => $lead->city,
        ]);
    }
}
