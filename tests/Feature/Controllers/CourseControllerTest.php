<?php

use App\Models\Course;
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
    get(route('course.index'))
    ->assertOk();
});

test('can render the course creation view', function () {
    $response = get(route('course.create'));

    $response
        ->assertOk()
        ->assertSee('Eleve')
        ->assertSee('Date du cours')
        ->assertSee('Heure début')
        ->assertSee('Nombre heures')
        ->assertSee('Notions apprises')
        ->assertSee('Taux horaire')
        ->assertSee('Facture concernée');
});

test('render the student create view with unpaid invoices', function () {
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

test('store a new course', function () {
    post(route('course.store'), $this->courseRequestData->create());

    assertDatabaseCount('courses', 1);
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

test('show only the unpaid invoices into invoice select list', function () {
    $response = get(route('course.create'));

    $response
        ->assertOk()
        ->assertSee([
            Invoice::first()->month_year_creation,
            Invoice::first()->customer->nom,
        ]);
});

test('render the edit course view', function () {
    $response = get(route('course.edit', $this->course));

    $response->assertOk();
});

test('render the edit view with course informations', function () {
    $response = get(route('course.edit', $this->course));

    $response
        ->assertOk()
        ->assertSee($this->course->date->format('Y-m-d'))
        ->assertSee($this->course->start_hour->format('H:i'))
        ->assertSee($this->course->paid)
        ->assertSeeText($this->course->learned_notions);
});

test('update a course with its invoice', function () {
    $newInvoice = Invoice::factory()
        ->for($this->customer)
        ->create();

    patch(
        route('course.update', $this->course),
        $this->courseRequestData->create(['invoice' => $newInvoice->id]),
    );

    $this->course->refresh();

    expect($this->course->learned_notions)
        ->toBe("Example notions text")
        ->and($this->course->paid)->toBe(1)
        ->and($this->course->hours_count)->toBe('01:00')
        ->and($this->course->invoice->id)->toBe($newInvoice->id);
});

test('show the 12 latest invoices for the student customer into the select list of edit view', function () {
    $invoices = Invoice::factory()
        ->for($this->customer)
        ->count(12)
        ->create();

    get(route('course.edit', $this->course))
        ->assertOk()
        ->assertSeeText($invoices[0]->id)
        ->assertDontSeeText($invoices[8]->id);
});

test('must not show the invoices of a another customer into the edit view', function () {
    $activeStudentCustomerInvoice = Invoice::factory()
        ->for($this->customer)
        ->create();

    $anotherCustomerInvoice = Invoice::factory()
        ->for(Customer::factory())
        ->create();

    get(route('course.edit', $this->course))
        ->assertOk()
        ->assertSeeText($activeStudentCustomerInvoice->id)
        ->assertDontSeeText($anotherCustomerInvoice->id);
});

test('delete a course', function () {
    delete(route('course.destroy', $this->course))
        ->assertRedirect(route('course.index'));

    $this->assertDatabaseCount('courses', 0);
});
