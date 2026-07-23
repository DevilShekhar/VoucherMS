<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Voucher extends Model
{
    protected $fillable = [
        'voucher_code',
        'vendor_id',
        'certification_id',
        'purchase_date',
        'expiry_date',
        'purchase_price',
        'cost',
        'status',
        'remarks','voucher_code_hash'
    ];

    /**
     * Encrypt before saving.
     */
    // public function setVoucherCodeAttribute($value)
    // {
    //     $this->attributes['voucher_code'] = Crypt::encryptString($value);
    // }

    public function setVoucherCodeAttribute($value)
    {
        $value = strtoupper(trim($value));

        $this->attributes['voucher_code'] = Crypt::encryptString($value);

        // Used only for duplicate checking
        $this->attributes['voucher_code_hash'] = hash('sha256', $value);
    }

    /**
     * Decrypt when retrieving.
     */
    public function getVoucherCodeAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function vendor()
    {
        return $this->belongsTo(VoucherVendor::class);
    }

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    public function voucherRequests()
    {
        return $this->hasMany(VoucherRequest::class);
    }
}
