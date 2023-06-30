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
        // Total d'heures de cours
        $nb_heures_cours = Cours::where('cours.pack_heures', false)
                            ->select(DB::raw("SUM(nombre_heures) as total"))
                            ->get();

        // Total argent gagné
        $total_gains = Cours::select(DB::raw('SUM(nombre_heures * taux_horaire) as total'))->get();

        // Total d'élèves
        $studentsCount = Student::all()->count();

        // Total de cours
        $total_cours = Cours::all()->count();

        // Affichage des heures de cours par matières
        $heure_cours_par_matiere = DB::table('students')
                                    ->join('cours', 'cours.student_id', '=', 'students.id')
                                    ->join('matieres', 'matieres.id', '=', 'students.matiere_id')
                                    ->where('cours.pack_heures', false)
                                    ->select(DB::raw('matieres.nom, SUM(nombre_heures) as total'))
                                    ->groupBy('matieres.nom')
                                    ->orderBy('total', 'desc')
                                    ->get();

        return view('dashboard')->with([
            'total_heures' => $nb_heures_cours,
            'total_gains' => $total_gains,
            'total_eleves' => $studentsCount,
            'total_cours' => $total_cours,
            'nombre_heures_par_eleve' => $heure_cours_par_matiere
        ]);
    }
}
