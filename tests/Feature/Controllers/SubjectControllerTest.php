<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Subject;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $user = User::first();

        $this->actingAs($user);

        $this->subject = Subject::factory()->create();
    }

    /** @test */
    public function can_render_the_subjects_index_view()
    {
        $response = $this->get(route('subject.index'));
        $response->assertOk();
    }

    /** @test */
    public function can_display_all_subjects_on_index_view()
    {
        $response = $this->get(route('subject.index'));
        $response->assertSee($this->subject->name);
    }

    /** @test */
    public function can_render_the_subject_create_view()
    {
        $response = $this->get(route('subject.create'));

        $response->assertOk();
        $response->assertSee('Nom de la matière');
    }

    /** @test */
    public function can_store_a_new_subject()
    {
        $this->post(route('subject.store'), [
            'name' => 'php',
        ]);

        $this->assertDatabaseCount('subjects', 2);
    }

    /** @test */
    public function cannot_store_a_new_subject_without_a_name()
    {
        $response = $this->post(route('subject.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function can_render_the_edit_view_with_subject_informations()
    {
        $response = $this->get(route('subject.edit', $this->subject));

        $response->assertOk();
        $response->assertSee($this->subject->nom);
    }

    /** @test */
    public function can_update_a_subject()
    {
        $this->patch(route('subject.update', $this->subject),[
            'name' => 'excel'
        ]);

        $this->subject->refresh();

        $this->assertEquals('excel', $this->subject->name);
    }

    /** @test */
    public function can_delete_a_subject()
    {
        $this
            ->delete(route('subject.destroy', $this->subject))
            ->assertRedirect(route('subject.index'));

        $this->assertDatabaseCount('courses', 0);
    }
}
