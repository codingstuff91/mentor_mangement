<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Client;
use App\Models\Subject;
use App\Http\Requests\StoreEleveRequest;
use App\Http\Requests\UpdateEleveRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('client')->orderBy('active', 'desc')->get();

        return view('student.index')->with(['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        $matieres = Subject::all();

        return view('student.create')->with(['clients' => $clients, 'matieres' => $matieres]);
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
            'matiere_id' => $request->matiere,
            'client_id' => $request->client,
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
        ->with(['cours', 'matiere'])
        ->withCount('cours')
        ->first();

        return view('student.show')->with(['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $matieres = Subject::all();
        $clients = Client::all();

        return view('student.edit')->with([
            'student' => $student,
            'matieres' => $matieres,
            'clients' => $clients
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEleveRequest  $request
     * @param  \App\Models\Student  $eleve
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEleveRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()->route('student.index');
    }
}
