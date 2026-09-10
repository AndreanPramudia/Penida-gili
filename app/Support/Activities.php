<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Placeholder catalogue — swap for an Eloquent model once the DB is in place.
 */
class Activities
{
    /**
     * @return Collection<int, array<string, mixed>>
     */
    public static function all(): Collection
    {
        $catalogue = [
            [
                'name' => 'Balinese Traditional Costume Rental at Penglipuran',
                'description' => 'Abadikan momen istimewa dengan mengenakan busana adat Bali sambil berfoto di Desa Penglipuran, salah satu desa tradisional terindah di Bali.',
                'rating' => '4.8',
                'image' => 'costume-penglipuran.png',
                'meta' => [
                    ['icon' => 'location.svg', 'label' => 'Penglipuran'],
                    ['icon' => 'clock.svg', 'label' => '08:00 - 18:00'],
                    ['icon' => 'category.svg', 'label' => 'Fotography'],
                ],
                'price' => 'IDR 75.000',
            ],
            [
                'name' => 'Barong and Kris Dance',
                'description' => 'Saksikan pertunjukan Barong & Kris Dance, salah satu warisan budaya Bali yang mengisahkan pertarungan abadi antara kebaikan dan kejahatan.',
                'rating' => '4.7',
                'image' => 'barong-kris-dance.png',
                'meta' => [
                    ['icon' => 'location.svg', 'label' => 'Penglipuran'],
                    ['icon' => 'clock.svg', 'label' => '08:00 - 18:00'],
                    ['icon' => 'category.svg', 'label' => 'Fotography'],
                ],
                'price' => 'IDR 75.000',
            ],
            [
                'name' => 'Bali Farm House',
                'description' => 'Nikmati suasana pedesaan bergaya Eropa di Bali Farm House, destinasi wisata keluarga yang menawarkan pengalaman berinteraksi dengan satwa.',
                'rating' => '4.9',
                'image' => 'bali-farm-house.png',
                'meta' => [
                    ['icon' => 'location.svg', 'label' => 'Penglipuran'],
                    ['icon' => 'clock.svg', 'label' => '09:00 - 18:00'],
                    ['icon' => 'category.svg', 'label' => 'Fotography'],
                ],
                'price' => 'IDR 75.000',
            ],
        ];

        return collect(array_merge($catalogue, $catalogue, $catalogue));
    }
}
