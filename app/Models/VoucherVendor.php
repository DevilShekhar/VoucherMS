<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherVendor extends Model
{
    //
    protected $fillable = [
        'vendor_name',
        'contact_person',
        'phone',
        'email',
    ];
}
