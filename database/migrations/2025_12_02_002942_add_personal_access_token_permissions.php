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
            Permission::findOrCreate('view roles'),
            Permission::findOrCreate('view a role'),
            Permission::findOrCreate('create roles'),
            Permission::findOrCreate('update roles'),
            Permission::findOrCreate('delete roles'),
            Permission::findOrCreate('view properties'),
            Permission::findOrCreate('view a property'),
            Permission::findOrCreate('create properties'),
            Permission::findOrCreate('update properties'),
            Permission::findOrCreate('delete properties'),
            Permission::findOrCreate('restore properties'),
            Permission::findOrCreate('force delete properties'),
            Permission::findOrCreate('view personal access tokens'),
            Permission::findOrCreate('view a personal access token'),
            Permission::findOrCreate('create personal access tokens'),
            Permission::findOrCreate('update personal access tokens'),
            Permission::findOrCreate('delete personal access tokens'),
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::whereIn('name', [
            'view personal access tokens',
            'view a personal access token',
            'create personal access tokens',
            'update personal access tokens',
            'delete personal access tokens',
        ])->delete();
    }
};
