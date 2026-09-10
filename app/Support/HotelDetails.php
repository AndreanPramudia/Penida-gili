<?php

namespace App\Support;

/**
 * Placeholder detail record — swap for an Eloquent model once the DB is in place.
 */
class HotelDetails
{
    /**
     * @return array<string, mixed>
     */
    public static function find(string $slug): array
    {
        return [
            'slug' => $slug,
            'category' => 'Hotel',
            'stars' => 5,
            'name' => 'The Nusa Penida Resort & Spa',
            'address' => 'Nusa Penida, Bali, Indonesia',
            'fullAddress' => 'Jalan Raya Toya Pakeh - Ped, Nusa Penida, Bali 80771, Indonesia',
            'description' => 'Experience unparalleled luxury on the edge of the world. The Nusa Penida Resort & Spa offers a sanctuary of tranquility with sweeping views of the Indian Ocean. Designed for the discerning traveler, our resort seamlessly blends modern elegance with authentic Balinese charm, providing the ultimate island getaway.',
            'priceFrom' => 'IDR 2,500K',
            'guestOptions' => ['2 Guests, 1 Room', '3 Guests, 1 Room', '4 Guests, 2 Rooms'],
            'gallery' => [
                ['image' => 'pool-main.png', 'alt' => 'Infinity pool overlooking the ocean'],
                ['image' => 'bedroom.png', 'alt' => 'Ocean view bedroom'],
                ['image' => 'sunset-dining.png', 'alt' => 'Sunset dining terrace'],
                ['image' => 'suite.png', 'alt' => 'Suite interior'],
                ['image' => 'cocktail.png', 'alt' => 'Cocktail at the sunset bar', 'more' => '+12 Photos'],
            ],
            'amenities' => [
                ['icon' => 'wifi.svg', 'label' => 'Free High-Speed Wi-Fi'],
                ['icon' => 'pool.svg', 'label' => 'Infinity Pool'],
                ['icon' => 'spa.svg', 'label' => 'Full-Service Spa'],
                ['icon' => 'restaurant.svg', 'label' => 'Oceanfront Restaurant'],
                ['icon' => 'bar.svg', 'label' => 'Sunset Bar'],
                ['icon' => 'ocean-view.svg', 'label' => 'Ocean View Rooms'],
            ],
            'rooms' => [
                [
                    'name' => 'Deluxe Ocean Room',
                    'description' => 'Spacious 45m² room featuring a private balcony with panoramic ocean views, king-size bed, and luxurious en-suite bathroom.',
                    'guests' => '2 Guests',
                    'bed' => '1 King Bed',
                    'price' => 'IDR 2,500,000',
                    'image' => 'room-deluxe.png',
                ],
                [
                    'name' => 'Private Pool Villa',
                    'description' => 'An exclusive 120m² villa offering unparalleled privacy, featuring a private plunge pool, expansive sun deck, and dedicated butler service.',
                    'guests' => '2 Guests',
                    'bed' => '1 King Bed',
                    'price' => 'IDR 5,800,000',
                    'image' => 'room-villa.png',
                ],
            ],
            'reviews' => [
                [
                    'stars' => 5,
                    'quote' => '"Absolutely breathtaking. The private pool villa was a dream, and waking up to the sound of the ocean was unforgettable. The service is impeccable."',
                    'initials' => 'SM',
                    'name' => 'Sarah M.',
                    'stayed' => 'Stayed Oct 2023',
                ],
                [
                    'stars' => 5,
                    'quote' => '"A true slice of paradise. The infinity pool offers the best sunset views in Nusa Penida. The restaurant\'s seafood was remarkably fresh and delicious."',
                    'initials' => 'JD',
                    'name' => 'James D.',
                    'stayed' => 'Stayed Sep 2023',
                ],
            ],
        ];
    }
}
