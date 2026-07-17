<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    //
    protected $fillable = [
        'candidate_id',
        'certification_id',
        'expiry_date',
        'reminder_30_sent',
        'reminder_15_sent',
        'reminder_7_sent',
        'renewal_status',
        'next_followup',
        'remarks',
    ];
}
