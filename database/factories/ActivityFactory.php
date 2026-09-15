<?php

namespace Database\Factories;

use App\Enums\ListingStatus;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Activity> */
class ActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(4, true),
            'category' => fake()->randomElement(['Photography', 'Cultural Show', 'Water Sports']),
            'location' => 'Penglipuran, Bangli',
            'place_label' => 'Penglipuran',
            'opens_at' => '08:00',
            'closes_at' => '18:00',
            'duration_label' => '1-2 Hours',
            'description' => fake()->paragraph(),
            'intro' => fake()->paragraph(),
            'summary' => fake()->paragraphs(2, true),
            'image' => 'costume-penglipuran.png',
            'gallery' => [],
            'highlights' => [],
            'experiences' => [],
            'included' => [],
            'excluded' => [],
            'days' => null,
            'price_adult' => 75_000,
            'price_child' => 50_000,
            'rating' => fake()->randomFloat(1, 4.0, 5.0),
            'review_count' => fake()->numberBetween(10, 400),
            'status' => ListingStatus::Active,
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => ListingStatus::Draft]);
    }
}
