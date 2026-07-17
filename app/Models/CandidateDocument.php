<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateDocument extends Model
{
    //
    protected $fillable = [
        'candidate_id',
        'document_type',
        'file_name',
        'file_path',
        'uploaded_by',
    ];
}
