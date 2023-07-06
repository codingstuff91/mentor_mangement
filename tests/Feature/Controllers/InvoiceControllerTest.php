<?php

namespace Tests\Feature\Controllers;

use App\Models\Customer;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Invoice;
use App\Models\Matiere;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceControllerTest extends TestCase
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
            Invoice::factory()->create([
                'customer_id' => $customer->id,
            ]);
        });

        $this->eleve = Student::factory()->create([
            'matiere_id' => $this->matiere->id,
            'customer_id' => Customer::first()->id,
        ]);

        $coursesHours = Course::factory(2)->create([
            'student_id'   => Student::first()->id,
            'invoice_id' => Invoice::first()->id,
        ]);
    }

    public function test_it_can_fetch_all_the_invoices()
    {
        $response = $this->get(route('invoice.index'));
        $response->assertOk();
    }

    public function test_it_can_render_the_facture_create_view()
    {
        $response = $this->get(route('facture.create'));

        $response->assertOk();
        $response->assertSee('Nom du client');
    }

    public function test_it_can_show_the_details_of_a_facture()
    {
        $facture = Invoice::first();

        $response = $this->get(route('facture.show', $facture->id));
        $response->assertOk();
    }

    public function test_it_can_show_the_total_number_of_hours_of_a_facture()
    {
        $facture = Invoice::first();
        $totalCoursesHours = Course::all()->count();

        $response = $this->get(route('facture.show', $facture->id));

        $response->assertOk();
        $response->assertSee("Nombre heures : " . $totalCoursesHours);
    }

    public function test_the_total_price_of_a_facture_is_correctly_calculated()
    {
        $facture = Invoice::first();
        $totalPriceOfCourses = Course::select('nombre_heures', 'taux_horaire')->get();

        $totalPrice = $totalPriceOfCourses->sum('taux_horaire');

        $response = $this->get(route('facture.show', $facture->id));

        $response->assertOk();
        $response->assertSee($totalPrice ." €");
    }
}
