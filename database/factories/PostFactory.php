<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->text(20);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'is_published' => fake()->boolean(),
        ];
    }

    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => true,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => false,
        ]);
    }
}
