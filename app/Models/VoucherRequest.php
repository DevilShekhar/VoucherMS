<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherRequest extends Model
{
    //
    protected $fillable = [

        'request_no',
        'candidate_id',
        'voucher_id',
        'certification_id',
        'requested_by',
        'center_id',
        'status',
        'admin_approval',
        'superadmin_approval',
        'remarks',
        'requested_at',
        'approved_at',
        'selling_price'

    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
