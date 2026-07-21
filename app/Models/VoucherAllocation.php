<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherAllocation extends Model
{
    protected $fillable = [
        'voucher_id',
        'request_id',
        'candidate_id',
        'allocated_to',
        'allocated_date',
        'used_date',
        'status',
    ];
}
