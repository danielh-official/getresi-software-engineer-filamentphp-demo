<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (config('app.env') === 'production' || config('app.env') === 'development') {
            throw new \Exception('UserSeeder should not be run in production environment.');
        }

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
    }
}
