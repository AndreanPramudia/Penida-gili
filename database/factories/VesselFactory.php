<?php

namespace Database\Factories;

use App\Enums\ListingStatus;
use App\Models\BoatOperator;
use App\Models\Vessel;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Vessel> */
class VesselFactory extends Factory
{
    public function definition(): array
    {
        return [
            'boat_operator_id' => BoatOperator::factory(),
            'name' => fake()->unique()->firstName().' Express',
            'code' => 'SFB-'.fake()->unique()->numerify('###'),
            'type' => fake()->randomElement(['Catamaran Fast Ferry', 'Mono-hull Fastboat', 'Luxury Catamaran']),
            'capacity' => fake()->numberBetween(60, 150),
            'top_speed_knots' => fake()->numberBetween(24, 35),
            'engine' => '4 x 250HP Yamaha Outboards',
            'facilities' => ['Air Conditioning', 'Toilet', 'Life Jackets', 'Insurance'],
            'status' => ListingStatus::Active,
            'inspected_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
