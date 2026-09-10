<?php

namespace App\Support;

/**
 * Placeholder article body — swap for an Eloquent model / CMS once content exists.
 */
class ArticleDetails
{
    /**
     * @return array<string, mixed>
     */
    public static function find(string $slug): array
    {
        return [
            'slug' => $slug,
            'category' => 'Travel Guides',
            'readTime' => '6 min read',
            'date' => 'October 24, 2024',
            'views' => '2.4k views',
            'title' => 'Complete Guide to Nusa Penida Fast Boat Transfers: Schedules, Ports, and Travel Tips',
            'subtitle' => 'Everything you need to navigate the crossing from Sanur Beach Port to Banjar Nyuh seamlessly, with local insider advice on seating, weather, and luggage.',
            'author' => 'Capt. Wayan Sudira',
            'authorRole' => 'Reviewed by Marine Safety Officer',
            'heroCaption' => 'En route to Nusa Penida: Sanjaya Express Cruising at 35 knots past the Badung Strait.',
            'lead' => 'Crossing the Badung Strait from the mainland of Bali to the rugged, dramatic shores of Nusa Penida is an unforgettable adventure. With towering limestone cliffs, crystalline turquoise swells, and world-renowned dive spots like Manta Point, Nusa Penida has transformed into an essential bucket-list destination. Yet, for first-time visitors, figuring out fast boat ports, ticket scheduling, luggage quotas, and harbor fees can be unexpectedly daunting.',
            'leadFollow' => 'In this authoritative guide, our maritime skippers and harbor operations team break down everything you need to experience a safe, serene, and punctual crossing aboard modern fast boats.',
            'tags' => ['#NusaPenida', '#FastBoatBali', '#SanurPort', '#TravelGuide', '#IslandHopping'],
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
                [
                    'icon' => 'sunrise.svg',
                    'route' => 'Sanur → Nusa Penida',
                    'badge' => 'Morning Rush',
                    'badgeTone' => 'blue',
                    'sailings' => [
                        ['depart' => '07:30 AM', 'arrive' => 'Arrives 08:15 AM', 'note' => 'Calmest Seas', 'tone' => 'brand'],
                        ['depart' => '08:30 AM', 'arrive' => 'Arrives 09:15 AM', 'note' => 'Optimal Light', 'tone' => 'muted'],
                        ['depart' => '10:00 AM', 'arrive' => 'Arrives 10:45 AM', 'note' => 'Regular Trip', 'tone' => 'muted'],
                    ],
                ],
                [
                    'icon' => 'return.svg',
                    'route' => 'Nusa Penida → Sanur',
                    'badge' => 'Return Sailings',
                    'badgeTone' => 'grey',
                    'sailings' => [
                        ['depart' => '09:15 AM', 'arrive' => 'Arrives 10:00 AM', 'note' => 'Early Return', 'tone' => 'muted'],
                        ['depart' => '02:30 PM', 'arrive' => 'Arrives 03:15 PM', 'note' => 'After Lunch', 'tone' => 'muted'],
                        ['depart' => '04:30 PM', 'arrive' => 'Arrives 05:15 PM', 'note' => 'Last Fast Boat', 'tone' => 'alert'],
                    ],
                ],
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
            'related' => [
                ['image' => 'rel-snorkeling.png', 'category' => 'Activity', 'date' => 'October 18, 2024', 'readTime' => '5 min read', 'title' => '5 Unrivaled Snorkeling Spots Around Nusa Penida & Lembongan', 'excerpt' => 'From Crystal Bay to Gamat Bay, discover protected coves where marine life…'],
                ['image' => 'rel-weather.png', 'category' => 'Weather & Seasons', 'date' => 'October 12, 2024', 'readTime' => '7 min read', 'title' => 'Best Time of Year to Visit Nusa Penida: Weather & Tides', 'excerpt' => 'A month-by-month breakdown of sea swells, monsoon patterns, and…'],
                ['image' => 'rel-hotels.png', 'category' => 'Hotels', 'date' => 'September 29, 2024', 'readTime' => '6 min read', 'title' => 'Handpicked Boutique Hotels & Clifftop Villas in Nusa Penida', 'excerpt' => 'Indulge in panoramic sea horizons and unmatched Indonesian hospitality after…'],
            ],
        ];
    }
}
