<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Facture;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\CoursService;
use App\Http\Requests\StoreCoursRequest;
use App\Http\Requests\UpdateCoursRequest;

class CourseController extends Controller
{

    /**
     * @return View
     */
    public function index()
    {
        $courses = Course::latest()->get();

        return view('course.index')->with(['courses' => $courses]);
    }


    /**
     * @return View
     */
    public function create()
    {
        $students = Student::where('active', true)->get();
        $factures = Facture::with('customer')->where('payee', false)->get();

        return view('course.create')->with(['students' => $students, 'factures' => $factures]);
    }


    /**
     * @param StoreCoursRequest $request
     * @param CoursService $cours_service
     * @return RedirectResponse
     */
    public function store(StoreCoursRequest $request, CoursService $cours_service)
    {
        $count_hours = $cours_service->count_lesson_hours($request->heure_fin,$request->heure_debut);

        $pack_heures = isset($request->pack_heures) ? 1 : 0;

        Course::create([
            'student_id' => $request->student_id,
            'date_debut' => $request->date_debut ." ". $request->heure_debut,
            'date_fin' => $request->date_debut ." ". $request->heure_fin,
            'nombre_heures' => $count_hours,
            'pack_heures' =>$pack_heures,
            'notions_apprises' => $request->notions,
            'paye' => false,
            'facture_id' => $request->facture_id,
            'taux_horaire' => $request->taux_horaire
        ]);

        return redirect()->route('course.index');
    }

    /**
     * @param Course $course
     * @return View
     */
    public function edit(Course $course)
    {
        return view('course.edit')->with(['course' => $course]);
    }


    /**
     * @param UpdateCoursRequest $request
     * @param Course $course
     * @param CoursService $cours_service
     * @return RedirectResponse
     */
    public function update(UpdateCoursRequest $request, Course $course, CoursService $cours_service)
    {
        $count_hours = $cours_service->count_lesson_hours($request->heure_fin, $request->heure_debut);

        $course->update([
            'paye' => $request->paye,
            'nombre_heures' => $count_hours,
            'date_debut' => $request->date_debut ." ". $request->heure_debut,
            'date_fin' => $request->date_debut ." ". $request->heure_fin,
            'notions_apprises' => $request->notions,
        ]);

        return redirect()->route('course.index');
    }


    /**
     * @param Course $course
     * @return RedirectResponse
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('course.index');
    }
}
