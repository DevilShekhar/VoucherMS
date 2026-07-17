<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherRequest extends Model
{
    //
    protected $fillable = [
        'request_no',
        'candidate_id',
        'certification_id',
        'requested_by',
        'center_id',
        'status',
        'admin_approval',
        'superadmin_approval',
        'remarks',
        'requested_at',
        'approved_at',
    ];
}
