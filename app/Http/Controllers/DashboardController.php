<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total d'heures de cours
        $nb_heures_cours = Cours::select(DB::raw("SUM(nombre_heures) as total"))->get();

        // Total argent gagné
        $total_gains = Cours::select(DB::raw('SUM(nombre_heures * taux_horaire) as total'))->get();

        return view('dashboard')->with([
            'total_heures' => $nb_heures_cours,
            'total_gains' => $total_gains
        ]);
    }
}
