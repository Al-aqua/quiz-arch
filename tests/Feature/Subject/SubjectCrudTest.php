<?php

use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('subjects index page is displayed', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->get(route('subjects.index'));

    $response->assertOk();
});

test('user can view their own subject', function () {
    $user = User::factory()->create();
    $subject = Subject::factory()->for($user)->create();

    $response = actingAs($user)->get(route('subjects.show', $subject->slug));

    $response->assertOk();
    $response->assertSee($subject->name);
});

test('user cannot view another users subject', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $subject = Subject::factory()->for($otherUser)->create();

    $response = actingAs($user)->get(route('subjects.show', $subject->slug));

    $response->assertForbidden();
});

test('user can create a subject', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->post(route('subjects.store'), [
        'name' => 'Test Subject',
        'description' => 'Test description',
    ]);

    $response->assertRedirect();
    expect(Subject::where('name', 'Test Subject')->exists())->toBeTrue();
});

test('subject name is required', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->post(route('subjects.store'), [
        'name' => '',
        'description' => 'Test description',
    ]);

    $response->assertSessionHasErrors('name');
});

test('subject name cannot exceed 100 characters', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->post(route('subjects.store'), [
        'name' => str_repeat('a', 101),
        'description' => 'Test description',
    ]);

    $response->assertSessionHasErrors('name');
});

test('subject description cannot exceed 1000 characters', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->post(route('subjects.store'), [
        'name' => 'Test Subject',
        'description' => str_repeat('a', 1001),
    ]);

    $response->assertSessionHasErrors('description');
});

test('user can update their own subject', function () {
    $user = User::factory()->create();
    $subject = Subject::factory()->for($user)->create();

    $response = actingAs($user)->patch(route('subjects.update', $subject), [
        'name' => 'Updated Subject',
        'description' => 'Updated description',
    ]);

    $response->assertRedirect(route('subjects.show', $subject->fresh()->slug));

    $subject->refresh();
    expect($subject->name)->toBe('Updated Subject');
    expect($subject->description)->toBe('Updated description');
});

test('user cannot update another users subject', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $subject = Subject::factory()->for($otherUser)->create();

    $response = actingAs($user)->patch(route('subjects.update', $subject), [
        'name' => 'Updated Subject',
        'description' => 'Updated description',
    ]);

    $response->assertForbidden();
});

test('user can delete their own subject', function () {
    $user = User::factory()->create();
    $subject = Subject::factory()->for($user)->create();

    $response = actingAs($user)->delete(route('subjects.destroy', $subject));

    $response->assertRedirect(route('subjects.index'));
    expect(Subject::find($subject->id))->toBeNull();
});

test('user cannot delete another users subject', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $subject = Subject::factory()->for($otherUser)->create();

    $response = actingAs($user)->delete(route('subjects.destroy', $subject));

    $response->assertForbidden();
    expect(Subject::find($subject->id))->not->toBeNull();
});

test('index only shows subjects for current user', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $mySubject = Subject::factory()->for($user)->create(['name' => 'My Subject']);
    Subject::factory()->for($otherUser)->create(['name' => 'Other Subject']);

    $response = actingAs($user)->get(route('subjects.index'));

    $response->assertOk();
    $response->assertSee('My Subject');
    $response->assertDontSee('Other Subject');
});
