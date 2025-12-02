<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertCount;

it('can list properties', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    User::factory()->hasProperties(30)->create();

    $response = getJson(route('api.properties.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'current_page',
            'data',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);

    expect($response->json('total'))->toBe(30);
});

it('can control the list of properties via per_page query parameter', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    User::factory()->hasProperties(50)->create();

    $response = getJson(route('api.properties.index', ['per_page' => 20]));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'current_page',
            'data',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);

    expect($response->json('per_page'))->toBe(20);
    expect($response->json('total'))->toBe(50);
});

it('can control the list of properties via page query parameter', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    User::factory()->hasProperties(50)->create();

    $response = getJson(route('api.properties.index', ['per_page' => 15, 'page' => 2]));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'current_page',
            'data',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);

    expect($response->json('current_page'))->toBe(2);
    expect($response->json('per_page'))->toBe(15);
    expect($response->json('total'))->toBe(50);
});

it('can store a property', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = postJson(route('api.properties.store'), [
        'name' => 'Test Property',
        'owner_email' => $user->email,
        'type' => 'apartment',
    ]);

    $response->assertStatus(201)
        ->assertJsonFragment([
            'name' => 'Test Property',
            'owner_id' => $user->id,
            'type' => 'apartment',
        ]);

    assertDatabaseHas('properties', [
        'name' => 'Test Property',
        'owner_id' => $user->id,
        'type' => 'apartment',
    ]);

    assertDatabaseCount('properties', 1);
});

it('fails to store a property if user email does not exist', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = postJson(route('api.properties.store'), [
        'name' => 'Invalid Property',
        'owner_email' => 'nonexistent@example.com',
        'type' => 'apartment',
    ]);

    $response->assertStatus(422);
});

it('can view a property', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $property = $user->properties()->create([
        'name' => 'Viewable Property',
        'type' => 'house',
    ]);

    $response = getJson(route('api.properties.show', $property));

    $response->assertStatus(200)
        ->assertJsonFragment([
            'name' => 'Viewable Property',
            'owner_id' => $user->id,
            'type' => 'house',
        ]);
});

it('can delete a property', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $property = $user->properties()->create([
        'name' => 'Deletable Property',
        'type' => 'condo',
    ]);

    $response = deleteJson(route('api.properties.destroy', $property));

    $response->assertStatus(204);

    assertDatabaseCount('properties', 1);

    assertCount(0, $user->properties);
});
