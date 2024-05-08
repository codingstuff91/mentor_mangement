<?php

use App\Models\Course;
use function Pest\Laravel\artisan;

it('updates courses with duration based on the hours count old column', function () {
    // Given
    $customer = createCustomerWithInvoice();
    $student = createStudentWithSubjectAndCustomer($customer);
    createCourseWithStudentAndInvoice($student, $customer->invoice->first());

    // Put wrong price value for the first course
    $course = Course::first();
    $course->hours_count = 1;
    $course->save();

//    dd($course);

    // When (launch the command)
    artisan('courses:regul-hours-count');

    // Then (check the price is updated)
    expect(Course::first()->duration)->toBe("01:00");
});
