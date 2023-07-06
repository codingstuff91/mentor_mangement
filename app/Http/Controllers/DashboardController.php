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
        $totalCoursesHours = Course::where('courses.pack_heures', false)
                            ->select(DB::raw("SUM(nombre_heures) as total"))
                            ->get();

        $totalRevenues = Course::select(DB::raw('SUM(nombre_heures * taux_horaire) as total'))->get();

        $classHoursPerSubject = DB::table('students')
                                    ->join('courses', 'courses.student_id', '=', 'students.id')
                                    ->join('subjects', 'subjects.id', '=', 'students.subject_id')
                                    ->where('courses.pack_heures', false)
                                    ->select(DB::raw('subjects.nom, SUM(nombre_heures) as total'))
                                    ->groupBy('subjects.nom')
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
