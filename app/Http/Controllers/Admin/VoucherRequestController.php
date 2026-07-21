<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherAllocation;
use App\Models\VoucherRequest;
use App\Models\VoucherRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoucherRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (
        //     ! Auth::user()->hasRole('SuperAdmin') &&
        //     ! Auth::user()->hasRole('Admin')
        // ) {
        //     abort(403);
        // }

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

        if ($admin) {
            VoucherRequestNotification::create([
                'voucher_request_id' => $voucherRequest->id,
                'user_id' => $admin->id,
                'title' => 'New Voucher Request',
                'message' => 'Voucher request '.$voucherRequest->request_no.' requires your approval.',
            ]);
        }

        if ($superAdmin) {
            VoucherRequestNotification::create([
                'voucher_request_id' => $voucherRequest->id,
                'user_id' => $superAdmin->id,
                'title' => 'New Voucher Request',
                'message' => 'Voucher request '.$voucherRequest->request_no.' requires your approval.',
            ]);
        }

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

    public function approve(Request $request, VoucherRequest $voucherRequest)
    {
        $request->validate([
            'action' => 'required|in:Approved,Rejected',
            'remarks' => 'nullable|string',
        ]);

        $data = [
            'status' => $request->action,
            'remarks' => $request->remarks,
        ];

        if (Auth::user()->role_id == 1) {
            // Super Admin
            $data['superadmin_approval'] = $request->action;
        } elseif (Auth::user()->role_id == 2) {
            // Admin
            $data['admin_approval'] = $request->action;
        } else {
            abort(403, 'Unauthorized');
        }

        $voucherRequest->update($data);

        return redirect()
            ->route('voucher-requests.show', $voucherRequest)
            ->with('success', 'Voucher request Approve By You successfully.');
    }

    public function allocateVoucher(VoucherRequest $voucherRequest)
    {
        if ($voucherRequest->status !== 'Approved') {
            return back()->with('error', 'Only approved requests can be allocated.');
        }

        if ($voucherRequest->voucher_id == null) {
            return back()->with('error', 'No voucher is assigned to this request.');
        }

        if (VoucherAllocation::query()->where('request_id', $voucherRequest->id)->exists()) {
            return back()->with('error', 'Voucher has already been allocated.');
        }

        DB::transaction(function () use ($voucherRequest) {

            VoucherAllocation::create([
                'voucher_id' => $voucherRequest->voucher_id,
                'request_id' => $voucherRequest->id,
                'candidate_id' => $voucherRequest->candidate_id,
                'allocated_to' => Auth::id(),
                'allocated_date' => now()->toDateString(),
                'status' => 'Allocated',
            ]);

            $voucherRequest->update([
                'status' => 'Allocated',
                'approved_at' => now(),
            ]);

            $voucherRequest->voucher->update([
                'status' => 'Allocated',
            ]);
        });

        return back()->with('success', 'Voucher allocated successfully.Now Candidate Can use this code to get Discount');
    }
}
