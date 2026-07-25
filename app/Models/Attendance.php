<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // This allows your form to save the status and dates to the database safely
    protected $fillable = [
        'student_id',
        'attendance_date',
        'status'
    ];

    // Links an attendance row back to its specific student profile record
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
