<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Center;
use App\Models\Course;
use App\Models\Lead;
use App\Models\LeadFollowUp;
use App\Models\LeadNotification;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Lead::with([
            'assignedUser',
            'center',
            'course',
            'createdBy',
            'latestFollowup',
        ]);

        if (Auth::user()->role_id == 4) {
            $query->where('assigned_to', Auth::id());
        }

        if ($status = request('status')) {
            $query->whereHas('latestFollowup', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $leads = $query->latest()->paginate(10);

        // Base query for counts
        $countQuery = Lead::query();

        if (Auth::user()->role_id == 4) {
            $countQuery->where('assigned_to', Auth::id());
        }

        $counts = [
            'all' => (clone $countQuery)->count(),
            'New' => (clone $countQuery)->whereHas('followups', fn ($q) => $q->where('status', 'New'))->count(),
            'Contacted' => (clone $countQuery)->whereHas('followups', fn ($q) => $q->where('status', 'Contacted'))->count(),
            'Interested' => (clone $countQuery)->whereHas('followups', fn ($q) => $q->where('status', 'Interested'))->count(),
            'Not Interested' => (clone $countQuery)->whereHas('followups', fn ($q) => $q->where('status', 'Not Interested'))->count(),
            'Converted' => (clone $countQuery)->whereHas('followups', fn ($q) => $q->where('status', 'Converted'))->count(),
            // 'Closed' => (clone $countQuery)->whereHas('followups', fn ($q) => $q->where('status', 'Closed'))->count(),
        ];

        return view('admin.leads.index', compact('leads', 'counts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::query()->get();
        $users = User::query()->where('role_id', 4)->get();
        $centers = Center::query()->where('status', 1)->get();
        $courses = Course::query()->where('status', 1)->get();

        return view(
            'admin.leads.create',
            compact('users', 'centers', 'courses', 'locations')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'center_id' => 'nullable|exists:centers,id',
            'course_id' => 'nullable',
            'candidate_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'priority' => 'nullable|in:Low,Medium,High',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'other_course_name' => 'nullable|string|max:255|required_if:course_id,other',
        ]);

        $currentUser = Auth::user();

        // === Handle "Other" Course ===
        $courseId = $request->course_id;

        if ($request->course_id === 'other' && $request->other_course_name) {

            $courseName = trim($request->other_course_name);

            // Generate Course Code (e.g., CRS-20260720-001)
            $date = now()->format('Ymd');
            $lastCourse = Course::latest('id')->first();
            $next = $lastCourse
                ? str_pad(((int) substr($lastCourse->course_code ?? '', -4)) + 1, 4, '0', STR_PAD_LEFT)
                : '0001';

            $courseCode = "CRS-{$date}-{$next}";

            $newCourse = Course::create([
                'course_code' => $courseCode,
                'course_name' => $courseName,
                'status' => 1,
            ]);

            $courseId = $newCourse->id;
        }

        // === ASSIGNMENT LOGIC ===
        $assignedTo = $request->assigned_to;
        if ($currentUser->role_id === 4) {
            $assignedTo = $currentUser->id;
        } elseif (empty($assignedTo)) {
            $assignedTo = $this->getNextSalesExecutive($request->location_id);
        }

        // Generate Lead Number
        $date = now()->format('Ymd');
        $lastLead = Lead::whereDate('created_at', today())->latest('id')->first();
        $nextNumber = $lastLead
            ? str_pad((int) substr($lastLead->lead_no, -3) + 1, 3, '0', STR_PAD_LEFT)
            : '001';
        $leadNo = "L-{$date}-{$nextNumber}";

        $lead = Lead::create([
            'lead_no' => $leadNo,
            'assigned_to' => $assignedTo,
            'center_id' => $request->center_id,
            'course_id' => $courseId,
            'candidate_name' => $request->candidate_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'company' => $request->company,
            'city' => $request->city,
            'priority' => $request->priority,
            'status' => $request->status,
            'remarks' => $request->remarks,
            'location_id' => $request->location_id,
            'created_by' => Auth::id(),
        ]);

        if ($lead->assigned_to) {

            LeadNotification::create([
                'lead_id' => $lead->id,
                'user_id' => $lead->assigned_to,
                'title' => 'New Lead Assigned',
                'message' => 'Lead No. '.$lead->lead_no.' has been assigned to you.',
                'is_read' => 0,
            ]);

        }

        return redirect()->route('leads.index')
            ->with('success', 'Lead created successfully.');
    }

    private function getNextSalesExecutive($locationId = null)
    {
        $query = User::query()->where('role_id', 4);

        // Filter by selected location
        if ($locationId) {
            $query->where('location_id', $locationId);
        }

        $salesExecutives = $query
            ->orderBy('id')
            ->pluck('id');

        if ($salesExecutives->isEmpty()) {
            return null;
        }

        // Last assigned lead among executives of THIS location only
        $lastAssignedLead = Lead::whereNotNull('assigned_to')
            ->whereIn('assigned_to', $salesExecutives)
            ->latest('id')
            ->first();

        if (! $lastAssignedLead) {
            return $salesExecutives->first();
        }

        $currentIndex = $salesExecutives->search($lastAssignedLead->assigned_to);

        $nextIndex = ($currentIndex + 1) % $salesExecutives->count();

        return $salesExecutives[$nextIndex];
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
        // Authorization
        if (Auth::user()->role_id == 4 && $lead->assigned_to !== Auth::id()) {
            abort(403);
        }

        // Load lead relationships
        $lead->load([
            'assignedUser',
            'center',
            'course',
            'createdBy',
        ]);

        // Paginate followups separately
        $followups = $lead->followups()
            ->with('createdBy')
            ->latest()
            ->paginate(5);

        return view('admin.leads.show', compact('lead', 'followups'));
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
            'candidate_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $data = [
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
        ];

        // Only Super Admin, Admin & Manager can change assignment
        if (Auth::user()->role_id != 4) {
            $data['assigned_to'] = $request->assigned_to;
        }

        $lead->update($data);

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
    // Inside LeadController class

    public function addFollowup(Request $request, Lead $lead)
    {
        if (Auth::user()->role_id == 4 && $lead->assigned_to != Auth::id()) {
            abort(403, 'You can only add followups to your assigned leads.');
        }

        $request->validate([
            'followup_date' => 'required|date',
            'discussion' => 'required|string',
            'next_followup' => 'nullable|date',
            'status' => 'required|in:Pending,Contacted,Interested,Not Interested,Converted,Closed',
        ]);

        $followup = LeadFollowUp::create([
            'lead_id' => $lead->id,
            'followup_date' => $request->followup_date,        // ← Fixed
            'discussion' => $request->discussion,
            'next_followup' => $request->next_followup,        // ← Must save time
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        // Update Lead Status
        $lead->update([
            'status' => $request->status,
        ]);

        // Create Candidate when Converted
        if ($request->status == 'Converted') {

            // Prevent duplicate candidate
            $candidate = Candidate::query()->where('lead_id', $lead->id)->first();

            if (! $candidate) {

                // Generate Candidate Code
                $date = now()->format('Ymd');

                $last = Candidate::latest('id')->first();

                if ($last && $last->candidate_code) {
                    $next = str_pad(
                        ((int) substr($last->candidate_code, -4)) + 1,
                        4,
                        '0',
                        STR_PAD_LEFT
                    );
                } else {
                    $next = '0001';
                }

                $candidateCode = "C-{$date}-{$next}";

                $name = explode(' ', trim($lead->candidate_name), 2);

                Candidate::create([
                    'candidate_code' => $candidateCode,
                    'lead_id' => $lead->id,
                    'center_id' => null,
                    'executive_id' => $lead->assigned_to,
                    'course_id' => $lead->course_id,
                    'certification_id' => null,

                    'first_name' => $name[0] ?? '',
                    'last_name' => $name[1] ?? '',

                    'gender' => null,
                    'dob' => null,

                    'email' => $lead->email,
                    'mobile' => $lead->mobile,

                    'company' => $lead->company,
                    'gst_number' => null,

                    'address' => null,
                    'city' => $lead->city,
                    'state' => null,
                    'country' => null,

                    'status' => 'Active',
                ]);
            }

            // Redirect to Candidate List
            return redirect()
                ->route('candidates.index')
                ->with('success', 'Lead converted to Candidate successfully.');
        }

        // Default redirect for other statuses
        return redirect()
            ->route('leads.show', $lead->id)
            ->with('success', 'Follow-up added successfully.');
    }

    public function reminders()
    {
        $now = Carbon::now();
        $fiveMinutesLater = $now->copy()->addMinutes(5);

        $reminders = LeadFollowUp::with('lead')
            ->whereBetween('next_followup', [$now, $fiveMinutesLater])
            ->where('reminder_sent', 0)
            ->whereHas('lead', function ($q) {
                $q->where('assigned_to', Auth::id()); // Only assigned user's reminders
            })
            ->get();

        foreach ($reminders as $followup) {
            $followup->update([
                'reminder_sent' => 1,
            ]);
        }

        return response()->json([
            'reminders' => $reminders,
        ]);
    }

    public function markDone($id)
    {
        $followup = LeadFollowUp::findOrFail($id);

        $updated = $followup->update([
            'reminder_sent' => 1,
        ]);

        return response()->json([
            'success' => $updated,
            'before' => $followup->getOriginal('reminder_sent'),
            'after' => $followup->fresh()->reminder_sent,
        ]);
    }

    public function getSalesExecutives(Request $request)
    {
        $query = User::query()->where('role_id', 4);

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        return response()->json(
            $query->orderBy('name')
                ->select('id', 'name')
                ->get()
        );
    }
}
