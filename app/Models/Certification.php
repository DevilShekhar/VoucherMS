<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    //
    protected $fillable = [
    'course_id',
    'certification_code',
    'certification_name',
    'vendor',
    'validity_months',
    'exam_duration',
    'passing_marks',
    'status',
];
}
