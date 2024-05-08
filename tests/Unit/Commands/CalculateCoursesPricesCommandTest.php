<?php

use App\Models\Course;
use function Pest\Laravel\artisan;

it('updates courses tables with calculated courses prices', function () {
    // Given
    $customer = createCustomerWithInvoice();
    $student = createStudentWithSubjectAndCustomer($customer);
    createCourseWithStudentAndInvoice($student, $customer->invoice->first());

    // Put wrong price value for the first course
    $course = Course::first();
    $course->price = 2;
    $course->save();

    // When (launch the command)
    artisan('courses:calculate-prices');

    // Then (check the price is updated)
    expect(Course::first()->price)->toBe(10.0);
});
