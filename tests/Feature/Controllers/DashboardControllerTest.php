<?php

use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use function Pest\Laravel\get;

beforeEach(function () {
    loginAsUser();

    $this->customer = createCustomerWithInvoice();

    $this->student = Student::factory()
        ->for(Subject::factory())
        ->for($this->customer);
});

test('render the dashboard main page', function () {
    get(route('dashboard'))->assertOk();
});

test('show the total of course hours given', function () {
    $response = get(route('dashboard'));

    $response->assertSeeText("Total Heures");
    $response->assertSee(Course::count());
});

test('show the total of students', function () {
    get(route('dashboard'))
        ->assertSeeText("Total Eleves")
        ->assertSee(Student::count());
});

test('show the total revenue', function () {
    $totalRevenues = Course::select(DB::raw('SUM(hours_count * hourly_rate) as total'))->first();

    get(route('dashboard'))
        ->assertSeeText("Total revenus")
        ->assertSee($totalRevenues['total']);
});

test('show the total of courses', function () {
    get(route('dashboard'))
        ->assertSeeText("Total Cours")
        ->assertSee(Course::count());
});
