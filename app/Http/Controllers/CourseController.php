<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Facture;
use Illuminate\Http\Request;
use App\Services\CoursService;
use App\Http\Requests\StoreCoursRequest;
use App\Http\Requests\UpdateCoursRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::latest()->get();

        return view('course.index')->with(['courses' => $courses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = Student::where('active', true)->get();
        $factures = Facture::with('customer')->where('payee', false)->get();

        return view('course.create')->with(['students' => $students, 'factures' => $factures]);
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

        Course::create([
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
     * @param  \App\Models\Course  $cours
     * @return \Illuminate\Http\Response
     */
    public function show(Course $cours)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $cours
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $cours, Request $request)
    {
        $cours = Course::find($request->cour);

        return view('cours.edit')->with(['cours' => $cours]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCoursRequest  $request
     * @param  \App\Models\Course  $cours
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoursRequest $request, Course $cours, CoursService $cours_service)
    {
        $cours = Course::find($request->cour);

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
     * @param  \App\Models\Course  $cours
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $cours, Request $request)
    {
        $cours = Course::find($request->cour);

        $cours->delete();

        return redirect()->route('cours.index');
    }
}
