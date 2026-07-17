<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = [
        'candidate_id',
        'invoice_no',
        'invoice_date',
        'gst_type',
        'total_amount',
        'status',
    ];
}
