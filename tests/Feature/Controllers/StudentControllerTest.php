<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Matiere;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $user = User::first();

        $this->actingAs($user);

        $this->matiere = Matiere::factory()->create();

        $this->customer = Client::factory()->create()->each(function($client){
            Facture::factory()->create([
                'client_id' => $client->id,
            ]);
        });

        $this->student = Student::factory()->create([
            'matiere_id' => $this->matiere->id,
            'client_id' => Client::first()->id,
        ]);
    }

    /** @test */
    public function canFetchTheStudentsList()
    {
        $response = $this->get(route('student.index'));
        $response->assertOk();
    }

    /** @test */
    public function canRenderStudentCreatePage()
    {
        $response = $this->get(route('student.create'));
        $response->assertOk();

        $view = $this->view('student.create', [
            'clients' => Matiere::all(),
            'matieres' => Client::all(),
        ]);

        $view->assertSee('Nom');
        $view->assertSee('Matière');
        $view->assertSee('Client');
        $view->assertSee('Objectifs');
        $view->assertSee('Commentaires');
    }

    /** @test */
    public function canStoreANewStudent()
    {
        $response = $this->post(route('student.store', [
            'nom' => "John Doe",
            'matiere_id' => Matiere::first()->id,
            'client_id' => Client::first()->id,
            'objectifs' => "Some random text to test",
            'commentaires' => "Some random text to test",
        ]));

        $this->assertDatabaseCount('students', 1);
    }

    /** @test */
    public function canRenderTheShowStudentPage()
    {

        $response = $this->get(route('student.show', $this->student));
        $response->assertOk();

        $view = $this->view('student.show', ['student' => $this->student]);

        $view->assertSee($this->student->name);
        $view->assertSee($this->student->objectifs);
        $view->assertSee($this->student->matiere->name);
    }

    /** @test */
    public function canRenderTheEditStudentPage()
    {
        $response = $this->get(route('student.edit', $this->student));
        $response->assertOk();
    }

    /** @test */
    public function canUpdateAStudent()
    {
        $response = $this->patch(route('student.update', $this->student), [
            "nom" => "test",
            "active" => 1,
            "client_id" => $this->customer,
            "matiere_id" => $this->matiere->id,
        ]);

        $this->assertEquals(Student::first()->nom, "test");
    }
}
