<?php

use App\Models\Customer;
use App\Models\Invoice;
use Tests\Factories\CourseRequestDataFactory;
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

    $this->courseRequestData = CourseRequestDataFactory::new();
});

test('can fetch all the courses', function () {
    $response = get(route('course.index'));

    $response->assertOk();
});

test('can render the course creation view', function () {
    $response = get(route('course.create'));

    $response
        ->assertOk()
        ->assertSee('Eleve')
        ->assertSee('Date du cours')
        ->assertSee('Heure début')
        ->assertSee('Heure fin')
        ->assertSee('Notions apprises')
        ->assertSee('Taux horaire')
        ->assertSee('Facture concernée');
});

test('can render the student create view with unpaid invoices', function () {
    $unpaidInvoice = Invoice::factory()
        ->for(Customer::factory())
        ->unpaid()
        ->create();

    $paidInvoice = Invoice::factory()
        ->for(Customer::factory())
        ->paid()
        ->create();

    $response = get(route('course.create'));

    $response
        ->assertOk()
        ->assertSee($unpaidInvoice->month_year_creation . " -- " . $unpaidInvoice->customer->name )
        ->assertDontSee($paidInvoice->month_year_creation . " -- " . $paidInvoice->customer->name );
});

test('fills the create student page with current date', function () {
    $currentDate = now()->format('Y-m-d');

    $response = $this->get(route('course.create'));

    $response->assertOk();
    $response->assertSee($currentDate);
});

test('can store a new course', function () {
    post(route('course.store'), $this->courseRequestData->create());

    assertDatabaseCount('courses', 2);
});

test('cannot store a new course without choosing an student', function () {
    $response = post(route('course.store'), $this->courseRequestData->create(['student' => null]));

    $response->assertSessionHasErrors('student');
});

test('cannot store a new course without a start hour', function () {
    $response = $this->post(route('course.store'), $this->courseRequestData->create(['start_hour' => null]));

    $response->assertSessionHasErrors('start_hour');
});

test('cannot store a new course without an end hour', function () {
    $response = post(route('course.store'), $this->courseRequestData->create(['end_hour' => null]));

    $response->assertSessionHasErrors('end_hour');
});

test('cannot store a new course without writing the course covered concepts', function () {
    $response = post(route('course.store'), $this->courseRequestData->create(['learned_notions' => null]));

    $response->assertSessionHasErrors('learned_notions');
});

test('cannot store a new course without giving an hourly rate price', function () {
    $response = post(route('course.store'), $this->courseRequestData->create(['hourly_rate' => null]));

    $response->assertSessionHasErrors('hourly_rate');
});

test('cannot store a new course without choosing an active invoice', function () {
    $response = post(route('course.store'), $this->courseRequestData->create(['invoice' => null]));

    $response->assertSessionHasErrors('invoice');
});

test('only the unpaid invoices are available into invoice select list', function () {
    $response = get(route('course.create'));

    $response
        ->assertOk()
        ->assertSee([
            Invoice::first()->month_year_creation,
            Invoice::first()->customer->nom,
        ]);
});

test('can render the edit course view', function () {
    $response = get(route('course.edit', $this->course));

    $response->assertOk();
});

test('can render the edit view with course informations', function () {
    $response = get(route('course.edit', $this->course));

    $response
        ->assertOk()
        ->assertSee($this->course->date->format('Y-m-d'))
        ->assertSee($this->course->start_hour->format('H:i'))
        ->assertSee($this->course->end_hour->format('H:i'))
        ->assertSee($this->course->paid)
        ->assertSeeText($this->course->learned_notions);
});

test('can update a course', function () {
    patch(route('course.update', $this->course), [
        'paid' => true,
        'date' => "2023-07-01",
        "start_hour" => "18:00",
        "end_hour" => "19:00",
        'learned_notions' => "texte",
    ]);

    $this->course->refresh();

    expect($this->course->learned_notions)
        ->toBe("texte")
        ->and($this->course->paid)->toBe(1)
        ->and($this->course->hours_count)->toBe(1);
});

test('can delete a course', function () {
    delete(route('course.destroy', $this->course))
        ->assertRedirect(route('course.index'));

    $this->assertDatabaseCount('courses', 0);
});
