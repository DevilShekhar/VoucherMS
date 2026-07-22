<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $fillable = [
        'center_code',
        'center_name',
        'center_exe_id',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'phone',
        'email',
        'status',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'center_exe_id');
    }
}
