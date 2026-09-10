<?php

namespace App\Support;

/**
 * Placeholder detail record — swap for an Eloquent model once the DB is in place.
 */
class BoatDetails
{
    /**
     * @return array<string, mixed>
     */
    public static function find(string $slug): array
    {
        $route = [
            'from' => 'Sanur',
            'departure' => '08:00 AM',
            'to' => 'Nusa Penida',
            'arrival' => '08:45 AM',
            'price' => 'Rp. 100.0000',
        ];

        return [
            'slug' => $slug,
            'name' => 'Maruti Fast Boat',
            'tagline' => 'Cruise along the iconic Monaco Riviera and experience world-class maritime travel.',
            'rating' => '4.8',
            'reviewCount' => '120+',
            'heroImage' => asset('images/boats/hero-boat-detail.png'),
            'specs' => [
                ['icon' => 'speed.svg', 'label' => 'Top Speed', 'value' => '35 Knots'],
                ['icon' => 'capacity.svg', 'label' => 'Capacity', 'value' => '100 Pax'],
            ],
            'facilities' => [
                ['icon' => 'air-conditioning.svg', 'label' => 'Air Conditioning'],
                ['icon' => 'toilet.svg', 'label' => 'Toilet'],
                ['icon' => 'life-jackets.svg', 'label' => 'Life Jackets'],
                ['icon' => 'insurance.svg', 'label' => 'Insurance'],
            ],
            'gallery' => [
                ['image' => 'maruti-side.png', 'alt' => 'Maruti Fast Boat side view'],
                ['image' => 'maruti-front.png', 'alt' => 'Maruti Fast Boat front view'],
                ['image' => 'maruti-deck.png', 'alt' => 'Maruti Fast Boat deck view'],
            ],
            'reviews' => [
                [
                    'stars' => 5,
                    'quote' => '"Incredibly smooth ride and the staff was extremely helpful with our luggage. Highly recommend for trips to Nusa Penida!"',
                    'name' => 'Sarah Jenkins',
                    'traveled' => 'Traveled Oct 2023',
                ],
                [
                    'stars' => 4,
                    'quote' => '"Fast and comfortable. The AC worked perfectly which was a lifesaver in the heat. Will book again."',
                    'name' => 'Mark D.',
                    'traveled' => 'Traveled Sep 2023',
                ],
            ],
            'routes' => array_fill(0, 6, $route),
        ];
    }
}
