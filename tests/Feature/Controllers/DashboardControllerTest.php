<?php

namespace Tests\Feature\Controllers;

use App\Models\Course;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Matiere;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
            Invoice::factory()->create([
                'client_id' => $client->id,
            ]);
        });

        $this->student = Student::factory(10)->create([
            'matiere_id' => $this->matiere->id,
            'client_id' => Invoice::first()->id,
        ]);

        $coursesHours = Course::factory(2)->create([
            'student_id'   => Student::first()->id,
            'facture_id' => Invoice::first()->id,
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
        $response->assertSee(Course::count());
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
        $totalRevenues = Course::select(DB::raw('SUM(nombre_heures * taux_horaire) as total'))->first();

        $response->assertSeeText("Total revenus");
        $response->assertSee($totalRevenues['total']);
    }

    /** @test */
    public function canShowTheTotalOfCourses()
    {
        $response = $this->get('/dashboard');

        $response->assertSeeText("Total Cours");
        $response->assertSee(Course::count());
    }
}
