<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    //
    protected $fillable = [
        'user_id',
        'login_time',
        'logout_time',
        'ip_address',
        'browser',
        'device',
    ];
}
