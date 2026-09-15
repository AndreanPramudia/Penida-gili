<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $description = 'Experience unparalleled luxury on the edge of the world. The Nusa Penida Resort & Spa offers a sanctuary of tranquility with sweeping views of the Indian Ocean. Designed for the discerning traveler, our resort seamlessly blends modern elegance with authentic Balinese charm, providing the ultimate island getaway.';

        $gallery = [
            ['image' => 'pool-main.png', 'alt' => 'Infinity pool overlooking the ocean'],
            ['image' => 'bedroom.png', 'alt' => 'Ocean view bedroom'],
            ['image' => 'sunset-dining.png', 'alt' => 'Sunset dining terrace'],
            ['image' => 'suite.png', 'alt' => 'Suite interior'],
            ['image' => 'cocktail.png', 'alt' => 'Cocktail at the sunset bar', 'more' => '+12 Photos'],
        ];

        $amenities = [
            ['icon' => 'wifi.svg', 'label' => 'Free High-Speed Wi-Fi', 'shortLabel' => 'Free Wi-Fi'],
            ['icon' => 'pool.svg', 'label' => 'Infinity Pool', 'shortLabel' => 'Infinity Pool'],
            ['icon' => 'spa.svg', 'label' => 'Full-Service Spa', 'shortLabel' => 'Luxury Spa'],
            ['icon' => 'restaurant.svg', 'label' => 'Oceanfront Restaurant', 'shortLabel' => 'Fine Dining'],
            ['icon' => 'bar.svg', 'label' => 'Sunset Bar'],
            ['icon' => 'ocean-view.svg', 'label' => 'Ocean View Rooms'],
        ];

        $rooms = [
            ['name' => 'Deluxe Ocean Room', 'description' => 'Spacious 45m² room featuring a private balcony with panoramic ocean views, king-size bed, and luxurious en-suite bathroom.', 'guests' => 2, 'bed' => '1 King Bed', 'size_label' => '45 m² Ocean Terrace', 'price_per_night' => 2_500_000, 'stock' => 8, 'image' => 'room-deluxe.png', 'sort_order' => 1],
            ['name' => 'Private Pool Villa', 'description' => 'An exclusive 120m² villa offering unparalleled privacy, featuring a private plunge pool, expansive sun deck, and dedicated butler service.', 'guests' => 2, 'bed' => '1 King Bed', 'size_label' => '120 m² Private Oasis', 'price_per_night' => 5_800_000, 'stock' => 4, 'image' => 'room-villa.png', 'sort_order' => 2],
        ];

        $hotels = [
            ['name' => 'The Nusa Penida Resort & Spa', 'category' => 'Resort', 'partner_label' => 'Direct Fastboat Partner', 'rating' => 4.9, 'review_count' => 94, 'address' => 'Nusa Penida, Bali, Indonesia', 'full_address' => 'Jalan Raya Toya Pakeh - Ped, Nusa Penida, Bali 80771, Indonesia', 'image' => 'nusa-penida-resort.png'],
            ['name' => 'Meru Resort & Spa', 'category' => 'Resort', 'partner_label' => 'Sunset Point Partner', 'rating' => 4.8, 'review_count' => 128, 'address' => 'Crystal Bay, Nusa Penida, Bali', 'full_address' => 'Crystal Bay, Sakti, Nusa Penida, Bali 80771, Indonesia', 'image' => 'meru-resort.png'],
            ['name' => 'Grand Hyatt Resort & Spa', 'category' => 'Hotel', 'partner_label' => 'Luxury Collection', 'rating' => 5.0, 'review_count' => 210, 'address' => 'Sanur Beachfront, Bali', 'full_address' => 'Jalan Danau Tamblingan, Sanur, Denpasar, Bali 80228, Indonesia', 'image' => 'grand-hyatt-resort.png'],
            ['name' => 'Semabu Hills Hotel Nusa Penida', 'category' => 'Hotel', 'partner_label' => 'Hilltop Panorama', 'rating' => 4.7, 'review_count' => 82, 'address' => 'Ped, Nusa Penida, Bali', 'full_address' => 'Jalan Raya Ped, Nusa Penida, Bali 80771, Indonesia', 'image' => 'nusa-penida-resort.png'],
            ['name' => 'Batu Karang Lembongan Resort', 'category' => 'Resort', 'partner_label' => 'Coral Bay Front', 'rating' => 4.9, 'review_count' => 115, 'address' => 'Jungutbatu, Nusa Lembongan', 'full_address' => 'Jungutbatu, Nusa Lembongan, Klungkung, Bali 80771, Indonesia', 'image' => 'meru-resort.png'],
        ];

        foreach ($hotels as $data) {
            $hotel = Hotel::query()->updateOrCreate(['name' => $data['name']], $data + [
                'stars' => 5,
                'description' => $description,
                'gallery' => $gallery,
                'amenities' => $amenities,
            ]);

            foreach ($rooms as $room) {
                $hotel->rooms()->updateOrCreate(['name' => $room['name']], $room);
            }

            if ($hotel->reviews()->doesntExist()) {
                $hotel->reviews()->createMany([
                    ['name' => 'Sarah M.', 'stars' => 5, 'quote' => '"Absolutely breathtaking. The private pool villa was a dream, and waking up to the sound of the ocean was unforgettable. The service is impeccable."', 'experienced_at' => '2023-10-10'],
                    ['name' => 'James D.', 'stars' => 5, 'quote' => '"A true slice of paradise. The infinity pool offers the best sunset views in Nusa Penida. The restaurant\'s seafood was remarkably fresh and delicious."', 'experienced_at' => '2023-09-18'],
                ]);
            }
        }
    }
}
