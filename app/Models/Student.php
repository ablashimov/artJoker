<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function address()
    {
        return $this->hasOne(StudentAddress::class, 'id');
    }
}
