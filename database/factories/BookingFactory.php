<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Booking> */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        $adults = fake()->numberBetween(1, 4);
        $children = fake()->numberBetween(0, 2);

        return [
            'bookable_type' => (new Schedule)->getMorphClass(),
            'bookable_id' => Schedule::factory(),
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'dial_code' => '+62',
            'phone' => fake()->numerify('812########'),
            'nationality' => 'Indonesia',
            'travel_date' => fake()->dateTimeBetween('now', '+2 months'),
            'adults' => $adults,
            'children' => $children,
            'nights' => 1,
            'unit_price_adult' => 180_000,
            'unit_price_child' => 135_000,
            'total' => $adults * 180_000 + $children * 135_000,
            'status' => fake()->randomElement([BookingStatus::Pending, BookingStatus::Confirmed]),
            'payment_status' => PaymentStatus::Unpaid,
        ];
    }

    public function confirmed(): static
    {
        return $this->state(['status' => BookingStatus::Confirmed, 'payment_status' => PaymentStatus::Paid, 'confirmed_at' => now()]);
    }
}
