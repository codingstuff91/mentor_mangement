<?php

use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
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

test('can fetch all the courses', function () {
    $response = get(route('course.index'));

    $response->assertOk();
});

test('can fetch the students index view', function () {
    $response = $this->get(route('student.index'));
    $response->assertOk();
});

test('can display the students sorted by status', function () {
    $this->get(route('student.index'))
        ->assertOk()
        ->assertSeeInOrder([$this->student->name, $this->inactiveStudent->name]);
});

test('can render student create view', function () {
    $response = get(route('student.create'));
    $response
        ->assertOk()
        ->assertSee('Nom')
        ->assertSee('Matière')
        ->assertSee('Client')
        ->assertSee('Objectifs')
        ->assertSee('Commentaires');
});

test('can render the customers list into the student create view', function () {
    $response = $this->get(route('student.create'));

    $response
        ->assertOk()
        ->assertSee($this->customer->name);
});

test('can render the subjects list into the student create view', function () {
    $response = $this->get(route('student.create'));

    $response
        ->assertOk()
        ->assertSee(Subject::first()->name);
});

test('can store a new student', function () {
    $this->post(route('student.store', $this->studentRequestData->create()));

    $this->assertDatabaseCount('students', 3);
});

test('cannot store a new student without a name', function () {
    $response = $this->post(
        route('student.store'),
        $this->studentRequestData->withName('')->create()
    );

    $response->assertSessionHasErrors('name');
});

test('cannot store a new student without a customer', function () {
    $response = $this->post(
        route('student.store'),
        $this->studentRequestData->create(['customer' => null])
    );

    $response->assertSessionHasErrors('customer');
});

test('cannot store a new student without a subject', function () {
    $response = $this->post(
        route('student.store'),
        $this->studentRequestData->create(['subject' => null])
    );

    $response->assertSessionHasErrors('subject');
});

test('cannot store a new student without goals', function () {
    $response = $this->post(route('student.store'), $this->studentRequestData->withGoals('')->create());

    $response->assertSessionHasErrors('goals');
});

test('can render the show student view', function () {
    $response = $this->get(route('student.show', $this->student));

    $response
        ->assertOk()
        ->assertSee($this->student->name)
        ->assertSee($this->student->objectifs)
        ->assertSee($this->student->subject->name);
});

test('can display total hours of a student', function () {
    $totalCoursesHours = $this->student->courses->sum('hours count');

    $response = $this->get(route('student.show', $this->student));

    $response
        ->assertOk()
        ->assertSeeText($totalCoursesHours);
});

test('can display the course details of a student', function () {
    $response = $this->get(route('student.show', $this->student));

    $firstStudentCourse = $this->student->courses->first();

    $response
        ->assertOk()
        ->assertSee($this->student->goals)
        ->assertSee($firstStudentCourse->date->format('d/m/Y'))
        ->assertSee($firstStudentCourse->start_hour->format('H:i'))
        ->assertSee($firstStudentCourse->end_hour->format('H:i'))
        ->assertSeeText($firstStudentCourse->hours_count . "heure")
        ->assertSee($firstStudentCourse->learned_notions);
});

test('can render the edit student view', function () {
    $response = $this->get(route('student.edit', $this->student));

    $response->assertOk();
});

test('can update a student', function () {
    $response = $this->patch(
        route('student.update', $this->student),
        $this->studentRequestData->create(),
    )->assertSessionHasNoErrors();

    $this->student->refresh();

    expect($this->student->name)
        ->toBe("test")
        ->and($this->student->goals)->toBe("Learn PHP");
});

test('cannot update a student without a name', function () {
    $response = $this->patch(
        route('student.update', $this->student),
        $this->studentRequestData->withName('')->create()
    )->assertSessionHasErrors('name');
});

test('cannot update a student without objectives', function () {
    $response = $this->patch(
        route('student.update', $this->student),
        $this->studentRequestData->withGoals('')->create()
    )->assertSessionHasErrors('goals');
});
