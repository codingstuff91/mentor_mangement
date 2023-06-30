<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\Customer;
use App\Models\Facture;
use App\Models\Matiere;
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

        $this->matiere = Matiere::factory()->create();

        $this->customer = Customer::factory()->create()->each(function($client){
            Facture::factory()->create([
                'client_id' => $client->id,
            ]);
        });

        $this->student = Student::factory()->create([
            'matiere_id' => $this->matiere->id,
            'client_id' => Facture::first()->id,
        ]);
    }

    /** @test */
    public function canFetchTheCustomersList()
    {
        $response = $this->get(route('customer.index'));
        $response->assertOk();
    }

    /** @test */
    public function canRenderTheCustomerCreateView()
    {
        $response = $this->get(route('customer.create'));
        $response->assertOk();

        $view = $this->view('customer.create');

        $view->assertSee('Nom du client');
        $view->assertSee('Commentaires');
    }

    /** @test */
    public function canStoreANewCustomer()
    {
        $response = $this->post(route('customer.store', [
            'nom' => 'John Doe',
            'commentaires' => 'Exemple de commentaires',
        ]));

        $this->assertDatabaseCount('customers', 2);
    }

    /** @test */
    public function aCustomerCouldNotBeCreatedWithoutAName()
    {
        $response = $this->post(route('customer.store', [
            'name' => '',
        ]));
        $response->assertSessionHasErrors(['nom']);
    }

    /** @test */
    public function canRenderTheEditViewWithCustomerInformations()
    {
        $response = $this->get(route('customer.edit', Customer::first()));

        $response->assertOk();
        $response->assertSee(Customer::first()->nom);
        $response->assertSee(Customer::first()->commentaires);
    }

    /** @test */
    public function canUpdateCustomerInformations()
    {
        $response = $this->patch(route('customer.update', $this->customer), [
            'nom' => 'test edition'
        ]);

        $this->assertEquals('test edition', Customer::first()->nom);
    }

    /** @test */
    public function canDeleteACustomer()
    {
        $this->delete(route('customer.destroy', $this->customer));

        $this->assertDatabaseCount('customers', 0);
    }
}
