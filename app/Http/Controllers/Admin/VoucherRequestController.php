<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (
            ! Auth::user()->hasRole('SuperAdmin') &&
            ! Auth::user()->hasRole('Admin')
        ) {
            abort(403);
        }

        $requests = VoucherRequest::with([
            'candidate',
            'center',
            'requestedBy',
        ])->latest()->paginate(15);

        return view('admin.voucher_requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'remarks' => 'nullable|string',
        ]);

        $candidate = Candidate::findOrFail($request->candidate_id);

        // Prevent duplicate pending request
        $exists = VoucherRequest::query()->where('candidate_id', $candidate->id)
            ->where('status', 'Pending')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Voucher request already sent.');
        }

        // Get first available voucher
        $voucher = Voucher::query()->where('status', 'Available')
            ->orderBy('id')
            ->first();

        if (! $voucher) {
            return back()->with('error', 'No voucher is currently available.');
        }

        // Generate Request Number
        $last = VoucherRequest::latest('id')->first();

        $next = $last
            ? str_pad($last->id + 1, 4, '0', STR_PAD_LEFT)
            : '0001';

        $requestNo = 'VR-'.now()->format('Ymd').'-'.$next;

        $admin = User::query()->where('role_id', 2)->first();
        $superAdmin = User::query()->where('role_id', 1)->first();

        // Create Voucher Request
        $voucherRequest = VoucherRequest::create([
            'request_no' => $requestNo,
            'candidate_id' => $candidate->id,
            'voucher_id' => $voucher->id, // Store Voucher ID
            'requested_by' => Auth::id(),
            'center_id' => $candidate->center_id,

            'admin_id' => $admin?->id,
            'superadmin_id' => $superAdmin?->id,

            'status' => 'Pending',
            'admin_approval' => 'Pending',
            'superadmin_approval' => 'Pending',

            'remarks' => $request->remarks,
            'requested_at' => now(),
        ]);

        // Reserve the voucher immediately
        $voucher->update([
            'status' => 'Allocated',
        ]);

        return back()->with('success', 'Voucher request sent successfully. Voucher has been reserved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VoucherRequest $voucherRequest)
    {
        $voucherRequest->load([
            'candidate.course',
            'candidate.center',
            'requestedBy',
            'voucher',
        ]);

        return view('admin.voucher_requests.show', compact('voucherRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approveByAdmin(Request $request, VoucherRequest $voucherRequest)
    {
        $request->validate([
            'action' => 'required|in:Approved,Rejected',
            'remarks' => 'nullable|string',
        ]);

        // Optional: Allow only Admin
        // if (! Auth::user()->hasRole('Admin')) {
        //     abort(403);
        // }

        $voucherRequest->admin_approval = $request->action;
        $voucherRequest->remarks = $request->remarks;

        if ($request->action == 'Rejected') {
            $voucherRequest->status = 'Rejected';
        }

        $voucherRequest->save();

        return redirect()
            ->route('voucher-requests.show', $voucherRequest)
            ->with('success', 'Admin decision saved successfully.');
    }

    public function approveBySuperAdmin(Request $request, VoucherRequest $voucherRequest)
    {
        $request->validate([
            'action' => 'required|in:Approved,Rejected',
            'remarks' => 'nullable|string',
        ]);

        // if (!Auth::user()->hasRole('SuperAdmin')) {
        //     abort(403);
        // }

        $voucherRequest->superadmin_approval = $request->action;
        $voucherRequest->remarks = $request->remarks;

        if ($request->action == 'Rejected') {

            $voucherRequest->status = 'Rejected';

        } elseif (
            $voucherRequest->admin_approval == 'Approved' &&
            $request->action == 'Approved'
        ) {

            $voucherRequest->status = 'Approved';
            $voucherRequest->approved_at = now();

        }

        $voucherRequest->save();

        return redirect()
            ->route('voucher-requests.show', $voucherRequest)
            ->with('success', 'Super Admin decision saved successfully.');
    }
}
