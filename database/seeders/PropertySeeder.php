<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (config('app.env') === 'production') {
            throw new \Exception('PropertySeeder should not be run in production environment.');
        }

        Property::factory(50)->create();
    }
}
