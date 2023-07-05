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

        $this->course = course::factory()->create([
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

    /** @test */
    public function canRenderOnlyTheActiveInvoicesInSelectInvoiceList()
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
