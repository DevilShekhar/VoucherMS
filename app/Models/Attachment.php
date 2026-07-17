<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //
    protected $fillable = [
        'module',
        'reference_id',
        'file_name',
        'file_path',
        'uploaded_by',
    ];
}
