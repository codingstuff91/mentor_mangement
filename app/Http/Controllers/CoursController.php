<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Eleve;
use App\Models\Facture;
use Illuminate\Http\Request;
use App\Services\CoursService;
use App\Http\Requests\StoreCoursRequest;
use App\Http\Requests\UpdateCoursRequest;

class CoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cours = Cours::latest()->get();

        return view('cours.index')->with(['cours' => $cours]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $eleves = Eleve::where('active', true)->get();
        $factures = Facture::with('customer')->where('payee', false)->get();
        
        return view('cours.create')->with(['eleves' => $eleves, 'factures' => $factures]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCoursRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoursRequest $request, CoursService $cours_service)
    {
        $count_hours = $cours_service->count_lesson_hours($request->heure_fin,$request->heure_debut);
        
        $pack_heures = isset($request->pack_heures) ? 1 : 0;
        
        Cours::create([
            'eleve_id' => $request->eleve_id,
            'date_debut' => $request->date_debut ." ". $request->heure_debut,
            'date_fin' => $request->date_debut ." ". $request->heure_fin,
            'nombre_heures' => $count_hours,
            'pack_heures' =>$pack_heures,
            'notions_apprises' => $request->notions,
            'paye' => false,
            'facture_id' => $request->facture_id,
            'taux_horaire' => $request->taux_horaire
        ]);

        return redirect()->route('cours.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function show(Cours $cours)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function edit(Cours $cours, Request $request)
    {
        $cours = Cours::find($request->cour);

        return view('cours.edit')->with(['cours' => $cours]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCoursRequest  $request
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoursRequest $request, Cours $cours, CoursService $cours_service)
    {
        $cours = Cours::find($request->cour);

        $count_hours = $cours_service->count_lesson_hours($request->heure_fin,$request->heure_debut);

        $cours->paye = $request->paye;
        $cours->nombre_heures = $count_hours;
        $cours->date_debut = $request->date_debut ." ". $request->heure_debut;
        $cours->date_fin = $request->date_debut ." ". $request->heure_fin;
        $cours->notions_apprises = $request->notions;

        $cours->save();

        return redirect()->route('cours.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cours $cours, Request $request)
    {
        $cours = Cours::find($request->cour);

        $cours->delete();

        return redirect()->route('cours.index');
    }
}
