<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    //
    protected $fillable = [
        'lead_no',
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

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function followups()
    {
        return $this->hasMany(LeadFollowUp::class)->latest();
    }

    public function latestFollowup()
    {
        return $this->hasOne(LeadFollowUp::class)->latestOfMany();
    }

    public function candidate()
    {
        return $this->hasOne(Candidate::class);
    }
}
