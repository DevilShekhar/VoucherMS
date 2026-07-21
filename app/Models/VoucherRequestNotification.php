<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherRequestNotification extends Model
{
    protected $fillable = [
        'voucher_request_id',
        'user_id',
        'title',
        'message',
        'is_read',
    ];

    public function voucherRequest()
    {
        return $this->belongsTo(VoucherRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
