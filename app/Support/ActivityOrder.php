<?php

namespace App\Support;

/**
 * Placeholder order draft — swap for real cart/session state once bookings exist.
 */
class ActivityOrder
{
    /**
     * @return array<string, mixed>
     */
    public static function draft(string $slug): array
    {
        return [
            'slug' => $slug,
            'summaryTitle' => 'Activity Booking Summary',
            'rows' => [
                ['label' => 'Activity', 'value' => 'Balinese Traditional Costume Rental at Penglipuran'],
                ['label' => 'Date', 'value' => '15 Oct 2024'],
                ['label' => 'Participants', 'value' => '2 Adults'],
                ['label' => 'Price', 'value' => 'IDR 75,000 / person'],
            ],
            'total' => 'IDR 150,000',
            'party' => [
                [
                    'name' => 'adults',
                    'label' => 'Adults',
                    'value' => 1,
                    'min' => 1,
                    'price' => 'IDR 180.000 / adult',
                ],
                [
                    'name' => 'children',
                    'label' => 'Child (3 - 6 Years)',
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
