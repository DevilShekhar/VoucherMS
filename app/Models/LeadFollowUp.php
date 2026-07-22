<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadFollowUp extends Model
{
    protected $table = 'lead_followups';
    protected $fillable = [
        'lead_id',
        'followup_date',
        'discussion',
        'next_followup',
        'status',
        'created_by',
        'reminder_sent'
    ];
    protected $casts = [
    'followup_date' => 'datetime',
    'next_followup' => 'datetime',
];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
