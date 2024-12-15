<?php

use App\Services\InvoiceService;

it('computes the total price of an invoice', function () {
    $customer = createCustomerWithInvoice();

    $student = createStudentWithSubjectAndCustomer($customer);

    createCourseWithStudentAndInvoice($student, $customer->invoice->first());
    createCourseWithStudentAndInvoice($student, $customer->invoice->first());
    createCourseWithStudentAndInvoice($student, $customer->invoice->first());

    $totalInvoicePrice = InvoiceService::compute_total_price($customer->invoice->first());

    expect($totalInvoicePrice)->toBe(30);
});

it('computes the total course hours of an invoice', function () {
    $customer = createCustomerWithInvoice();

    $student = createStudentWithSubjectAndCustomer($customer);

    createCourseWithStudentAndInvoice($student, $customer->invoice->first());

    createCourseWithStudentAndInvoice($student, $customer->invoice->first());

    createCourseWithStudentAndInvoice($student, $customer->invoice->first());

    $totalCourseHours = InvoiceService::compute_total_hours($customer->invoice->first());

    expect($totalCourseHours)->toBe("03:00");
});
