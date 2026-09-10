<?php

namespace App\Support;

/**
 * Placeholder detail record — swap for an Eloquent model once the DB is in place.
 */
class ActivityDetails
{
    /**
     * @return array<string, mixed>
     */
    public static function find(string $slug): array
    {
        return [
            'slug' => $slug,
            'badge' => 'Best Seller',
            'name' => 'Balinese Traditional Costume Rental at Penglipuran',
            'price' => 'IDR 75,000',
            'priceNote' => 'Price is valid for Domestic tourists or KITAS Holders',
            'orderHref' => route('activities.order', $slug),
            'meta' => [
                ['icon' => 'pin.svg', 'label' => 'Penglipuran'],
                ['icon' => 'clock.svg', 'label' => '08:00 - 18:00'],
                ['icon' => 'camera.svg', 'label' => 'Photography'],
            ],
            'intro' => 'Capture special moments by wearing traditional Balinese costumes while taking photos in Penglipuran Village, one of the most beautiful traditional villages in Bali. The combination of unique architecture, lush rural atmosphere, and traditional clothing creates an authentic and unforgettable cultural experience.',
            'highlights' => [
                ['icon' => 'cancellation.svg', 'title' => 'Free cancellation', 'note' => 'Up to 24 hours'],
                ['icon' => 'confirmation.svg', 'title' => 'Instant confirmation', 'note' => 'Quick & easy'],
                ['icon' => 'support.svg', 'title' => '24/7 Support', 'note' => 'We are ready to help'],
            ],
            'tabs' => [
                ['label' => 'Summary', 'anchor' => 'summary'],
                ['label' => 'Experiences', 'anchor' => 'experiences'],
                ['label' => 'Inclusions', 'anchor' => 'inclusions'],
                ['label' => 'Important Info', 'anchor' => 'important-info'],
            ],
            'gallery' => [
                ['image' => 'costume-main.png', 'alt' => 'Balinese traditional dress'],
                ['image' => 'family-dress.png', 'alt' => 'Family in Balinese dress'],
                ['image' => 'village-street.png', 'alt' => 'Penglipuran village street'],
            ],
            'summary' => 'Experience the unique feeling of wearing premium traditional Balinese costumes and capture every moment in Penglipuran Village, a tourist village famous for its beauty, cleanliness, and cultural preservation. With a backdrop of traditional Balinese houses, neatly arranged stone streets, and a serene rural atmosphere, every corner of the village becomes the perfect location to produce beautiful and memorable photos. This activity is suitable for individuals, couples, families, or groups who want to experience Balinese culture up close. Complete traditional attire with accessories will make your appearance even more authentic, while the beauty of Penglipuran Village provides a stunning backdrop for every photo. Enjoy a different cultural experience and bring home beautiful memories from one of the most iconic villages on the Island of the Gods.',
            'summaryImage' => ['image' => 'couple-dress.png', 'alt' => 'Couple in traditional dress'],
            'experiences' => [
                [
                    'title' => 'Wear Premium Traditional Balinese Costumes',
                    'body' => 'Experience wearing traditional Balinese costumes complete with elegant traditional accessories, perfect for creating an authentic and memorable look.',
                ],
                [
                    'title' => 'Take Photos in Penglipuran Village',
                    'body' => 'Capture moments in one of the most beautiful villages in Bali, famous for its traditional houses, neatly arranged streets, and very natural rural atmosphere.',
                ],
                [
                    'title' => 'Instagrammable Photos',
                    'body' => 'Every corner of Penglipuran Village offers a beautiful and aesthetic backdrop, making every photo look more attractive and full of character.',
                ],
            ],
            'related' => self::related(),
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    private static function related(): array
    {
        $pair = [
            [
                'name' => 'Kecak Uluwatu and Fire Dance',
                'image' => 'kecak-dance.png',
                'place' => 'South Bali',
                'duration' => '1-2 Hours',
                'rating' => '4.9',
                'reviews' => '137',
                'priceWas' => 'Rp. 250.000',
                'price' => 'Rp. 180.000',
                'href' => '#',
            ],
            [
                'name' => 'Barong and Kris Dance',
                'image' => 'kecak-dance.png',
                'place' => 'Gianyar',
                'duration' => '1-2 Hours',
                'rating' => '4.8',
                'reviews' => '120',
                'priceWas' => 'Rp. 180.000',
                'price' => 'Rp. 80.000',
                'href' => '#',
            ],
        ];

        return array_merge($pair, $pair);
    }
}
