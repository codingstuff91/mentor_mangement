<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCoursesHours = Course::where('courses.hours_pack', false)
                            ->select(DB::raw("SUM(hours_count) as total"))
                            ->get();

        $totalRevenues = Course::select(DB::raw('SUM(hours_count * hourly_rate) as total'))->get();

        $classHoursPerSubject = DB::table('students')
                                    ->join('courses', 'courses.student_id', '=', 'students.id')
                                    ->join('subjects', 'subjects.id', '=', 'students.subject_id')
                                    ->where('courses.hours_pack', false)
                                    ->select(DB::raw('subjects.name, SUM(hours_count) as total'))
                                    ->groupBy('subjects.name')
                                    ->orderBy('total', 'desc')
                                    ->get();

        return view('dashboard')->with([
            'totalCoursesHours'    => $totalCoursesHours,
            'totalRevenues'        => $totalRevenues,
            'totalStudents'        => Student::count(),
            'totalCourses'         => Course::count(),
            'totalHoursPerSubject' => $classHoursPerSubject,
        ]);
    }
}
