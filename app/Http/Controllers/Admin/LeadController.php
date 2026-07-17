<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Course;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leads = Lead::with([
            'assignedUser',
            'center',
            'course',
            'createdBy',
        ])
            ->latest()
            ->paginate(10);

        return view('admin.leads.index', compact('leads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::query()->where('role_id', 4)->get();
        $centers = Center::query()->where('status', 1)->get();
        $courses = Course::query()->where('status', 1)->get();

        return view('admin.leads.create', compact('users', 'centers', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
            'center_id' => 'required|exists:centers,id',
            'course_id' => 'required|exists:courses,id',
            'candidate_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        // Generate Lead Number
        $date = now()->format('Ymd');

        $lastLead = Lead::whereDate('created_at', today())
            ->latest('id')
            ->first();

        if ($lastLead) {
            $lastNumber = (int) substr($lastLead->lead_no, -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        $leadNo = 'L-'.$date.'-'.$nextNumber;

        Lead::create([
            'lead_no' => $leadNo,
            'assigned_to' => $request->assigned_to,
            'center_id' => $request->center_id,
            'course_id' => $request->course_id,
            'candidate_name' => $request->candidate_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'company' => $request->company,
            'city' => $request->city,
            'priority' => $request->priority,
            'status' => $request->status,
            'remarks' => $request->remarks,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('leads.index')
            ->with('success', 'Lead created successfully.');
    }

    public function edit(Lead $lead)
    {
        $users = User::query()->where('role_id', 4)->get();
        $centers = Center::query()->where('status', 1)->get();
        $courses = Course::query()->where('status', 1)->get();

        return view('admin.leads.edit', compact('lead', 'users', 'centers', 'courses'));
    }

    public function show(Lead $lead)
    {
        $lead->load(['assignedUser', 'center', 'course', 'createdBy']);

        return view('admin.leads.show', compact('lead'));
    }

    /**
     * Update Lead
     */
    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
            'center_id' => 'nullable|exists:centers,id',
            'course_id' => 'nullable|exists:courses,id',
            'candidate_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $lead->update([
            'assigned_to' => $request->assigned_to,
            'center_id' => $request->center_id,
            'course_id' => $request->course_id,
            'candidate_name' => $request->candidate_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'company' => $request->company,
            'city' => $request->city,
            'priority' => $request->priority,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('leads.index')
            ->with('success', 'Lead updated successfully.');
    }

    /**
     * Delete Lead
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')
            ->with('success', 'Lead deleted successfully.');
    }
}
