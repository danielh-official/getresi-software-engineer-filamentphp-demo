<?php

use App\Enum\PropertyTypeEnum;
use App\Filament\Resources\Properties\Pages\CreateProperty;
use App\Filament\Resources\Properties\Pages\EditProperty;
use App\Filament\Resources\Properties\Pages\ListProperties;
use App\Filament\Resources\Properties\PropertyResource;
use App\Models\Property;
use App\Models\User;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\Testing\TestAction;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

describe('authorization', function () {
    test('only an admin with "view properties" permission can access the property resource', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel');

        actingAs($user)
            ->get(PropertyResource::getUrl('index'))
            ->assertForbidden();

        $user->givePermissionTo('view properties');

        actingAs($user)
            ->get(PropertyResource::getUrl('index'))
            ->assertOk();
    });

    test('only an admin with "view a property" permission can view a property record', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel');
        $property = Property::factory()->create();

        actingAs($user)
            ->get(PropertyResource::getUrl('view', ['record' => $property->id]))
            ->assertForbidden();

        $user->givePermissionTo('view properties', 'view a property');

        actingAs($user->refresh())
            ->get(PropertyResource::getUrl('view', ['record' => $property->id]))
            ->assertOk();
    });

    test('only an admin with "create properties" permission can access the create property page', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view properties');

        actingAs($user)
            ->get(PropertyResource::getUrl('create'))
            ->assertForbidden();

        $user->givePermissionTo('create properties');

        actingAs($user)
            ->get(PropertyResource::getUrl('create'))
            ->assertOk();
    });

    test('only an admin with "create properties" permission can create a property', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view properties');

        actingAs($user);

        livewire(CreateProperty::class)
            ->assertForbidden();

        $user->givePermissionTo('create properties');

        livewire(CreateProperty::class)
            ->fillForm([
                'name' => 'Test Property',
                'owner_id' => User::factory()->create()->id,
                'type' => PropertyTypeEnum::Apartment->value,
                'address' => '123 Main St',
                'city' => 'Test City',
                'state' => 'CA',
                'zip' => '12345',
            ])
            ->call('create')
            ->assertHasNoErrors();

        expect(Property::query()->where('name', 'Test Property')->first())->not()->toBeNull();
    });

    test('only an admin with "update properties" permission can access the edit property page', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view properties');
        $property = Property::factory()->create();

        actingAs($user)
            ->get(PropertyResource::getUrl('edit', ['record' => $property->id]))
            ->assertForbidden();

        $user->givePermissionTo('update properties');

        actingAs($user)
            ->get(PropertyResource::getUrl('edit', ['record' => $property->id]))
            ->assertOk();
    });

    test('only an admin with "update properties" permission can update a property', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view properties');

        $property = Property::factory()->create([
            'name' => 'Original Property',
        ]);

        actingAs($user);

        livewire(EditProperty::class, [
            'record' => $property->id,
        ])->assertForbidden();

        $user->givePermissionTo('update properties');

        livewire(EditProperty::class, [
            'record' => $property->id,
        ])->fillForm([
            'name' => 'Updated Property',
            'address' => '456 New St',
            'city' => 'New City',
            'state' => 'NY',
            'zip' => '67890',
        ])
            ->call('save')
            ->assertHasNoErrors();

        $property->refresh();

        expect($property->name)->toBe('Updated Property')
            ->and($property->address)->toBe('456 New St');
    });

    test('only an admin with "delete properties" permission can delete a property', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view properties');
        $properties = Property::factory(5)->create();

        actingAs($user);

        livewire(ListProperties::class)
            ->assertCanSeeTableRecords($properties)
            ->selectTableRecords($properties)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanSeeTableRecords($properties);

        $user->givePermissionTo('delete properties');

        actingAs($user);

        livewire(ListProperties::class)
            ->assertCanSeeTableRecords($properties)
            ->selectTableRecords($properties)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertOk()
            ->assertCanNotSeeTableRecords($properties);
    });

    test('only an admin with "restore properties" permission can restore a deleted property', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view properties');
        $properties = Property::factory(3)->create();
        $properties->each->delete();

        actingAs($user);

        livewire(ListProperties::class)
            ->assertCanNotSeeTableRecords($properties)
            ->filterTable('trashed', false)
            ->assertCanSeeTableRecords($properties)
            ->selectTableRecords($properties)
            ->callAction(TestAction::make(RestoreBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanSeeTableRecords($properties);

        foreach ($properties as $property) {
            expect(Property::withTrashed()->find($property->id)->deleted_at)->not->toBeNull();
        }

        $user->givePermissionTo('restore properties');

        actingAs($user);

        livewire(ListProperties::class)
            ->assertCanNotSeeTableRecords($properties)
            ->filterTable('trashed', false)
            ->assertCanSeeTableRecords($properties)
            ->selectTableRecords($properties)
            ->callAction(TestAction::make(RestoreBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanNotSeeTableRecords($properties)
            ->filterTable('trashed')
            ->assertCanSeeTableRecords($properties);

        foreach ($properties as $property) {
            expect(Property::withTrashed()->find($property->id)->deleted_at)->toBeNull();
        }
    });

    test('only an admin with "force delete properties" permission can permanently delete a property', function () {
        $user = User::factory()->create()->givePermissionTo('access admin panel', 'view properties');
        $properties = Property::factory(3)->create();
        $properties->each->delete();

        actingAs($user);

        livewire(ListProperties::class)
            ->assertCanNotSeeTableRecords($properties)
            ->filterTable('trashed', false)
            ->assertCanSeeTableRecords($properties)
            ->selectTableRecords($properties)
            ->callAction(TestAction::make(ForceDeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanSeeTableRecords($properties);

        expect(Property::withTrashed()->whereIn('id', $properties->pluck('id'))->count())->toBe(3);

        $user->givePermissionTo('force delete properties');

        actingAs($user);

        livewire(ListProperties::class)
            ->assertCanNotSeeTableRecords($properties)
            ->filterTable('trashed', false)
            ->assertCanSeeTableRecords($properties)
            ->selectTableRecords($properties)
            ->callAction(TestAction::make(ForceDeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanNotSeeTableRecords($properties);

        expect(Property::withTrashed()->whereIn('id', $properties->pluck('id'))->count())->toBe(0);
    });
});
