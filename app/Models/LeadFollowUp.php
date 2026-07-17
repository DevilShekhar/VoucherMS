<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadFollowUp extends Model
{
    //
    protected $fillable = [
        'lead_id',
        'followup_date',
        'discussion',
        'next_followup',
        'status',
        'created_by',
    ];
}
