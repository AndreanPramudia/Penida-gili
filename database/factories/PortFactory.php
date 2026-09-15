<?php

namespace Database\Factories;

use App\Models\Port;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Port> */
class PortFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->city().' Port',
            'area' => fake()->randomElement(['Bali', 'Nusa Penida', 'Lombok', 'Gili']),
        ];
    }
}
