<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

/**
 * A handful of sample reservations so the console dashboard has something to show.
 */
class BookingSeeder extends Seeder
{
    public function run(): void
    {
        if (Booking::query()->exists()) {
            return;
        }

        $schedules = Schedule::query()->with('operator')->get();

        $samples = [
            ['Alex Robertson', 'alex.r@example.com', 'Australia', '+61', 2, 0, BookingStatus::Confirmed, PaymentStatus::Paid],
            ['Sarah Mitchell', 's.mitchell@example.com', 'United Kingdom', '+44', 1, 1, BookingStatus::Pending, PaymentStatus::Unpaid],
            ['James Lee', 'jamesl88@example.com', 'Singapore', '+65', 2, 2, BookingStatus::Confirmed, PaymentStatus::Paid],
            ['Putu Ayu', 'putu.ayu@example.com', 'Indonesia', '+62', 3, 0, BookingStatus::Confirmed, PaymentStatus::Paid],
            ['Maria Gonzalez', 'maria.g@example.com', 'United States', '+1', 2, 1, BookingStatus::Pending, PaymentStatus::Unpaid],
        ];

        foreach ($samples as $i => [$name, $email, $nationality, $dial, $adults, $children, $status, $payment]) {
            $schedule = $schedules[$i % $schedules->count()];

            Booking::query()->create([
                'bookable_type' => $schedule->getMorphClass(),
                'bookable_id' => $schedule->id,
                'customer_name' => $name,
                'customer_email' => $email,
                'dial_code' => $dial,
                'phone' => '812'.str_pad((string) ($i * 12345678 % 100000000), 8, '0', STR_PAD_LEFT),
                'nationality' => $nationality,
                'travel_date' => now()->addDays($i + 1)->toDateString(),
                'adults' => $adults,
                'children' => $children,
                'nights' => 1,
                'unit_price_adult' => $schedule->price_adult,
                'unit_price_child' => $schedule->price_child,
                'total' => $adults * $schedule->price_adult + $children * $schedule->price_child,
                'status' => $status,
                'payment_status' => $payment,
                'confirmed_at' => $status === BookingStatus::Confirmed ? now()->subDays($i) : null,
                'created_at' => now()->subDays($i),
            ]);
        }
    }
}
