<?php

namespace Database\Factories;

use App\Enums\ListingStatus;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Hotel> */
class HotelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company().' Resort',
            'category' => 'Resort',
            'stars' => 5,
            'rating' => fake()->randomFloat(1, 4.0, 5.0),
            'review_count' => fake()->numberBetween(20, 250),
            'description' => fake()->paragraph(),
            'address' => 'Nusa Penida, Bali, Indonesia',
            'full_address' => fake()->address(),
            'image' => 'nusa-penida-resort.png',
            'gallery' => [],
            'amenities' => [['icon' => 'wifi.svg', 'label' => 'Free Wi-Fi', 'shortLabel' => 'Free Wi-Fi']],
            'status' => ListingStatus::Active,
        ];
    }
}
