<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    //
    protected $fillable = [
    'lead_no',
    'lead_source_id',
    'assigned_to',
    'center_id',
    'course_id',
    'candidate_name',
    'email',
    'mobile',
    'company',
    'city',
    'priority',
    'status',
    'remarks',
    'created_by',
];
}
