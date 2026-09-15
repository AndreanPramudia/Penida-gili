<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<HotelRoom> */
class HotelRoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::factory(),
            'name' => fake()->randomElement(['Deluxe Ocean Room', 'Private Pool Villa', 'Garden Suite']),
            'description' => fake()->sentence(14),
            'guests' => 2,
            'bed' => '1 King Bed',
            'size_label' => '45 m² Ocean Terrace',
            'price_per_night' => fake()->randomElement([1_500_000, 2_500_000, 5_800_000]),
            'stock' => fake()->numberBetween(1, 10),
            'image' => 'room-deluxe.png',
        ];
    }
}
