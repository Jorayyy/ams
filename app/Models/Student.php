<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_number', // This is their LRN
        'first_name',
        'last_name',
        'grade_level',
        'section',
        'gender'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
