<?php

namespace App\Services;

use App\Models\Student;
use Carbon\Carbon;

class StudentService
{
    public static function count_total_hours(Student $student): string
    {
        $courses = $student->courses;

        $total = Carbon::parse('00:00');

        foreach ($courses as $course) {
            $total->addHours(Carbon::parse($course->hours_count)->hour);
            $total->addMinutes(Carbon::parse($course->hours_count)->minute);
        }

        return $total->format('H:i');
    }
}
