<?php

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('admin panel requires authentication', function () {
    get('/admin')
        ->assertRedirect('/admin/login');
});

test('authenticated user with "access admin panel" permission can access admin panel', function () {
    $user = \App\Models\User::factory()->create()
        ->givePermissionTo('access admin panel');

    actingAs($user)->get('/admin')
        ->assertOk();
});

test('authenticated user without "access admin panel" permission cannot access admin panel', function () {
    $user = \App\Models\User::factory()->create();

    actingAs($user)->get('/admin')
        ->assertForbidden();
});
