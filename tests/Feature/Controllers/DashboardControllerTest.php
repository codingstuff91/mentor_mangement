<?php

namespace Tests\Feature\Controllers;

use App\Models\Course;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Subject;
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

        $this->customer = Customer::factory()
                            ->has(Invoice::factory())
                            ->create();

        $this->student = Student::factory(10)
            ->for(Subject::factory())
            ->create([
                'customer_id' => $this->customer->id,
            ]);
    }

    /** @test */
    public function can_render_the_dashboard_main_page()
    {
        $response = $this->get('/dashboard');

        $response->assertOk();
    }

    /** @test */
    public function can_show_the_total_of_course_hours_given()
    {
        $response = $this->get('/dashboard');

        $response->assertSeeText("Total Heures");
        $response->assertSee(Course::count());
    }

    /** @test */
    public function can_show_the_total_of_students()
    {
        $response = $this->get('/dashboard');

        $response->assertSeeText("Total Eleves");
        $response->assertSee(Student::count());
    }

    /** @test */
    public function can_show_the_total_revenue()
    {
        $response = $this->get('/dashboard');
        $totalRevenues = Course::select(DB::raw('SUM(hours_count * hourly_rate) as total'))->first();

        $response->assertSeeText("Total revenus");
        $response->assertSee($totalRevenues['total']);
    }

    /** @test */
    public function can_show_the_total_of_courses()
    {
        $response = $this->get('/dashboard');

        $response->assertSeeText("Total Cours");
        $response->assertSee(Course::count());
    }
}
