<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $fillable = [
        'course_code',
        'course_name',
        'description',
        'status',
        'course_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
