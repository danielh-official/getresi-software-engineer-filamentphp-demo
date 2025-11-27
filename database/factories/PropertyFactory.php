<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'name' => $this->faker->words(3, true),
            'type' => $this->faker->randomElement([
                'house',
                'apartment',
                'condo',
                'townhouse',
                'land',
            ]),
            'status' => $this->faker->randomElement(['For Sale', 'For Rent', 'Sold']),
            'description' => $this->faker->paragraph(),
            'year_built' => $this->faker->year(),
            'website' => $this->faker->url(),
            'price' => $this->faker->numberBetween(100000, 1000000),
            'full_address' => $this->faker->address(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'zip_code' => $this->faker->postcode(),
            'stories' => $this->faker->numberBetween(1, 3),
            'has_basement' => $this->faker->boolean(),
            'basement_finished' => $this->faker->boolean(),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'square_feet' => $this->faker->numberBetween(500, 5000),
            'parking' => $this->faker->boolean(),
            'pets_allowed' => $this->faker->boolean(),
            'other' => null,
        ];
    }
}
