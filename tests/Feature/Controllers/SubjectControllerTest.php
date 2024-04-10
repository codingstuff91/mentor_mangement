<?php

use App\Models\Subject;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

beforeEach(function () {
    loginAsUser();

    $this->subject = Subject::factory()->create();
});

test('can render the subjects index view', function () {
    $response = get(route('subject.index'));

    expect($response->status())->toBe(200);
});

test('can display all subjects on index view', function () {
    $response = get(route('subject.index'));
    $response->assertSee($this->subject->name);
});

test('can render the subject create view', function () {
    $response = get(route('subject.create'));

    $response->assertOk();
    $response->assertSee('Nom de la matière');
});

test('can store a new subject', function () {
    post(route('subject.store'), [
        'name' => 'php',
    ]);

    $this->assertDatabaseCount('subjects', 2);
});

test('cannot store a new subject without a name', function () {
    $response = post(route('subject.store'), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('can render the edit view with subject informations', function () {
    $response = get(route('subject.edit', $this->subject));

    $response->assertOk();
    $response->assertSee($this->subject->nom);
});

test('can update a subject', function () {
    patch(route('subject.update', $this->subject),[
        'name' => 'excel'
    ]);

    $this->subject->refresh();

    $this->assertEquals('excel', $this->subject->name);
});

test('can delete a subject', function () {
    delete(route('subject.destroy', $this->subject))
        ->assertRedirect(route('subject.index'));

    $this->assertDatabaseCount('courses', 0);
});
