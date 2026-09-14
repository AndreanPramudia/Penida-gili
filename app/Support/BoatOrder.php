<?php

namespace App\Support;

/**
 * Placeholder order draft — swap for real cart/session state once bookings exist.
 */
class BoatOrder
{
    /**
     * @return array<string, mixed>
     */
    public static function draft(string $slug): array
    {
        return [
            'slug' => $slug,
            'tripType' => 'One Way',
            'operator' => 'Maruti Fast Boat',
            'service' => 'Standard Fast Boat Service',
            'date' => 'Fri, 24 Nov 2023',
            'departure' => '08:00',
            'arrival' => '08:45',
            'from' => 'Sanur Beach Port',
            'to' => 'Banjar Nyuh Nusa Penida',
            'lines' => [
                ['label' => '1 Adult', 'amount' => 'IDR 180.000'],
            ],
            'total' => 'IDR 180.000',
            'party' => [
                [
                    'name' => 'adults',
                    'label' => 'Adults',
                    'hint' => 'Age 13+',
                    'value' => 1,
                    'min' => 1,
                    'price' => 'IDR 180.000 / adult',
                ],
                [
                    'name' => 'children',
                    'label' => 'Child (3 - 6 Years)',
                    'hint' => 'Age 3-6',
                    'value' => 0,
                    'min' => 0,
                    'price' => 'IDR 135.000 / child',
                ],
            ],
            'nationalities' => ['Indonesia', 'Australia', 'Singapore', 'Malaysia', 'United Kingdom', 'United States'],
            'dialCodes' => ['+62', '+61', '+65', '+60', '+44', '+1'],
        ];
    }
}
