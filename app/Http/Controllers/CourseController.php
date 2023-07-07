<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Invoice;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\CoursService;
use App\Http\Requests\CoursRequest;
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
        $students = Student::active()->get();
        $invoices = Invoice::with('customer')->unpaid()->get();

        return view('course.create')->with(['students' => $students, 'invoices' => $invoices]);
    }


    /**
     * @param CoursRequest $request
     * @param CoursService $cours_service
     * @return RedirectResponse
     */
    public function store(Request $request, CoursService $cours_service)
    {
        $count_hours = $cours_service->count_lesson_hours($request->heure_fin,$request->heure_debut);

        $pack_heures = isset($request->pack_heures) ? 1 : 0;

        Course::create([
            'student_id' => $request->student,
            'invoice_id' => $request->invoice,
            'date_debut' => $request->date_debut ." ". $request->heure_debut,
            'date_fin' => $request->date_debut ." ". $request->heure_fin,
            'nombre_heures' => $count_hours,
            'pack_heures' => $pack_heures,
            'notions_apprises' => $request->notions_apprises,
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
    public function update(CoursRequest $request, Course $course, CoursService $cours_service)
    {
        $count_hours = $cours_service->count_lesson_hours($request->heure_fin, $request->heure_debut);

        $course->update([
            'paye' => $request->paye,
            'nombre_heures' => $count_hours,
            'date_debut' => $request->date_debut ." ". $request->heure_debut,
            'date_fin' => $request->date_debut ." ". $request->heure_fin,
            'notions_apprises' => $request->notions_apprises,
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
