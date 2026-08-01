<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'candidate_id',
        'payment_id',
        'invoice_no',
        'invoice_date',
        'gst_type',
        'total_amount',
        'status',
        'created_by',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}