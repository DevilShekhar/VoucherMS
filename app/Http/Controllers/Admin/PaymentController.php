<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['candidate', 'createdBy'])
            ->latest()
            ->paginate(15);

        return view('admin.payment.index', compact('payments'));
    }

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

        if ($request->ajax()) {

            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully.',
            ]);
        }

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load([
            'candidate.course',
            'candidate.center',
            'transactions',
            'createdBy',
            'invoice',
        ]);

        // Complete payment history of this candidate
        $paymentHistory = Payment::with('transactions','invoice')
            ->where('candidate_id', $payment->candidate_id)
            ->latest()
            ->get();

        return view('admin.payment.show', compact(
            'payment',
            'paymentHistory'
        ));
    }
    public function generateInvoice(Payment $payment)
    {
        if ($payment->invoice) {
            return back()->with('error', 'Invoice already generated.');
        }

        $lastInvoice = Invoice::latest()->first();

        $next = $lastInvoice
            ? ((int) substr($lastInvoice->invoice_no, -4)) + 1
            : 1;

        $invoiceNo = 'INV-' . date('Ymd') . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);

        Invoice::create([
            'candidate_id' => $payment->candidate_id,
            'payment_id'   => $payment->id,
            'invoice_no'   => $invoiceNo,
            'invoice_date' => now()->toDateString(),
            'gst_type'     => 'CGST_SGST',
            'total_amount' => $payment->net_amount,
            'status'       => 'Generated',
            'created_by'   => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Download Receipt Button visible now.');
    }
    public function downloadInvoice(Invoice $invoice)
    {
        $invoice->load([
            'candidate.course',
            'candidate.center',
            'payment.transactions',
        ]);

        $pdf = Pdf::loadView(
            'admin.invoice.invoice',
            compact('invoice')
        );

        return $pdf->download($invoice->invoice_no.'.pdf');
    }
    public function sendInvoiceEmail(Payment $payment)
    {
        $payment->load([
            'candidate.course',
            'candidate.center',
            'transactions',
            'invoice.payment',
            'invoice.candidate.course',
            'invoice.candidate.center',
        ]);

        if (!$payment->invoice) {
            return back()->with('error', 'Invoice not found.');
        }

        if (empty($payment->candidate->email)) {
            return back()->with('error', 'Candidate email not found.');
        }

        $invoice = $payment->invoice;

        // Use the SAME blade as Download Invoice
        $pdf = Pdf::loadView(
            'admin.invoice.invoice',
            compact('invoice')
        );

        Mail::to($payment->candidate->email)
            ->send(new InvoiceMail(
                $payment,
                $pdf->output()
            ));

        return back()->with('success', 'Invoice emailed successfully.');
    }
}
