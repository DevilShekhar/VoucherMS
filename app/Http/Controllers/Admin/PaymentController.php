<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['candidate', 'createdBy'])
            ->latest()
            ->paginate(15);

        return view('admin.payment.index', compact('payments'));
    }

    //     public function create()
    // {

    //     $candidates = Candidate::with(['lead', 'course', 'center', 'executive'])
    //     ->orderBy('first_name')
    //     ->get();
    //         // dd($candidates->count(), $candidates->pluck('first_name'));

    //     return view('admin.payment.create', compact('candidates'));
    // }

    public function create()
    {
        $candidates = Candidate::with(['lead', 'course', 'center', 'executive'])
            ->whereHas('lead', function ($q) {
                $q->where('status', 'Converted');
            })
            ->orWhereHas('lead.followups', function ($q) {
                $q->where('status', 'Converted');
            })
            ->orderBy('first_name')
            ->get();

        return view('admin.payment.create', compact('candidates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'total_amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'payment_mode' => 'required|in:Cash,UPI,Card,Bank Transfer,Cheque',
            'amount' => 'required|numeric|min:0',
            'transaction_no' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $candidate = Candidate::findOrFail($request->candidate_id);

        $total = $request->total_amount;
        $discount = $request->discount_amount ?? 0;
        $tax = $request->tax_amount ?? 0;
        $netAmount = $total - $discount + $tax;
        $paidAmount = $request->amount;
        $pendingAmount = max(0, $netAmount - $paidAmount);

        $paymentStatus = $pendingAmount <= 0 ? 'Paid' : ($paidAmount > 0 ? 'Partial' : 'Pending');

        $date = now()->format('Ymd');
        $last = Payment::latest('id')->first();
        $next = $last ? str_pad(((int) substr($last->payment_no ?? '', -4)) + 1, 4, '0', STR_PAD_LEFT) : '0001';
        $paymentNo = "PAY-{$date}-{$next}";

        $payment = Payment::create([
            'candidate_id' => $candidate->id,
            'payment_no' => $paymentNo,
            'total_amount' => $total,
            'discount_amount' => $discount,
            'tax_amount' => $tax,
            'net_amount' => $netAmount,
            'paid_amount' => $paidAmount,
            'pending_amount' => $pendingAmount,
            'payment_status' => $paymentStatus,
            'payment_date' => $request->payment_date ?? now()->format('Y-m-d'),
            'remarks' => $request->remarks,
            'created_by' => Auth::id(),
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('payment_receipts/'.$payment->id, 'public');
        }

        PaymentTransaction::create([
            'payment_id' => $payment->id,
            'amount' => $paidAmount,
            'payment_mode' => $request->payment_mode,
            'transaction_no' => $request->transaction_no,
            'bank_name' => $request->bank_name,
            'transaction_date' => now(),
            'receipt' => $receiptPath,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load([
            'candidate.course',
            'candidate.center',
            'transactions',
            'createdBy',
        ]);

        return view('admin.payment.show', compact('payment'));
    }
}
