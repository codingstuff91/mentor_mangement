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

        $this->student = Student::factory()->create([
            'matiere_id' => $this->matiere->id,
            'customer_id' => Facture::first()->id,
        ]);

        $this->course = course::factory()->create([
            'student_id' => 1,
            'facture_id' => 1
        ]);

        $this->courseAttributes = [
            'student_id' => $this->student->id,
            'facture_id' => Facture::first()->id,
            "heure_debut" => "18:00",
            "heure_fin" => "19:00",
            'date_debut' => "2023-07-01 18:00:00",
            'date_fin' => "2023-07-01 19:00:00",
            'notions' => "description des notions",
            'taux_horaire' => 50,
        ];
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

    /** @test */
    public function can_store_a_new_course()
    {
        $this->post(route('course.store'), [
            'student_id' => $this->student->id,
            'facture_id' => Facture::first()->id,
            "heure_debut" => "18:00",
            "heure_fin" => "19:00",
            'date_debut' => "2023-07-01 18:00:00",
            'date_fin' => "2023-07-01 19:00:00",
            'notions_apprises' => "description des notions",
            'taux_horaire' => 50,
        ])->assertRedirect(route('course.index'));

        $this->assertDatabaseCount('courses', 2);
    }

    /** @test */
    public function cannot_store_a_new_course_without_choising_an_student()
    {
        $attributes = array_merge($this->courseAttributes, [
            'student_id' => '',
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('student_id');
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
            'facture_id' => '',
        ]);

        $response = $this->post(route('course.store'), $attributes);
        $response->assertSessionHasErrors('facture_id');
    }

    /** @test */
    public function can_render_only_the_active_invoices_in_select_invoice_list()
    {
        $response = $this->get(route('course.create'));
        $response->assertOk();

        $facturePayee = Facture::where('payee', true)->first();

        $response->assertSee([
                Facture::first()->month_year_creation,
                Facture::first()->customer->nom
        ]);
        $response->assertDontSee('value=' . $facturePayee->id);
    }

    /** @test */
    public function canRenderTheEditCourseView()
    {
        $response = $this->get(route('course.edit', $this->course));
        $response->assertOk();
    }

    /** @test */
    public function canRenderTheEditViewWithCourseInformations()
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
    public function canUpdateACourse()
    {
        $this->patch(route('course.update', $this->course), [
            'paye' => true,
            'nombre_heures' => 1,
            "heure_debut" => "18:00",
            "heure_fin" => "19:00",
            'date_debut' => "2023-07-01 18:00:00",
            'date_fin' => "2023-07-01 19:00:00",
            'notions' => "texte",
        ]);

        $this->course->refresh();

        $this->assertEquals($this->course->notions_apprises, "texte");
        $this->assertEquals(1, $this->course->paye);
        $this->assertEquals(1, $this->course->nombre_heures);
    }

    /** @test */
    public function canDeleteACourse()
    {
        $this
            ->delete(route('course.destroy', $this->course))
            ->assertRedirect(route('course.index'));

        $this->assertDatabaseCount('courses', 0);
    }
}
