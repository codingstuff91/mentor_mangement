<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Eleve;
use App\Models\Customer;
use App\Models\Facture;
use App\Models\Matiere;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatiereControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $user = User::first();

        $this->actingAs($user);

        $this->matiere = Matiere::factory()->create();

        $this->client = Customer::factory()->create()->each(function($client){
            Facture::factory()->create([
                'client_id' => $client->id,
            ]);
        });

        $this->eleve = Eleve::factory()->create([
            'matiere_id' => $this->matiere->id,
            'client_id' => Customer::first()->id,
        ]);
    }

    public function test_it_can_fetch_all_the_matieres()
    {
        $response = $this->get(route('matiere.index'));
        $response->assertOk();
    }

    public function test_it_can_render_the_client_create_view()
    {
        $response = $this->get(route('matiere.create'));
        
        $response->assertOk();
        $response->assertSee('Nom de la matière');
    }

    public function test_it_can_create_a_new_matiere()
    {
        $response = $this->post(route('matiere.store', [
            'nom' => 'New matiere',
        ]));

        $this->assertDatabaseCount('matieres', 2);
    }

    public function test_a_matiere_can_not_be_created_without_a_name()
    {
        $response = $this->post(route('matiere.store', [
            'nom' => '',
        ]));

        $response->assertSessionHasErrors(['nom']);
    }

    public function test_a_matiere_can_be_updated()
    {
        $matiere = Matiere::factory()->create();

        $response = $this->put(route('matiere.update', $matiere->id),[
            'nom' => 'matiere updated'
        ]);

        $this->assertEquals('matiere updated', Matiere::find($matiere->id)->nom); 
    }
}
