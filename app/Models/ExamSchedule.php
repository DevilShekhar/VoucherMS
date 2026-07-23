<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    protected $fillable = [
        'candidate_id',
        'center_id',
        'voucher_id',
        'exam_date',
        'exam_time',
        'exam_status',
        'created_by',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
