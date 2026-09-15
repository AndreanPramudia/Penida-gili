<?php

namespace Database\Factories;

use App\Models\BoatOperator;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Review> */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reviewable_type' => (new BoatOperator)->getMorphClass(),
            'reviewable_id' => BoatOperator::factory(),
            'name' => fake()->name(),
            'stars' => fake()->numberBetween(4, 5),
            'quote' => '"'.fake()->sentence(14).'"',
            'experienced_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'is_published' => true,
        ];
    }
}
