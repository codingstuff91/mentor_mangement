<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\CoursService;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CoursService $coursService)
    {
        $this->courseService = $coursService;
    }

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

        $currentDay = now()->format('Y-m-d');

        return view('course.create')->with([
            'students' => $students,
            'invoices' => $invoices,
            'currentDay' => $currentDay,
        ]);
    }

    /**
     * @param StoreCourseRequest $request
     * @param CoursService $cours_service
     * @return RedirectResponse
     */
    public function store(StoreCourseRequest $request)
    {
        $count_hours = $this->courseService->count_lesson_hours($request->end_hour, $request->start_hour);

        $isHoursPack = isset($request->hours_pack) ? 1 : 0;

        Course::create([
            'student_id' => $request->student,
            'invoice_id' => $request->invoice,
            'date' => $request->date ." ". $request->start_hour,
            'start_hour' => $request->date ." ". $request->start_hour,
            'end_hour' => $request->date ." ". $request->end_hour,
            'hours_count' => $count_hours,
            'hours_pack' => $isHoursPack,
            'learned_notions' => $request->learned_notions,
            'hourly_rate' => $request->hourly_rate
        ]);

        return redirect()->route('course.index');
    }

    /**
     * @param Course $course
     * @return View
     */
    public function edit(Course $course): View
    {
        $latestInvoices = Invoice::limit(12)->orderByDesc('created_at')->get();

        return view('course.edit')->with([
            'course' => $course,
            'latestInvoices' => $latestInvoices,
        ]);
    }

    /**
     * @param UpdateCourseRequest $request
     * @param Course $course
     * @param CoursService $cours_service
     * @return RedirectResponse
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $count_hours = $this->courseService->count_lesson_hours($request->end_hour, $request->start_hour);

        $course->update([
            'paid' => $request->paid,
            'hours_count' => $count_hours,
            'date' => $request->date,
            'start_hour' => $request->date ." ". $request->start_hour,
            'end_hour' => $request->date ." ". $request->end_hour,
            'learned_notions' => $request->learned_notions,
            'invoice_id' => $request->invoice,
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
