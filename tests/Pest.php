<?php

use App\Models\Course;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;
use function Pest\Laravel\actingAs;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/
uses(TestCase::class, RefreshDatabase::class, CreatesApplication::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/
function loginAsUser() {
    $user = User::factory()->create();

    actingAs($user);
}

function createCustomerWithInvoice() {
    return Customer::factory()
        ->has(Invoice::factory()->unpaid())
        ->create();
}

function createStudentWithSubjectAndCustomer(Customer $customer) {
    return Student::factory()
        ->for(Subject::factory())
        ->for($customer)
        ->create();
}

function createCourseWithStudentAndInvoice(Student $student, Invoice $invoice) {
    return course::factory()
        ->for($student)
        ->for($invoice)
        ->create();
}
