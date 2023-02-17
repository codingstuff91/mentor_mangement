<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Eleve;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Matiere;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FactureControllerTest extends TestCase
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

    public function test_it_can_fetch_all_the_factures()
    {
        $response = $this->get(route('facture.index'));
        $response->assertOk();
    }

    public function test_it_can_render_the_facture_create_view()
    {
        $response = $this->get(route('facture.create'));

        $response->assertOk();
        $response->assertSee('Nom du client');
    }
}
