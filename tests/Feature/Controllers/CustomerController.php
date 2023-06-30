<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Eleve;
use App\Models\Customer;
use App\Http\Controllers\CustomerController;
use App\Models\Facture;
use App\Models\Matiere;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\WithFaker;
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

        $this->client = Client::factory()->create()->each(function($client){
            Facture::factory()->create([
                'client_id' => $client->id,
            ]);
        });

        $this->eleve = Eleve::factory()->create([
            'matiere_id' => $this->matiere->id,
            'client_id' => Facture::first()->id,
        ]);
    }

    public function test_it_can_fetch_all_the_clients()
    {        
        $response = $this->get(route('customer.index'));
        $response->assertOk();
    }

    public function test_it_can_render_the_client_create_view()
    {
        $response = $this->get(route('client.create'));
        $response->assertOk();

        $view = $this->view('client.create');

        $view->assertSee('Nom du client');
        $view->assertSee('Commentaires');
    }

    public function test_it_can_create_a_client()
    {
        $response = $this->post(route('client.store', [
            'nom' => 'John Doe',
            'commentaires' => 'Exemple de commentaires',
        ]));

        $this->assertDatabaseCount('clients', 2);
    }

    public function test_a_client_can_not_be_created_without_a_name()
    {
        $response = $this->post(route('client.store', [
            'name' => '',
        ]));
        $response->assertSessionHasErrors(['nom']);
    }

    public function test_it_can_render_the_client_view_with_client_informations()
    {
        $response = $this->get(route('client.edit', Client::first()->id));

        $response->assertOk();
        $response->assertSee(Client::first()->nom);
        $response->assertSee(Client::first()->commentaires);
    }

    public function test_a_client_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $client = Client::factory()->create();

        $response = $this->patch(route('client.update', $client->id), [
            'nom' => 'test edition'
        ]);

        $this->assertEquals('test edition', Client::find($client->id)->nom); 
    }
}
