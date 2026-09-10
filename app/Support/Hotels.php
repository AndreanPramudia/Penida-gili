<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Placeholder catalogue — swap for an Eloquent model once the DB is in place.
 */
class Hotels
{
    /**
     * @return Collection<int, array<string, mixed>>
     */
    public static function all(): Collection
    {
        $description = 'Experience unparalleled luxury on the edge of the world. The Nusa Penida Resort & Spa offers a sanctuary of tranquility with sweeping views of the Indian Ocean.';

        $catalogue = [
            [
                'name' => 'The Nusa Penida Resort & Spa',
                'description' => $description,
                'rating' => '4.8',
                'image' => 'nusa-penida-resort.png',
                'meta' => [
                    ['icon' => 'location.svg', 'label' => 'Nusa Penida, Bali, Indonesia'],
                ],
                'price' => 'IDR 2.500.000',
            ],
            [
                'name' => 'Meru Resort & Spa',
                'description' => $description,
                'rating' => '4.8',
                'image' => 'meru-resort.png',
                'meta' => [
                    ['icon' => 'location.svg', 'label' => 'Nusa Penida, Bali, Indonesia'],
                ],
                'price' => 'IDR 2.500.000',
            ],
            [
                'name' => 'Grand Hyatt Resort & Spa',
                'description' => $description,
                'rating' => '4.8',
                'image' => 'grand-hyatt-resort.png',
                'meta' => [
                    ['icon' => 'location.svg', 'label' => 'Nusa Penida, Bali, Indonesia'],
                ],
                'price' => 'IDR 2.500.000',
            ],
        ];

        return collect(array_merge($catalogue, $catalogue, $catalogue));
    }
}
