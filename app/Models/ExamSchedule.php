<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    protected $fillable = [
        'candidate_id',
        'voucher_id',
        'exam_mode',
        'center_id',
        'exam_date',
        'exam_time',
        'exam_status',
        'created_by',
        'center_admin_id',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    // public function center()
    // {
    //     return $this->belongsTo(Center::class, 'center_id');
    // }
    public function center()
{
    return $this->belongsTo(Center::class);
}

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
