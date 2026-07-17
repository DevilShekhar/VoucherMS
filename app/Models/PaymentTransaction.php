<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    //
    protected $fillable = [
        'payment_id',
        'amount',
        'payment_mode',
        'transaction_no',
        'bank_name',
        'transaction_date',
        'receipt',
    ];
}
