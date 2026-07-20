<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateDocument;
use App\Models\Center;
use App\Models\Course;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with(['lead', 'center', 'executive', 'course', 'documents'])
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
        // dd($request->all());

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

    public function edit(Candidate $candidate)
    {
        $leads = Lead::whereHas('followups', function ($q) {
            $q->where('status', 'Converted');
        })->get();

        $centers = Center::query()->where('status', 1)->get();
        $courses = Course::query()->where('status', 1)->get();

        return view('admin.candidates.edit', compact('candidate', 'leads', 'centers', 'courses'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'lead_id' => 'nullable|exists:leads,id',
            'center_id' => 'required|exists:centers,id',
            'course_id' => 'required|exists:courses,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'email' => 'nullable|email|unique:candidates,email,'.$candidate->id,
            'mobile' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive,Completed,Cancelled',
        ]);

        $candidate->update([
            'lead_id' => $request->lead_id,
            'center_id' => $request->center_id,
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
            'status' => $request->status,
        ]);

        return redirect()->route('candidates.index', $candidate)
            ->with('success', 'Candidate updated successfully.');
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

    public function storeDocument(Request $request)
    {
        // dd('submited');
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'document_type' => 'required|string|max:100',
            'document' => 'required|file|max:10240',
        ]);

        $candidate = Candidate::findOrFail($request->candidate_id);

        $file = $request->file('document');

        $fileName = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            .'.'.$file->getClientOriginalExtension();

        $path = $file->storeAs(
            'candidate_documents/'.$candidate->id,
            $fileName,
            'public'
        );

        CandidateDocument::create([
            'candidate_id' => $candidate->id,
            'document_type' => $request->document_type,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'uploaded_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document uploaded successfully.',
        ]);
    }

    public function show(Candidate $candidate)
    {
        $candidate->load(['lead', 'center', 'executive', 'course', 'certification', 'documents.uploadedBy']);

        return view('admin.candidates.show', compact('candidate'));
    }

    public function getDetails(Candidate $candidate)
{
    return response()->json([
        'first_name' => $candidate->first_name,
        'last_name' => $candidate->last_name,
        'candidate_code' => $candidate->candidate_code,
        'mobile' => $candidate->mobile,
        'email' => $candidate->email,
        'course_name' => $candidate->course->course_name ?? '-',
        'center_name' => $candidate->center->center_name ?? '-',
    ]);
}
}
