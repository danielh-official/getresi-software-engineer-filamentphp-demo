<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::whereEmail('test@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ])->assignRole('super_admin');
        }

        if (User::whereEmail('property@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'Property Admin',
                'email' => 'property@example.com',
            ])->assignRole('property_admin');
        }

        if (User::whereEmail('user@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'User Admin',
                'email' => 'user@example.com',
            ])->assignRole('user_admin');
        }

        Property::factory(50)->create();
    }
}
