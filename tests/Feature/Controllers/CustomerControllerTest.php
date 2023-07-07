<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Subject;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $user = User::first();

        $this->actingAs($user);

        $this->subject = Subject::factory()->create();

        $this->customer = Customer::factory()
                            ->has(Invoice::factory())
                            ->create();

        $this->student = Student::factory()->create([
            'subject_id' => $this->subject->id,
            'customer_id' => Customer::first()->id,
        ]);
    }

    /** @test */
    public function can_fetch_the_customers_list()
    {
        $response = $this->get(route('customer.index'));
        $response->assertOk();
    }

    /** @test */
    public function can_render_the_customer_create_view()
    {
        $response = $this->get(route('customer.create'));
        $response->assertOk();

        $view = $this->view('customer.create');

        $view->assertSee('Nom du client');
        $view->assertSee('Commentaires');
    }

    /** @test */
    public function can_store_a_new_customer()
    {
        $response = $this->post(route('customer.store', [
            'nom' => 'John Doe',
            'commentaires' => 'Exemple de commentaires',
        ]));

        $this->assertDatabaseCount('customers', 2);
    }

    /** @test */
    public function cannot_store_a_new_customer_without_a_name()
    {
        $response = $this->post(route('customer.store', [
            'name' => '',
        ]));
        $response->assertSessionHasErrors(['nom']);
    }

    /** @test */
    public function can_render_the_edit_view_with_customer_informations()
    {
        $response = $this->get(route('customer.edit', Customer::first()));

        $response->assertOk();
        $response->assertSee(Customer::first()->nom);
        $response->assertSee(Customer::first()->commentaires);
    }

    /** @test */
    public function can_update_customer_informations()
    {
        $this->patch(route('customer.update', $this->customer), [
            'nom' => 'test edition'
        ]);

        $this->customer->refresh();

        $this->assertEquals('test edition', $this->customer->nom);
    }

    /** @test */
    public function can_delete_a_customer()
    {
        $this->delete(route('customer.destroy', $this->customer));

        $this->assertDatabaseCount('customers', 0);
    }
}
