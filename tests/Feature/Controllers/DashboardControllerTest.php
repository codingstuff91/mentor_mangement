<?php

namespace Tests\Feature\Controllers;

use App\Models\Cours;
use App\Models\Customer;
use App\Models\Facture;
use App\Models\Matiere;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
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

        $this->student = Student::factory(10)->create([
            'matiere_id' => $this->matiere->id,
            'client_id' => Facture::first()->id,
        ]);
    }

    /** @test */
    public function canRenderTheDashboardMainPage()
    {
        $response = $this->get('/dashboard');

        $response->assertOk();
    }

    /** @test */
    public function canShowTheTotalOfCourseHoursGiven()
    {
        $response = $this->get('/dashboard');

        $response->assertSeeText("Total Heures");
        $response->assertSee(Cours::count());
    }

    /** @test */
    public function canShowTheTotalOfStudents()
    {
        $response = $this->get('/dashboard');

        $response->assertSeeText("Total Eleves");
        $response->assertSee(Student::count());
    }

    /** @test */
    public function canShowTheTotalRevenue()
    {
        $response = $this->get('/dashboard');

        $response->assertSeeText("Total revenus");
        $response->assertSee(Student::count());
    }

    /** @test */
    public function canShowTheTotalOfCourses()
    {
        $response = $this->get('/dashboard');

        $response->assertSeeText("Total Cours");
        $response->assertSee(Cours::count());
    }
}
