<?php

use App\Models\Subject;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

beforeEach(function () {
    loginAsUser();

    $this->subject = Subject::factory()->create();
});

test('can render the subjects index view', function () {
    get(route('subject.index'))
        ->assertOk();
});

test('can display all subjects on index view', function () {
    get(route('subject.index'))
        ->assertSee($this->subject->name);
});

test('can render the subject create view', function () {
    get(route('subject.create'))
        ->assertOk()
        ->assertSee('Nom de la matière');
});

test('store a new subject', function () {
    post(route('subject.store'), [
        'name' => 'php',
    ]);

    assertDatabaseCount('subjects', 2);
});

test('cannot store a new subject without a name', function () {
    post(route('subject.store'), [
        'name' => '',
    ])->assertSessionHasErrors(['name']);
});

test('render the edit view with subject informations', function () {
    get(route('subject.edit', $this->subject))
        ->assertOk()
        ->assertSee($this->subject->nom);
});

test('update a subject', function () {
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
