<?php

namespace Database\Factories;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Article> */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(8),
            'category' => fake()->randomElement(['Travel Guides', 'Boat Tips', 'Activities', 'Culture']),
            'excerpt' => fake()->sentence(16),
            'body' => fake()->paragraphs(4, true),
            'image' => 'snorkeling.png',
            'author_name' => fake()->name(),
            'author_role' => 'Travel Writer',
            'read_time_minutes' => fake()->numberBetween(3, 8),
            'views' => fake()->numberBetween(0, 50_000),
            'tags' => ['#NusaPenida'],
            'status' => ArticleStatus::Published,
            'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => ArticleStatus::Draft, 'published_at' => null]);
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
