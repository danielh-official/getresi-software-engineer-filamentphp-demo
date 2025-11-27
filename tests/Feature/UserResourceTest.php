<?php

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

describe('authorization', function () {
    test('only an admin with "view users" permission can access the users list', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel');

        actingAs($user)
            ->get(UserResource::getUrl('index'))
            ->assertForbidden();

        $user->givePermissionTo('view users');

        actingAs($user)
            ->get(UserResource::getUrl('index'))
            ->assertOk();
    });

    test('only an admin with "view a user" permission can view a user record', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel');
        $otherUser = User::factory()->create();

        actingAs($user)
            ->get(UserResource::getUrl('view', ['record' => $otherUser->id]))
            ->assertForbidden();

        $user->givePermissionTo('view users', 'view a user');

        actingAs($user->refresh())
            ->get(UserResource::getUrl('view', ['record' => $otherUser->id]))
            ->assertOk();
    });

    test('only an admin with "create users" permission can access the create user page', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view users');

        actingAs($user)
            ->get(UserResource::getUrl('create'))
            ->assertForbidden();

        $user->givePermissionTo('create users');

        actingAs($user)
            ->get(UserResource::getUrl('create'))
            ->assertOk();
    });

    test('only an admin with "create users" permission can create a user', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view users');

        actingAs($user);

        livewire(CreateUser::class)
            ->assertForbidden();

        $user->givePermissionTo('create users');

        livewire(CreateUser::class)
            ->fillForm([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
            ])
            ->call('create')
            ->assertHasNoErrors();

        expect(User::query()->where('email', 'test@example.com')->first())->not()->toBeNull();
    });

    test('only an admin with "update users" permission can access the edit user page', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view users');
        $otherUser = User::factory()->create();

        actingAs($user)
            ->get(UserResource::getUrl('edit', ['record' => $otherUser->id]))
            ->assertForbidden();

        $user->givePermissionTo('update users');

        actingAs($user)
            ->get(UserResource::getUrl('edit', ['record' => $otherUser->id]))
            ->assertOk();
    });

    test('only an admin with "update users" permission can update a user', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view users');

        $otherUser = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        actingAs($user);

        livewire(EditUser::class, [
            'record' => $otherUser->id,
        ])->assertForbidden();

        $user->givePermissionTo('update users');

        livewire(EditUser::class, [
            'record' => $otherUser->id,
        ])->fillForm([
            'name' => 'Different User',
            'email' => 'different@example.com',
            'password' => 'password',
        ])
            ->call('save')
            ->assertHasNoErrors();

        $otherUser->refresh();

        expect($otherUser->name)->toBe('Different User')
            ->and($otherUser->email)->toBe('different@example.com');
    });

    test('only an admin with "delete users" permission can delete a user', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view users');
        $otherUsers = User::factory(5)->create();

        actingAs($user);

        livewire(ListUsers::class)
            ->assertCanSeeTableRecords($otherUsers)
            ->selectTableRecords($otherUsers)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanSeeTableRecords($otherUsers);

        $user->givePermissionTo('delete users');

        actingAs($user);

        livewire(ListUsers::class)
            ->assertCanSeeTableRecords($otherUsers)
            ->selectTableRecords($otherUsers)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertOk()
            ->assertCanNotSeeTableRecords($otherUsers);
    });

    test('admin cannot delete themselves', function () {
        $user = User::factory()->create()
            ->givePermissionTo('access admin panel', 'view users', 'delete users');

        actingAs($user);

        livewire(ListUsers::class)
            ->assertCanSeeTableRecords([$user])
            ->selectTableRecords([$user])
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanSeeTableRecords([$user]);
    });
});
