<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'candidate_id',
        'invoice_id',
        'payment_no',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'net_amount',
        'paid_amount',
        'pending_amount',
        'payment_status',
        'payment_date',
        'remarks',
        'created_by',
    ];
}
