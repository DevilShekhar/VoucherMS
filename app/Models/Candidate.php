<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    //
    protected $fillable = [
        'candidate_code',
        'lead_id',
        'center_id',
        'executive_id',
        'course_id',
        'certification_id',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'email',
        'mobile',
        'company', 'gst_number',
        'address',
        'city',
        'state',
        'country',
        'status',
    ];
}
