<?php

namespace App\Support;

/**
 * Placeholder console data — swap for real queries once the DB is in place.
 */
class AdminDashboard
{
    /**
     * @return array<int, array<string, string>>
     */
    public static function kpis(): array
    {
        return [
            ['icon' => 'kpi-bookings.svg', 'label' => 'Total Bookings', 'value' => '1,248', 'badge' => '+12%', 'badgeTone' => 'up'],
            ['icon' => 'kpi-revenue.svg', 'label' => 'Total Revenue', 'value' => 'Rp 45.000.000', 'badge' => '+8.4%', 'badgeTone' => 'up'],
            ['icon' => 'kpi-boat.svg', 'label' => 'Active Boat', 'value' => '8/8', 'badge' => 'Operational', 'badgeTone' => 'neutral'],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function vessels(): array
    {
        return [
            [
                'name' => 'Sanjaya Ocean Queen',
                'status' => 'In Transit',
                'state' => 'transit',
                'progress' => 65,
                'eta' => 'ETA: 45 mins',
                'meta' => [
                    ['icon' => 'route.svg', 'label' => 'Bali - Gili T'],
                    ['icon' => 'speed.svg', 'label' => '24 knots'],
                ],
            ],
            [
                'name' => 'Sanjaya Express II',
                'status' => 'Docked',
                'state' => 'docked',
                'progress' => 100,
                'eta' => 'Departure: 10:30 AM',
                'meta' => [
                    ['icon' => 'anchor.svg', 'label' => 'Sanur Port'],
                    ['icon' => 'boarding.svg', 'label' => 'Boarding'],
                ],
            ],
            [
                'name' => 'Nusa Penida Voyager',
                'status' => 'In Transit',
                'state' => 'transit',
                'progress' => 30,
                'eta' => 'ETA: 20 mins',
                'meta' => [
                    ['icon' => 'route.svg', 'label' => 'Sanur - Penida'],
                    ['icon' => 'speed.svg', 'label' => '28 knots'],
                ],
            ],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    public static function transactions(): array
    {
        return [
            [
                'initials' => 'AR',
                'name' => 'Alex Robertson',
                'email' => 'alex.r@example.com',
                'from' => 'Bali',
                'to' => 'Gili Trawangan',
                'vessel' => 'Sanjaya Ocean Queen',
                'date' => 'Oct 24, 2023',
                'time' => '14:30 PM',
                'amount' => 'Rp. 100.000',
                'status' => 'Confirmed',
            ],
            [
                'initials' => 'SM',
                'name' => 'Sarah Mitchell',
                'email' => 's.mitchell@example.com',
                'from' => 'Sanur',
                'to' => 'Nusa Penida',
                'vessel' => 'Sanjaya Express II',
                'date' => 'Oct 25, 2023',
                'time' => '09:00 AM',
                'amount' => 'Rp. 100.000',
                'status' => 'Pending',
            ],
            [
                'initials' => 'JL',
                'name' => 'James Lee',
                'email' => 'jamesl88@example.com',
                'from' => 'Gili Air',
                'to' => 'Bali',
                'vessel' => 'Nusa Penida Voyager',
                'date' => 'Oct 24, 2023',
                'time' => '11:15 AM',
                'amount' => 'Rp. 100.000',
                'status' => 'Confirmed',
            ],
        ];
    }
}
