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

test('can render the dashboard main page', function () {
    $response = get(route('dashboard'));

    expect($response->status())->toBe(200);
});

test('can show the total of course hours given', function () {
    $response = get(route('dashboard'));

    $response->assertSeeText("Total Heures");
    $response->assertSee(Course::count());
});

test('can show the total of students', function () {
    $response = get(route('dashboard'));

    $response->assertSeeText("Total Eleves");
    $response->assertSee(Student::count());
});

test('can show the total revenue', function () {
    $totalRevenues = Course::select(DB::raw('SUM(hours_count * hourly_rate) as total'))->first();

    $response = get(route('dashboard'));
    $response->assertSeeText("Total revenus");

    $response->assertSee($totalRevenues['total']);
});

test('can show the total of courses', function () {
    $response = get(route('dashboard'));

    $response->assertSeeText("Total Cours");
    $response->assertSee(Course::count());
});
