<?php

use App\Services\StudentService;

it('counts the total course hours of a student', function () {
    $customer = createCustomerWithInvoice();

    $student = createStudentWithSubjectAndCustomer($customer);

    createCourseWithStudentAndInvoice($student, $customer->invoice->first());

    createCourseWithStudentAndInvoice($student, $customer->invoice->first());

    $totalCoursesHours = StudentService::count_total_hours($student);

    expect($totalCoursesHours)->toBe("02:00");
});
