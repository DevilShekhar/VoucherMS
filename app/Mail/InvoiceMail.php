<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Payment $payment;

    protected $pdf;

    public function __construct(Payment $payment, $pdf)
    {
        $this->payment = $payment;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this
            ->subject('Invoice - '.$this->payment->invoice->invoice_no)
            ->view('emails.invoice')
            ->attachData(
                $this->pdf,
                $this->payment->invoice->invoice_no.'.pdf',
                [
                    'mime' => 'application/pdf',
                ]
            );
    }
}