<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::findOrCreate('super_admin')->givePermissionTo(
            Permission::findOrCreate('access admin panel'),
            Permission::findOrCreate('view users'),
            Permission::findOrCreate('view a user'),
            Permission::findOrCreate('create users'),
            Permission::findOrCreate('update users'),
            Permission::findOrCreate('delete users'),
            Permission::findOrCreate('view properties'),
            Permission::findOrCreate('view a property'),
            Permission::findOrCreate('create properties'),
            Permission::findOrCreate('update properties'),
            Permission::findOrCreate('delete properties'),
            Permission::findOrCreate('restore properties'),
            Permission::findOrCreate('force delete properties'),
        );

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ])->assignRole('super_admin');

        Role::findOrCreate('property_admin')->givePermissionTo(
            Permission::findOrCreate('access admin panel'),
            Permission::findOrCreate('view properties'),
            Permission::findOrCreate('view a property'),
            Permission::findOrCreate('create properties'),
            Permission::findOrCreate('update properties'),
            Permission::findOrCreate('delete properties'),
            Permission::findOrCreate('restore properties'),
            Permission::findOrCreate('force delete properties'),
        );

        User::factory()->create([
            'name' => 'Property Admin',
            'email' => 'property@example.com',
        ])->assignRole('property_admin');

        Role::findOrCreate('user_admin')->givePermissionTo(
            Permission::findOrCreate('access admin panel'),
            Permission::findOrCreate('view users'),
            Permission::findOrCreate('view a user'),
            Permission::findOrCreate('create users'),
            Permission::findOrCreate('update users'),
            Permission::findOrCreate('delete users'),
        );

        User::factory()->create([
            'name' => 'User Admin',
            'email' => 'user@example.com',
        ])->assignRole('user_admin');

        Property::factory(50)->create();
    }
}
