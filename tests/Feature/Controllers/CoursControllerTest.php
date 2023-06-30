<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cours;
use App\Models\Eleve;
use App\Models\Customer;
use App\Models\Facture;
use App\Models\Matiere;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoursControllerTest extends TestCase
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
                'payee' => false,
            ]);

            Facture::factory()->create([
                'client_id' => $client->id,
                'payee' => true,
            ]);
        });

        $this->eleve = Eleve::factory()->create([
            'matiere_id' => $this->matiere->id,
            'client_id' => Facture::first()->id,
        ]);

        $this->cours = Cours::factory()->create([
            'eleve_id' => 1,
            'facture_id' => 1
        ]);
    }

    public function test_it_can_fetch_all_the_courses()
    {
        $response = $this->get(route('cours.index'));
        $response->assertOk();
    }

    public function test_it_can_render_the_course_create_view()
    {
        $response = $this->get(route('cours.create'));
        $response->assertOk();

        $response->assertSee('Eleve');
        $response->assertSee('Date du cours');
        $response->assertSee('Heure début');
        $response->assertSee('Heure fin');
        $response->assertSee('Notions apprises');
        $response->assertSee('Taux horaire');
        $response->assertSee('Facture concernée');
    }

    public function test_it_can_render_only_the_active_factures_in_select_list()
    {
        $response = $this->get(route('cours.create'));
        $response->assertOk();

        $facturePayee = Facture::where('payee', true)->get()->first();

        $response->assertSee(Facture::first()->id);
        $response->assertDontSee('value=' . $facturePayee->id);
    }
}
