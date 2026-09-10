<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Placeholder catalogue — swap for an Eloquent model once the DB is in place.
 */
class BoatOperators
{
    /**
     * @return Collection<int, array<string, mixed>>
     */
    public static function all(): Collection
    {
        $catalogue = [
            [
                'name' => 'Maruti Fast Boat',
                'description' => 'Cruise along the iconic Monaco Riviera and experience world-class service.',
                'rating' => '4.8',
                'image' => 'boat-maruti.png',
                'routes' => 2,
                'vessels' => 2,
            ],
            [
                'name' => 'Semabu Hill Fast Boat',
                'description' => 'Sail through the breathtaking Amalfi Coast and indulge in exquisite comfort.',
                'rating' => '4.7',
                'image' => 'boat-semabu.png',
                'routes' => 2,
                'vessels' => 2,
            ],
            [
                'name' => 'Angel Billabong Fast Cruise',
                'description' => 'Explore the stunning Whitsunday Islands and enjoy unparalleled views.',
                'rating' => '4.9',
                'image' => 'boat-angel.png',
                'routes' => 2,
                'vessels' => 2,
            ],
        ];

        return collect(array_merge($catalogue, $catalogue, $catalogue));
    }
}
