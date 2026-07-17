<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    //
    protected $fillable = [
    'center_code',
    'center_name',
    'manager_id',
    'address',
    'city',
    'state',
    'country',
    'pincode',
    'phone',
    'email',
    'status',
];
}
