<?php

namespace Database\Seeders;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $featured = [
            'title' => 'Complete Guide to Nusa Penida Fast Boat Transfers: Schedules, Ports, and Travel Tips',
            'slug' => 'complete-guide-to-nusa-penida-fast-boat-transfers',
            'category' => 'Travel Guides',
            'excerpt' => 'Everything you need to know before sailing from Sanur to Banjar Nyuh port, best departure hours, luggage policies, and essential safety protocols.',
            'subtitle' => 'Everything you need to navigate the crossing from Sanur Beach Port to Banjar Nyuh seamlessly, with local insider advice on seating, weather, and luggage.',
            'lead' => 'Crossing the Badung Strait from the mainland of Bali to the rugged, dramatic shores of Nusa Penida is an unforgettable adventure. With towering limestone cliffs, crystalline turquoise swells, and world-renowned dive spots like Manta Point, Nusa Penida has transformed into an essential bucket-list destination. Yet, for first-time visitors, figuring out fast boat ports, ticket scheduling, luggage quotas, and harbor fees can be unexpectedly daunting.',
            'lead_follow' => 'In this authoritative guide, our maritime skippers and harbor operations team break down everything you need to experience a safe, serene, and punctual crossing aboard modern fast boats.',
            'image' => 'featured-fastboat.png',
            'hero_caption' => 'En route to Nusa Penida: Sanjaya Express Cruising at 35 knots past the Badung Strait.',
            'author_name' => 'Capt. Wayan Sudira',
            'author_role' => 'Marine Operations Lead',
            'read_time_minutes' => 6,
            'views' => 42_500,
            'tags' => ['#NusaPenida', '#FastBoatBali', '#SanurPort', '#TravelGuide', '#IslandHopping'],
            'is_featured' => true,
            'status' => ArticleStatus::Published,
            'published_at' => '2024-10-24 08:00:00',
            'content' => [
                'toc' => [
                    ['number' => '01', 'anchor' => 'section-1', 'label' => '1. Port of Departures: Sanur vs Kusamba'],
                    ['number' => '02', 'anchor' => 'section-2', 'label' => '2. Fast Boat Timetable & Durations'],
                    ['number' => '03', 'anchor' => 'section-3', 'label' => '3. Luggage Policies & Boarding Tips'],
                    ['number' => '04', 'anchor' => 'section-4', 'label' => '4. Arriving at Banjar Nyuh Harbour'],
                ],
                'ports' => [
                    'headers' => ['Departure Port', 'Crossing Time', 'Wave Conditions', 'Harbor Facilities', 'Best Suited For'],
                    'rows' => [
                        ['Sanur Beach Port', '40 - 50 mins', 'Moderate', 'Modern Pier (No wet feet)', 'South Bali tourists (Kuta, Seminyak, Canggu, Ubud)', 'highlight' => true],
                        ['Kusamba Port', '25 - 30 mins', 'Calmer', 'Basic jetty facilities', 'Travelers based in East Bali or Klungkung'],
                        ['Padang Bai', '45 mins (Ro-Ro)', 'Moderate to Rough', 'Large vehicle terminal', 'Cargo or motorcycle transport via slow ferry'],
                    ],
                ],
                'timetables' => [
                    ['icon' => 'sunrise.svg', 'route' => 'Sanur → Nusa Penida', 'badge' => 'Morning Rush', 'badgeTone' => 'blue', 'sailings' => [
                        ['depart' => '07:30 AM', 'arrive' => 'Arrives 08:15 AM', 'note' => 'Calmest Seas', 'tone' => 'brand'],
                        ['depart' => '08:30 AM', 'arrive' => 'Arrives 09:15 AM', 'note' => 'Optimal Light', 'tone' => 'muted'],
                        ['depart' => '10:00 AM', 'arrive' => 'Arrives 10:45 AM', 'note' => 'Regular Trip', 'tone' => 'muted'],
                    ]],
                    ['icon' => 'return.svg', 'route' => 'Nusa Penida → Sanur', 'badge' => 'Return Sailings', 'badgeTone' => 'grey', 'sailings' => [
                        ['depart' => '09:15 AM', 'arrive' => 'Arrives 10:00 AM', 'note' => 'Early Return', 'tone' => 'muted'],
                        ['depart' => '02:30 PM', 'arrive' => 'Arrives 03:15 PM', 'note' => 'After Lunch', 'tone' => 'muted'],
                        ['depart' => '04:30 PM', 'arrive' => 'Arrives 05:15 PM', 'note' => 'Last Fast Boat', 'tone' => 'alert'],
                    ]],
                ],
                'luggage' => [
                    ['icon' => 'luggage.svg', 'title' => '25kg Free Allowance', 'body' => 'One large suitcase plus hand carry daypack per passenger.'],
                    ['icon' => 'waterproof.svg', 'title' => 'Waterproof Stowing', 'body' => 'Bags are stored in enclosed watertight hull compartments.'],
                    ['icon' => 'surfboard.svg', 'title' => 'Surfboard Cargo', 'body' => 'Surfboards & scuba gear allowed with a nominal IDR 50k fee.'],
                ],
                'advice' => [
                    ['icon' => 'advice-1.svg', 'lead' => 'Arrive 45 Minutes Early:', 'body' => 'Check-in counters at Sanur Beach Harbour close 15 minutes before departure to finalize passenger manifests.'],
                    ['icon' => 'advice-2.svg', 'lead' => 'Motion Sickness Prevention:', 'body' => 'If prone to seasickness, take Antimo (Dimenhydrinate) 30 minutes prior to boarding, and choose middle or aft seating where vessel pitch is minimal.'],
                ],
                'arrival' => [
                    ['icon' => 'scooter.svg', 'title' => 'Scooter Rental On-Site', 'body' => 'Reputable rentals line the harbor exit. Expect to pay IDR 75,000 - 100,000 per day including helmets. Ensure you inspect brakes and tire treads as island roads have steep inclines.'],
                    ['icon' => 'driver.svg', 'title' => 'Private Driver & Van', 'body' => 'If you prefer air-conditioned comfort, pre-booking a certified island driver (around IDR 600,000 / day including fuel) is strongly recommended over haggling with street touts.'],
                ],
                'popular' => [
                    ['image' => 'pop-instagram.png', 'category' => 'Island Guides', 'title' => 'Top 7 Instagram Spots in West Nusa Penida', 'readTime' => '4 min read'],
                    ['image' => 'pop-manta.png', 'category' => 'Marine Wildlife', 'title' => 'Snorkeling with Manta Rays: Best Seasons & Tips', 'readTime' => '5 min read'],
                    ['image' => 'pop-stay.png', 'category' => 'Accommodations', 'title' => 'Where to Stay in Nusa Penida: Coast vs Cliffside', 'readTime' => '7 min read'],
                ],
            ],
        ];

        Article::query()->updateOrCreate(['slug' => $featured['slug']], $featured);

        $others = [
            ['category' => 'Activities', 'read_time_minutes' => 4, 'published_at' => '2024-10-21', 'title' => 'Top 7 Unmissable Snorkeling Spots around Nusa Penida & Gili Meno', 'excerpt' => 'Discover secluded bays, crystal clarity reefs, and resident sea turtle sanctuaries accessible by fast boat.', 'author_name' => 'Dewa Krisna', 'author_role' => 'Divemaster & Guide', 'image' => 'snorkeling.png', 'views' => 28_100],
            ['category' => 'Boat Tips', 'read_time_minutes' => 6, 'published_at' => '2024-10-18', 'title' => 'Best Time of Day for Calm Waters: Crossing the Badung Strait Comfortably', 'excerpt' => 'Learn how tides and morning winds impact nautical comfort, plus recommendations for the smoothest sailing windows.', 'author_name' => 'Capt. Wayan Sudira', 'author_role' => 'Master Mariner', 'image' => 'badung-strait.png', 'views' => 19_300],
            ['category' => 'Travel Guides', 'read_time_minutes' => 5, 'published_at' => '2024-10-15', 'title' => 'Kelingking T-Rex Cliff & Diamond Beach: How to Plan Your Day Trip', 'excerpt' => 'Timing your arrival right after the morning fast boat docking to beat inland tourist crowds and heat.', 'author_name' => 'Ayu Pradnya', 'author_role' => 'Travel Concierge', 'image' => 'kelingking.png', 'views' => 15_200],
            ['category' => 'Boat Tips', 'read_time_minutes' => 7, 'published_at' => '2024-10-13', 'title' => 'Choosing Between Fast Ferry vs Speedboat: Comfort, Speed & Price Comparison', 'excerpt' => 'An objective breakdown comparing multi-engine aluminium hulls with traditional fibreglass speedboats.', 'author_name' => 'Putu Ardhana', 'author_role' => 'Harbour Operations', 'image' => 'ferry-vs-speedboat.png', 'views' => 8_400],
            ['category' => 'Travel Guides', 'read_time_minutes' => 4, 'published_at' => '2024-10-09', 'title' => 'What to Pack for an Island Getaway to Nusa Lembongan and Ceningan', 'excerpt' => 'Essential footwear, waterproof gear, cash logistics, and light luggage practices for wet landings.', 'author_name' => 'Sarah Jenkins', 'author_role' => 'Travel Writer', 'image' => 'lembongan-packing.png', 'views' => 6_900],
            ['category' => 'Culture', 'read_time_minutes' => 5, 'published_at' => '2024-10-04', 'title' => 'Balinese Cultural Etiquette: Visiting Pura Goa Giri Putri and Sacred Temples', 'excerpt' => 'Respectful customs, required temple sarongs, purification rituals, and cave access protocols.', 'author_name' => 'Made Suwerta', 'author_role' => 'Cultural Advisor', 'image' => 'goa-giri-putri.png', 'views' => 9_800],
        ];

        foreach ($others as $data) {
            Article::query()->updateOrCreate(['title' => $data['title']], $data + [
                'body' => $data['excerpt'],
                'tags' => ['#NusaPenida', '#TravelGuide'],
                'status' => ArticleStatus::Published,
            ]);
        }
    }
}
