<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Customer;
use App\Models\Subject;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class StudentController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $students = Student::with('customer')->orderByDesc('id')->get();

        return view('student.index')->with(['students' => $students]);
    }

    /**
     * @return View
     */
    public function create()
    {
        $customers = Customer::all();
        $subjects = Subject::all();

        return view('student.create')->with(['customers' => $customers, 'subjects' => $subjects]);
    }

    /**
     * @param StoreStudentRequest $request
     * @return RedirectResponse
     */
    public function store(StoreStudentRequest $request)
    {
        Student::create([
            'nom' => $request->nom,
            'subject_id' => $request->subject,
            'customer_id' => $request->customer,
            'objectifs' => $request->objectifs,
            'commentaires' => $request->commentaires
        ]);

        return redirect()->route('student.index');
    }

    /**
     * @param Student $student
     * @return View
     */
    public function show(Student $student)
    {
        $student = Student::where('id',$student->id)
        ->with(['courses', 'subject'])
        ->withCount('courses')
        ->first();

        return view('student.show')->with(['student' => $student]);
    }

    /**
     * @param Student $student
     * @return View
     */
    public function edit(Student $student)
    {
        $subjects = Subject::all();
        $customers = Customer::all();

        return view('student.edit')->with([
            'student' => $student,
            'subjects' => $subjects,
            'customers' => $customers
        ]);
    }

    /**
     * @param UpdateStudentRequest $request
     * @param Student $student
     * @return RedirectResponse
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()->route('student.index');
    }
}
