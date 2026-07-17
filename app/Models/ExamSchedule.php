<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    //
    protected $fillable = [
        'candidate_id',
        'center_id',
        'certification_id',
        'voucher_id',
        'exam_date',
        'exam_time',
        'exam_status',
        'created_by',
    ];
}
