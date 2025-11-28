<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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

        Role::findOrCreate('user_admin')->givePermissionTo(
            Permission::findOrCreate('access admin panel'),
            Permission::findOrCreate('view users'),
            Permission::findOrCreate('view a user'),
            Permission::findOrCreate('create users'),
            Permission::findOrCreate('update users'),
            Permission::findOrCreate('delete users'),
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::whereIn('name', ['super_admin', 'property_admin', 'user_admin'])->delete();
        Permission::whereIn('name', [
            'access admin panel',
            'view users',
            'view a user',
            'create users',
            'update users',
            'delete users',
            'view properties',
            'view a property',
            'create properties',
            'update properties',
            'delete properties',
            'restore properties',
            'force delete properties',
        ])->delete();
    }
};
