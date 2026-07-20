<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $casts = [
        'dob' => 'date',
    ];

    // Relationships
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function executive(): BelongsTo
    {
        return $this->belongsTo(User::class, 'executive_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }

    public function documents()
    {
        return $this->hasMany(CandidateDocument::class);
    }
}
