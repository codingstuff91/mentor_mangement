<?php

use App\Models\Invoice;
use App\Services\InvoiceService;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

beforeEach(function () {
    loginAsUser();

    $this->customer = createCustomerWithInvoice();

    $this->student = createStudentWithSubjectAndCustomer($this->customer);

    $this->course = createCourseWithStudentAndInvoice($this->student, $this->customer->invoice->first());
});

test('render the index invoices view', function () {
    get(route('invoice.index'))
    ->assertOk();
});

test('render the invoice create view', function () {
    get(route('invoice.create'))
    ->assertOk()
    ->assertSee('Nom du client');
});

test('store a new invoice', function () {
    post(route('invoice.store'), [
        'customer' => $this->customer->id,
    ]);

    $this->assertDatabaseCount('invoices', 2);
});

test('renders the show invoice view', function () {
    $invoice = Invoice::first();

    get(route('invoice.show', $invoice->id))
    ->assertOk();
});

test('display the total price of an invoice', function () {
    $invoice = Invoice::first();

    $totalPrice = InvoiceService::compute_total_price($invoice);

    get(route('invoice.show', $invoice))
    ->assertOk()
    ->assertSee($totalPrice . " €");
});

test('display the total hours count of an invoice', function () {
    $invoice = Invoice::first();

    $invoiceTotalHours = InvoiceService::compute_total_hours($invoice);

    get(route('invoice.show', $invoice))
    ->assertOk()
    ->assertSee("Nombre heures : " . $invoiceTotalHours);
});

test('update the status paid to an invoice', function () {
    patch(route('invoice.update', $this->course->invoice), [
        'paid' => 1,
    ]);

    expect(Invoice::first()->paid)->toBeTrue();
});

test('Delete an invoice', function () {
    delete(route('invoice.destroy', $this->course->invoice));

    expect(Invoice::count())->toBe(0);
});

