<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Subject;
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

        $this->customer = Customer::factory()
            ->has(Invoice::factory()->unpaid())
            ->create();

        $this->student = Student::factory()
            ->for(Subject::factory())
            ->create([
                'customer_id' => $this->customer->id,
            ]);

        $this->course = course::factory()
            ->has(Student::factory())
            ->create([
                'invoice_id' => Invoice::first()->id,
            ]);

        $this->courseAttributes = [
            'student_id' => $this->student->id,
            'invoice_id' => Invoice::first()->id,
            "heure_debut" => "18:00",
            "heure_fin" => "19:00",
            'date_debut' => "2023-07-01 18:00:00",
            'date_fin' => "2023-07-01 19:00:00",
            'notions' => "description des notions",
            'taux_horaire' => 50,
        ];
    }

    /** @test */
    public function can_fetch_all_the_courses()
    {
        $response = $this->get(route('course.index'));
        $response->assertOk();
    }

    /** @test */
    public function can_render_the_course_creation_view()
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

    /** @test */
    public function can_render_the_student_create_view_with_unpaid_invoices()
    {
        $unpaidInvoice = Invoice::factory()
                        ->for(Customer::factory())
                        ->unpaid()
                        ->create();

        $paidInvoice = Invoice::factory()
                        ->for(Customer::factory())
                        ->paid()
                        ->create();

        $response = $this->get(route('course.create'));
        $response->assertOk();
        $response->assertSee($unpaidInvoice->month_year_creation . " -- " . $unpaidInvoice->customer->nom );
    }

    /** @test */
    public function can_store_a_new_course()
    {
        $this->post(route('course.store'), [
            'student' => $this->student->id,
            'invoice' => Invoice::first()->id,
            "heure_debut" => "18:00",
            "heure_fin" => "19:00",
            'date_debut' => "2023-07-01 18:00:00",
            'date_fin' => "2023-07-01 19:00:00",
            'notions_apprises' => "description des notions",
            'taux_horaire' => 50,
        ]);

        $this->assertDatabaseCount('courses', 2);
    }

    /** @test */
    public function cannot_store_a_new_course_without_choising_an_student()
    {
        $attributes = array_merge($this->courseAttributes, [
            'student' => '',
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('student');
    }

    /** @test */
    public function cannot_store_a_new_course_without_choising_a_date()
    {
        $attributes = array_merge($this->courseAttributes, [
            'date_debut' => '',
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('date_debut');
    }

    /** @test */
    public function cannot_store_a_new_course_without_choising_a_start_hour_and_end_hour()
    {
        $attributes = array_merge($this->courseAttributes, [
            'heure_debut' => '',
            'heure_fin' => ''
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('heure_debut');
        $response->assertSessionHasErrors('heure_fin');
    }

    /** @test */
    public function cannot_store_a_new_course_without_writing_the_course_covered_concepts()
    {
        $attributes = array_merge($this->courseAttributes, [
            'notions_apprises' => '',
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('notions_apprises');
    }

    /** @test */
    public function cannot_store_a_new_course_without_giving_an_hourly_rate_price()
    {
        $attributes = array_merge($this->courseAttributes, [
            'taux_horaire' => '',
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('taux_horaire');
    }

    /** @test */
    public function cannot_store_a_new_course_without_choosing_an_active_invoice()
    {
        $attributes = array_merge($this->courseAttributes, [
            'invoice' => '',
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('invoice');
    }

    /** @test */
    public function can_render_only_the_unpaid_invoices_in_select_invoice_list()
    {
        $response = $this->get(route('course.create'));
        $response->assertOk();

        $response->assertSee([
            Invoice::first()->month_year_creation,
            Invoice::first()->customer->nom,
        ]);
    }

    /** @test */
    public function can_render_the_edit_course_view()
    {
        $response = $this->get(route('course.edit', $this->course));
        $response->assertOk();
    }

    /** @test */
    public function can_render_the_edit_view_with_course_informations()
    {
        $response = $this->get(route('course.edit', $this->course));

        $response
            ->assertOk()
            ->assertSee($this->course->date_debut->format('Y-m-d'))
            ->assertSee($this->course->date_debut->format('H:i'))
            ->assertSee($this->course->date_fin->format('H:i'))
            ->assertSee($this->course->paye)
            ->assertSeeText($this->course->notions_apprises);
    }

    /** @test */
    public function can_update_a_course()
    {
        $this->patch(route('course.update', $this->course), [
            'paye' => true,
            "heure_debut" => "18:00",
            "heure_fin" => "19:00",
            'date_debut' => "2023-07-01 18:00:00",
            'date_fin' => "2023-07-01 19:00:00",
            'notions_apprises' => "texte",
        ]);

        $this->course->refresh();

        $this->assertEquals($this->course->notions_apprises, "texte");
        $this->assertEquals(1, $this->course->paye);
        $this->assertEquals(1, $this->course->nombre_heures);
    }

    /** @test */
    public function can_delete_a_course()
    {
        $this
            ->delete(route('course.destroy', $this->course))
            ->assertRedirect(route('course.index'));

        $this->assertDatabaseCount('courses', 0);
    }
}
