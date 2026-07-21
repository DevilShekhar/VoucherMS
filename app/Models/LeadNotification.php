<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadNotification extends Model
{
    protected $fillable = [
        'lead_id',
        'user_id',
        'title',
        'message',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}