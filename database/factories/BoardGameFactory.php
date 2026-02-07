<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoardGame>
 */
class BoardGameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'slug' => Str::slug($name),
            'name' => $name,
            'year' => fake()->optional()->numberBetween(1950, now()->year),
            'country_id' => Country::factory(),
            'essential' => fake()->boolean(30), // 30% de probabilidad de ser true
        ];
    }
}
