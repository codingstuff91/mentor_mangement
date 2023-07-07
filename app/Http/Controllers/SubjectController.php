<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\SubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SubjectController extends Controller
{

    /**
     * @return View
     */
    public function index()
    {
        $subjects = Subject::all();

        return view('subject.index')->with(['subjects' => $subjects]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('subject.create');
    }

    /**
     * @param SubjectRequest $request
     * @return RedirectResponse
     */
    public function store(SubjectRequest $request): RedirectResponse
    {
        Subject::create($request->validated());

        return redirect()->route('subject.index');
    }

    /**
     * @param Subject $subject
     * @return View
     */
    public function edit(Subject $subject)
    {
        return view('subject.edit')->with(['subject' => $subject]);
    }

    /**
     * @param SubjectRequest $request
     * @param Subject $subject
     * @return RedirectResponse
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());

        return redirect()->route('subject.index');
    }

    /**
     * @param Subject $subject
     * @return RedirectResponse
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subject.index');
    }
}
