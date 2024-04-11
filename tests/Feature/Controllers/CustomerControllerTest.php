<?php

use App\Models\Customer;
use App\Models\Student;
use App\Models\Subject;
use Tests\Factories\CustomerRequestDataFactory;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

beforeEach(function () {
    loginAsUser();

    $this->customer = createCustomerWithInvoice();

    $this->student = Student::factory()
        ->for(Subject::factory())
        ->for($this->customer);

    $this->customerRequestDataFactory = CustomerRequestDataFactory::new();
});

test('can fetch the customers list', function () {
    get(route('customer.index'))
        ->assertOk()
        ->assertSee($this->customer->name)
        ->assertSee($this->customer->comments);
});

test('can render the customer create view', function () {
    $response = get(route('customer.create'));

    $response
        ->assertOk()
        ->assertSee('Nom du client')
        ->assertSee('Commentaires');
});

test('store a new customer', function () {
    post(
        route('customer.store',$this->customerRequestDataFactory->create())
    );

    assertDatabaseCount('customers', 2);
});

test('cannot store a customer without a name', function () {
    $response = post(
        route('customer.store'),
        $this->customerRequestDataFactory->withName('')->create(),
    );

    $response->assertSessionHasErrors(['name']);
});

test('render the edit view with customer informations', function () {
    $response = get(route('customer.edit', Customer::first()));

    $response
        ->assertOk()
        ->assertSee(Customer::first()->name)
        ->assertSee(Customer::first()->comments);
});

test('can update customer informations', function () {
    patch(route('customer.update', $this->customer), [
        'name' => 'test edition'
    ]);

    $this->customer->refresh();

    expect($this->customer->name)->toBe('test edition');
});

test('can delete a customer', function () {
    delete(route('customer.destroy', $this->customer));

    assertDatabaseCount('customers', 0);
});
