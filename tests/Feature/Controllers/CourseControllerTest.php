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
            'student' => $this->student->id,
            'invoice' => Invoice::first()->id,
            "start_hour" => "18:00",
            "end_hour" => "19:00",
            'date' => "2023-07-01",
            'learned_notions' => "description des notions",
            'hourly_rate' => 50,
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
        $response->assertSee($unpaidInvoice->month_year_creation . " -- " . $unpaidInvoice->customer->name );
    }

    /** @test */
    public function fills_the_create_student_page_with_current_date()
    {
        $currentDate = now()->format('Y-m-d');

        $response = $this->get(route('course.create'));

        $response->assertOk();
        $response->assertSee($currentDate);
    }

    /** @test */
    public function can_store_a_new_course()
    {
        $this->post(route('course.store'), $this->courseAttributes);

        $this->assertDatabaseCount('courses', 2);
    }

    /** @test */
    public function cannot_store_a_new_course_without_choosing_an_student()
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
            'start_hour' => '',
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('start_hour');
    }

    /** @test */
    public function cannot_store_a_new_course_without_choising_a_start_hour_and_end_hour()
    {
        $attributes = array_merge($this->courseAttributes, [
            'start_hour' => '',
            'end_hour' => ''
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('start_hour');
        $response->assertSessionHasErrors('end_hour');
    }

    /** @test */
    public function cannot_store_a_new_course_without_writing_the_course_covered_concepts()
    {
        $attributes = array_merge($this->courseAttributes, [
            'learned_notions' => '',
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('learned_notions');
    }

    /** @test */
    public function cannot_store_a_new_course_without_giving_an_hourly_rate_price()
    {
        $attributes = array_merge($this->courseAttributes, [
            'hourly_rate' => '',
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('hourly_rate');
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
            ->assertSee($this->course->date->format('Y-m-d'))
            ->assertSee($this->course->start_hour->format('H:i'))
            ->assertSee($this->course->end_hour->format('H:i'))
            ->assertSee($this->course->paid)
            ->assertSeeText($this->course->learned_notions);
    }

    /** @test */
    public function can_update_a_course()
    {
        $this->patch(route('course.update', $this->course), [
            'paid' => true,
            'date' => "2023-07-01",
            "start_hour" => "18:00",
            "end_hour" => "19:00",
            'learned_notions' => "texte",
        ]);

        $this->course->refresh();

        $this->assertEquals($this->course->learned_notions, "texte");
        $this->assertEquals(1, $this->course->paid);
        $this->assertEquals(1, $this->course->hours_count);
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
