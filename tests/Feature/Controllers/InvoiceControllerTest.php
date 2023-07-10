<?php

namespace Tests\Feature\Controllers;

use App\Models\Customer;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Invoice;
use App\Models\Subject;
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

        $this->customer = Customer::factory()
                            ->has(Invoice::factory())
                            ->create();

        $this->eleve = Student::factory()
                        ->for(Subject::factory())
                        ->create([
                            'customer_id' => $this->customer->id,
                        ]);
    }

    /** @test */
    public function can_render_the_index_invoices_view()
    {
        $response = $this->get(route('invoice.index'));
        $response->assertOk();
    }

    /** @test */
    public function can_render_the_invoice_create_view()
    {
        $response = $this->get(route('invoice.create'));

        $response->assertOk();
        $response->assertSee('Nom du client');
    }

    /** @test */
    public function can_store_a_new_invoice()
    {
        $customer = Customer::factory()->create();

        $this->post(route('invoice.store'), [
            'customer_id' => $customer->id,
        ]);

        $this->assertDatabaseCount('invoices', 1);
    }

    /** @test */
    public function can_render_the_show_invoice_view()
    {
        $facture = Invoice::first();

        $response = $this->get(route('invoice.show', $facture->id));
        $response->assertOk();
    }

    /** @test */
    public function can_show_the_total_number_of_hours_of_an_invoice()
    {
        $invoice = Invoice::first();

        $totalCoursesHours = $invoice->courses->sum('nombre_heures');

        $response = $this->get(route('invoice.show', $invoice));

        $response->assertOk();
        $response->assertSee("Nombre heures : " . $totalCoursesHours);
    }

    /** @test */
    public function can_display_the_total_price_of_an_invoice()
    {
        $invoice = Invoice::first();

        $totalPrice = $invoice->courses->sum(function ($course) {
            return $course->nombre_heures * $course->taux_horaire;
        });

        $response = $this->get(route('invoice.show', $invoice));

        $response->assertOk();
        $response->assertSee($totalPrice . " €");
    }
}
