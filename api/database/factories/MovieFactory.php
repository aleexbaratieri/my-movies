<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "movie_id" => fake()->numberBetween(1000, 50000),
            "original_title" => fake()->company(),
            "title" => fake()->companySuffix(),
            "poster_path" => fake()->uuid() . 'jpg',
        ];
    }
}
