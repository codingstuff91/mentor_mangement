<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCoursesHours = Cours::where('cours.pack_heures', false)
                            ->select(DB::raw("SUM(nombre_heures) as total"))
                            ->get();

        $totalRevenues = Cours::select(DB::raw('SUM(nombre_heures * taux_horaire) as total'))->get();

        $classHoursPerSubject = DB::table('students')
                                    ->join('cours', 'cours.student_id', '=', 'students.id')
                                    ->join('matieres', 'matieres.id', '=', 'students.matiere_id')
                                    ->where('cours.pack_heures', false)
                                    ->select(DB::raw('matieres.nom, SUM(nombre_heures) as total'))
                                    ->groupBy('matieres.nom')
                                    ->orderBy('total', 'desc')
                                    ->get();

        return view('dashboard')->with([
            'totalCoursesHours'    => $totalCoursesHours,
            'totalRevenues'        => $totalRevenues,
            'totalStudents'        => Student::count(),
            'totalCourses'         => Cours::count(),
            'totalHoursPerSubject' => $classHoursPerSubject,
        ]);
    }
}
