<?php

use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use App\Services\StudentService;
use Tests\Factories\StudentRequestDataFactory;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

beforeEach(function () {
    loginAsUser();

    $this->customer = createCustomerWithInvoice();

    $this->student = createStudentWithSubjectAndCustomer($this->customer);

    $this->course = createCourseWithStudentAndInvoice($this->student, $this->customer->invoice->first());

    $this->inactiveStudent = Student::factory()
        ->inactive()
        ->for(Subject::factory())
        ->has(Course::factory())
        ->create([
            'customer_id' => $this->customer->id,
        ]);

    $this->studentRequestData = StudentRequestDataFactory::new();
});

test('can fetch the students index view', function () {
    $response = $this->get(route('student.index'));
    $response->assertOk();
});

test('can display the students sorted by status', function () {
    get(route('student.index'))
        ->assertOk()
        ->assertSeeInOrder([$this->student->name, $this->inactiveStudent->name]);
});

test('can render student create view', function () {
    get(route('student.create'))
        ->assertOk()
        ->assertSee('Nom')
        ->assertSee('Matière')
        ->assertSee('Client')
        ->assertSee('Objectifs')
        ->assertSee('Commentaires');
});

test('can render the customers list into the student create view', function () {
    get(route('student.create'))
        ->assertOk()
        ->assertSee($this->customer->name);
});

test('can render the subjects list into the student create view', function () {
    get(route('student.create'))
        ->assertOk()
        ->assertSee(Subject::first()->name);
});

test('can store a new student', function () {
    post(route('student.store', $this->studentRequestData->create()));

    $this->assertDatabaseCount('students', 3);
});

test('cannot store a new student without a name', function () {
    post(
        route('student.store'),
        $this->studentRequestData->withName('')->create()
    )->assertSessionHasErrors('name');
});

test('cannot store a new student without a customer', function () {
    post(
        route('student.store'),
        $this->studentRequestData->create(['customer' => null])
    )->assertSessionHasErrors('customer');
});

test('cannot store a new student without a subject', function () {
    post(
        route('student.store'),
        $this->studentRequestData->create(['subject' => null])
    )->assertSessionHasErrors('subject');
});

test('cannot store a new student without goals', function () {
    post(
        route('student.store'),
        $this->studentRequestData->withGoals('')->create()
    )->assertSessionHasErrors('goals');
});

test('can render the show student view', function () {
    get(route('student.show', $this->student))
        ->assertOk()
        ->assertSee($this->student->name)
        ->assertSee($this->student->objectifs)
        ->assertSee($this->student->subject->name);
});

test('can display the total hours of a student on the show view', function () {
    $totalCoursesHours = StudentService::count_total_hours($this->student);

    get(route('student.show', $this->student))
        ->assertOk()
        ->assertSeeText($totalCoursesHours);
});

test('can display the course details of a student', function () {
    $firstStudentCourse = $this->student->courses->first();

    get(route('student.show', $this->student))
        ->assertOk()
        ->assertSee($this->student->goals)
        ->assertSee($firstStudentCourse->date->format('d/m/Y'))
        ->assertSee($firstStudentCourse->start_hour->format('H:i'))
        ->assertSee($firstStudentCourse->end_hour->format('H:i'))
        ->assertSeeText($firstStudentCourse->hours_count . "heure")
        ->assertSee($firstStudentCourse->learned_notions);
});

test('can render the edit student view', function () {
    get(route('student.edit', $this->student))
        ->assertOk();
});

test('can update a student', function () {
    patch(
        route('student.update', $this->student),
        $this->studentRequestData->create(),
    )->assertSessionHasNoErrors();

    $this->student->refresh();

    expect($this->student->name)
        ->toBe("test")
        ->and($this->student->goals)->toBe("Learn PHP");
});

test('cannot update a student without a name', function () {
    patch(
        route('student.update', $this->student),
        $this->studentRequestData->withName('')->create()
    )->assertSessionHasErrors('name');
});

test('cannot update a student without objectives', function () {
    patch(
        route('student.update', $this->student),
        $this->studentRequestData->withGoals('')->create()
    )->assertSessionHasErrors('goals');
});
