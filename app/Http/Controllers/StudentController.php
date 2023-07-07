<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Customer;
use App\Models\Subject;
use App\Http\Requests\StoreEleveRequest;
use App\Http\Requests\StudentRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('customer')->orderByDesc('id')->get();

        return view('student.index')->with(['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $subjects = Subject::all();

        return view('student.create')->with(['customers' => $customers, 'subjects' => $subjects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEleveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEleveRequest $request)
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
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $eleve
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StudentRequest  $request
     * @param  \App\Models\Student  $eleve
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()->route('student.index');
    }
}
