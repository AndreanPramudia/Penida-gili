<?php

namespace App\Support;

/**
 * Placeholder order draft — swap for real cart/session state once bookings exist.
 */
class HotelOrder
{
    /**
     * @return array<string, mixed>
     */
    public static function draft(string $slug): array
    {
        return [
            'slug' => $slug,
            'summaryTitle' => 'Hotel Booking Summary',
            'propertyType' => 'Resort',
            'property' => 'The Nusa Penida Resort & Spa',
            'location' => 'Nusa Penida, Bali, Indonesia',
            'thumb' => 'summary-thumb.png',
            'details' => [
                ['icon' => 'room-type.svg', 'label' => 'Room Type', 'value' => 'Private Pool Villa'],
                ['icon' => 'calendar.svg', 'label' => 'Dates', 'value' => '12 Oct 2024 - 14 Oct 2024', 'note' => '(2 Nights)'],
                ['icon' => 'guests.svg', 'label' => 'Guests', 'value' => '2 Adults'],
            ],
            'lineLabel' => 'IDR 5,800,000 x 2 nights',
            'lineAmount' => 'IDR 11,600,000',
            'total' => 'IDR 11,600,000',
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
