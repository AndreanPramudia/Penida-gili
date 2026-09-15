<?php

namespace Database\Seeders;

use App\Enums\ListingStatus;
use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $highlights = [
            ['icon' => 'cancellation.svg', 'title' => 'Free cancellation', 'note' => 'Up to 24 hours'],
            ['icon' => 'confirmation.svg', 'title' => 'Instant confirmation', 'note' => 'Quick & easy'],
            ['icon' => 'support.svg', 'title' => '24/7 Support', 'note' => 'We are ready to help'],
        ];

        $costume = [
            'name' => 'Balinese Traditional Costume Rental at Penglipuran',
            'badge' => 'Best Seller',
            'category' => 'Photography',
            'location' => 'Bangli, Penglipuran',
            'place_label' => 'Penglipuran',
            'opens_at' => '08:00', 'closes_at' => '18:00', 'duration_label' => '1-2 Hours',
            'description' => 'Abadikan momen istimewa dengan mengenakan busana adat Bali sambil berfoto di Desa Penglipuran, salah satu desa tradisional terindah di Bali.',
            'intro' => 'Capture special moments by wearing traditional Balinese costumes while taking photos in Penglipuran Village, one of the most beautiful traditional villages in Bali. The combination of unique architecture, lush rural atmosphere, and traditional clothing creates an authentic and unforgettable cultural experience.',
            'summary' => 'Experience the unique feeling of wearing premium traditional Balinese costumes and capture every moment in Penglipuran Village, a tourist village famous for its beauty, cleanliness, and cultural preservation. With a backdrop of traditional Balinese houses, neatly arranged stone streets, and a serene rural atmosphere, every corner of the village becomes the perfect location to produce beautiful and memorable photos. This activity is suitable for individuals, couples, families, or groups who want to experience Balinese culture up close. Complete traditional attire with accessories will make your appearance even more authentic, while the beauty of Penglipuran Village provides a stunning backdrop for every photo. Enjoy a different cultural experience and bring home beautiful memories from one of the most iconic villages on the Island of the Gods.',
            'summary_image' => 'couple-dress.png',
            'image' => 'costume-penglipuran.png',
            'gallery' => [
                ['image' => 'costume-main.png', 'alt' => 'Balinese traditional dress'],
                ['image' => 'family-dress.png', 'alt' => 'Family in Balinese dress'],
                ['image' => 'village-street.png', 'alt' => 'Penglipuran village street'],
            ],
            'highlights' => $highlights,
            'experiences' => [
                ['title' => 'Wear Premium Traditional Balinese Costumes', 'body' => 'Experience wearing traditional Balinese costumes complete with elegant traditional accessories, perfect for creating an authentic and memorable look.'],
                ['title' => 'Take Photos in Penglipuran Village', 'body' => 'Capture moments in one of the most beautiful villages in Bali, famous for its traditional houses, neatly arranged streets, and very natural rural atmosphere.'],
                ['title' => 'Instagrammable Photos', 'body' => 'Every corner of Penglipuran Village offers a beautiful and aesthetic backdrop, making every photo look more attractive and full of character.'],
            ],
            'included' => ['Traditional Balinese Attire', 'Makeup & Hair Styling', 'Local Accessories', 'Village Entrance Ticket'],
            'excluded' => ['Transportation to location', 'Personal expenses', 'Food & drinks'],
            'price_adult' => 75_000, 'price_child' => 50_000, 'price_note' => 'Price is valid for Domestic tourists or KITAS Holders',
            'rating' => 4.8, 'review_count' => 120, 'sold_count' => 120,
        ];

        $activities = [
            $costume,
            [
                'name' => 'Barong and Kris Dance', 'category' => 'Cultural Show', 'location' => 'Batubulan, Gianyar', 'place_label' => 'Gianyar',
                'opens_at' => '09:30', 'closes_at' => '10:30', 'duration_label' => '1-2 Hours',
                'description' => 'Saksikan pertunjukan Barong & Kris Dance, salah satu warisan budaya Bali yang mengisahkan pertarungan abadi antara kebaikan dan kejahatan.',
                'image' => 'barong-kris-dance.png',
                'gallery' => [['image' => 'kecak-dance.png', 'alt' => 'Barong dance performance']],
                'price_adult' => 80_000, 'price_child' => 60_000, 'price_was' => 180_000,
                'rating' => 4.7, 'review_count' => 122, 'sold_count' => 340,
            ],
            [
                'name' => 'Bali Farm House', 'category' => 'Wildlife & Nature', 'location' => 'Pancasari, Bedugul', 'place_label' => 'Bedugul',
                'opens_at' => '08:00', 'closes_at' => '17:00', 'duration_label' => '2-3 Hours',
                'description' => 'Nikmati suasana pedesaan bergaya Eropa di Bali Farm House, destinasi wisata keluarga yang menawarkan pengalaman berinteraksi dengan satwa.',
                'image' => 'bali-farm-house.png',
                'gallery' => [['image' => 'village-street.png', 'alt' => 'Bali Farm House']],
                'price_adult' => 280_000, 'price_child' => 200_000,
                'rating' => 4.9, 'review_count' => 145, 'sold_count' => 215,
            ],
            [
                'name' => 'Kecak Uluwatu & Fire Dance', 'category' => 'Cultural Show', 'location' => 'Uluwatu, Badung', 'place_label' => 'South Bali',
                'opens_at' => '17:45', 'closes_at' => '19:00', 'duration_label' => '1-2 Hours',
                'description' => 'Watch the legendary Kecak chant and fire dance at sunset on the Uluwatu cliff.',
                'image' => 'barong-kris-dance.png',
                'gallery' => [['image' => 'kecak-dance.png', 'alt' => 'Kecak dance at Uluwatu']],
                'price_adult' => 180_000, 'price_child' => 120_000, 'price_was' => 250_000,
                'rating' => 4.9, 'review_count' => 410, 'sold_count' => 520,
            ],
            [
                'name' => 'Nusa Penida Snorkeling', 'category' => 'Water Sports', 'location' => 'Manta Bay, Nusa Penida', 'place_label' => 'Nusa Penida',
                'opens_at' => '08:30', 'closes_at' => '15:00', 'duration_label' => 'Half Day',
                'description' => 'Snorkel with manta rays and explore the coral gardens of Crystal Bay and Gamat Bay.',
                'image' => 'bali-farm-house.png',
                'gallery' => [['image' => 'village-street.png', 'alt' => 'Snorkeling trip']],
                'price_adult' => 250_000, 'price_child' => 175_000,
                'rating' => 4.9, 'review_count' => 320, 'sold_count' => 185,
            ],
            [
                'name' => 'Foto Adat Bali Kuta', 'category' => 'Photography', 'location' => 'Kuta Beach, Badung', 'place_label' => 'Kuta',
                'opens_at' => '16:00', 'closes_at' => '18:30', 'duration_label' => '1-2 Hours',
                'description' => 'Sunset photoshoot in traditional Balinese attire on Kuta beach.',
                'image' => 'costume-penglipuran.png',
                'gallery' => [['image' => 'costume-main.png', 'alt' => 'Balinese attire photoshoot']],
                'price_adult' => 300_000, 'price_child' => 200_000, 'price_was' => 350_000,
                'rating' => 4.8, 'review_count' => 38, 'sold_count' => 40, 'status' => ListingStatus::Draft,
            ],
        ];

        foreach ($activities as $data) {
            Activity::query()->updateOrCreate(['name' => $data['name']], $data + [
                'highlights' => $highlights,
                'intro' => $data['description'],
                'summary' => $data['description'],
                'summary_image' => 'couple-dress.png',
                'experiences' => [],
                'included' => [],
                'excluded' => [],
                'price_note' => 'Price is valid for Domestic tourists or KITAS Holders',
                'status' => ListingStatus::Active,
            ]);
        }
    }
}
