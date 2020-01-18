<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'students_courses');
    }

    public function studentsCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function address()
    {
        return $this->hasOne(StudentAddress::class, 'id');
    }
}
