<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isbn13 = preg_replace('/\D/', '', fake()->isbn13()) ?? '9784000000000';

        return [
            'title' => fake()->realText(20),
            'author' => fake()->name(),
            'isbn' => substr($isbn13, 0, 13),
            'price' => fake()->numberBetween(500, 10000),
            'published_at' => fake()->dateTimeBetween('-8 years', 'now')->format('Y-m-d'),
            'description' => fake()->optional(0.75)->paragraphs(2, true),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
        ];
    }
}
