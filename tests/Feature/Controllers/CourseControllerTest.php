<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Customer;
use App\Models\Facture;
use App\Models\Matiere;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $user = User::first();

        $this->actingAs($user);

        $this->matiere = Matiere::factory()->create();

        $this->customer = Customer::factory()->create()->each(function($customer){
            Facture::factory()->create([
                'customer_id' => $customer->id,
                'payee' => false,
            ]);

            Facture::factory()->create([
                'customer_id' => $customer->id,
                'payee' => true,
            ]);
        });

        $this->eleve = Student::factory()->create([
            'matiere_id' => $this->matiere->id,
            'customer_id' => Facture::first()->id,
        ]);

        $this->cours = Course::factory()->create([
            'student_id' => 1,
            'facture_id' => 1
        ]);
    }

    /** @test */
    public function canFetchAllTheCourses()
    {
        $response = $this->get(route('course.index'));
        $response->assertOk();
    }

    /** @test */
    public function canRenderTheCourseCreationView()
    {
        $response = $this->get(route('course.create'));
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
        $response = $this->get(route('course.create'));
        $response->assertOk();

        $facturePayee = Facture::where('payee', true)->get()->first();

        $response->assertSee(Facture::first()->id);
        $response->assertDontSee('value=' . $facturePayee->id);
    }
}
