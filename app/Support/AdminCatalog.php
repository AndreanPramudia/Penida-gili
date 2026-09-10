<?php

namespace App\Support;

/**
 * Placeholder rows for the console listings — swap for real queries once the DB
 * is in place. The shapes mirror the Figma tables one-for-one.
 */
class AdminCatalog
{
    /**
     * @return array<int, array<string, string>>
     */
    public static function boats(): array
    {
        $rows = [
            ['name' => 'Sanjaya Ocean Queen', 'code' => 'SFB-001', 'type' => 'Catamaran Fast Ferry', 'capacity' => '150 Pax', 'status' => 'Active', 'tone' => 'active', 'inspected' => 'Oct 12, 2023'],
            ['name' => 'Sanjaya Express II', 'code' => 'SFB-002', 'type' => 'Mono-hull Fastboat', 'capacity' => '85 Pax', 'status' => 'Active', 'tone' => 'active', 'inspected' => 'Nov 01, 2023'],
            ['name' => 'Sanjaya Explorer', 'code' => 'SFB-005', 'type' => 'Luxury Catamaran', 'capacity' => '120 Pax', 'status' => 'Non-Active', 'tone' => 'inactive', 'inspected' => 'Sep 28, 2023'],
        ];

        return array_merge($rows, $rows);
    }

    /**
     * @return array<int, array<string, string>>
     */
    public static function schedules(): array
    {
        $rows = [
            ['route' => 'Sanur - Nusa Penida', 'depart' => '08:30 AM', 'arrive' => '09:15 AM', 'boat' => 'Sanjaya Explorer I', 'cap' => 'Cap: 80', 'price' => 'RP100.000', 'status' => 'Active', 'tone' => 'active'],
            ['route' => 'Nusa Penida - Sanur', 'depart' => '16:00 PM', 'arrive' => '16:45 PM', 'boat' => 'Sanjaya Explorer I', 'cap' => 'Cap: 80', 'price' => 'RP100.000', 'status' => 'Active', 'tone' => 'active'],
            ['route' => 'Sanur - Gili Trawangan', 'depart' => '09:00 AM', 'arrive' => '11:30 AM', 'boat' => 'Sanjaya Express', 'cap' => 'Cap: 120', 'price' => 'RP100.000', 'status' => 'Draft', 'tone' => 'draft'],
        ];

        return array_merge($rows, $rows);
    }

    /**
     * @return array<int, array<string, string>>
     */
    public static function activities(): array
    {
        return [
            ['name' => 'Balinese Traditional Costume Rental', 'image' => 'activities/costume-penglipuran.png', 'rating' => '4.8', 'hours' => '08:00 - 18:00', 'tag' => 'Terlaris', 'category' => 'Photography & Culture', 'location' => 'Bangli, Penglipuran', 'price' => 'IDR 75.000', 'unit' => '/ orang', 'status' => 'Active', 'tone' => 'active', 'sold' => '120'],
            ['name' => 'Barong and Kris Dance', 'image' => 'activities/barong-kris-dance.png', 'rating' => '4.7', 'hours' => '09:30 - 10:30', 'tag' => '122 ulasan', 'category' => 'Cultural Show', 'location' => 'Batubulan, Gianyar', 'price' => 'IDR 75.000', 'unit' => 'Rp 150.000', 'status' => 'Active', 'tone' => 'active', 'sold' => '340'],
            ['name' => 'Bali Farm House Tour', 'image' => 'activities/bali-farm-house.png', 'rating' => '4.9', 'hours' => '08:00 - 17:00', 'tag' => '145 ulasan', 'category' => 'Wildlife & Nature', 'location' => 'Pancasari, Bedugul', 'price' => 'IDR 280.000', 'unit' => '/ pax', 'status' => 'Active', 'tone' => 'active', 'sold' => '215'],
            ['name' => 'Kecak Uluwatu & Fire Dance', 'image' => 'activities/detail/kecak-dance.png', 'rating' => '4.9', 'hours' => '17:45 - 19:00', 'tag' => '410 ulasan', 'category' => 'Cultural Show', 'location' => 'Uluwatu, Badung', 'price' => 'IDR 180.000', 'unit' => 'Rp 250.000', 'status' => 'Active', 'tone' => 'active', 'sold' => '520'],
            ['name' => 'Nusa Penida Snorkeling', 'image' => 'articles/snorkeling.png', 'rating' => '4.9', 'hours' => '08:30 - 15:00', 'tag' => '320 ulasan', 'category' => 'Water Sports', 'location' => 'Manta Bay, Nusa Penida', 'price' => 'IDR 250.000', 'unit' => '/ pax', 'status' => 'Active', 'tone' => 'active', 'sold' => '185'],
            ['name' => 'Foto Adat Bali Kuta', 'image' => 'activities/detail/costume-main.png', 'rating' => '4.8', 'hours' => '16:00 - 18:30', 'tag' => '38 ulasan', 'category' => 'Photography', 'location' => 'Kuta Beach, Badung', 'price' => 'IDR 300.000', 'unit' => 'Rp 350.000', 'status' => 'Draft', 'tone' => 'draft', 'sold' => '40'],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    public static function hotels(): array
    {
        return [
            ['name' => 'The Nusa Penida Resort & Spa', 'partner' => 'Direct Fastboat Partner', 'image' => 'hotels/nusa-penida-resort.png', 'location' => 'Toya Pakeh, Nusa Penida, Bali', 'rating' => '5.0', 'reviews' => '94', 'rooms' => '12 Rooms (4 Suites)', 'price' => 'IDR 2.500.000', 'status' => 'Active', 'tone' => 'active', 'bookings' => '42', 'full' => '92% full'],
            ['name' => 'Meru Resort & Spa', 'partner' => 'Sunset Point Partner', 'image' => 'hotels/meru-resort.png', 'location' => 'Crystal Bay, Nusa Penida, Bali', 'rating' => '4.8', 'reviews' => '128', 'rooms' => '8 Rooms (Villas)', 'price' => 'IDR 5.500.000', 'status' => 'Active', 'tone' => 'active', 'bookings' => '42', 'full' => '92% full'],
            ['name' => 'Grand Hyatt Resort & Spa', 'partner' => 'Luxury Collection', 'image' => 'hotels/grand-hyatt-resort.png', 'location' => 'Sanur Beachfront, Bali', 'rating' => '5.0', 'reviews' => '210', 'rooms' => '24 Rooms (Harbour view)', 'price' => 'IDR 1.500.000', 'status' => 'Active', 'tone' => 'active', 'bookings' => '42', 'full' => '92% full'],
            ['name' => 'Semabu Hills Hotel Nusa Penida', 'partner' => 'Hilltop Panorama', 'image' => 'hotels/detail/pool-main.png', 'location' => 'Ped, Nusa Penida, Bali', 'rating' => '4.7', 'reviews' => '82', 'rooms' => '16 Rooms', 'price' => 'IDR 4.500.000', 'status' => 'Active', 'tone' => 'active', 'bookings' => '42', 'full' => '92% full'],
            ['name' => 'Batu Karang Lembongan Resort', 'partner' => 'Coral Bay Front', 'image' => 'hotels/detail/suite.png', 'location' => 'Jungutbatu, Nusa Lembongan', 'rating' => '4.9', 'reviews' => '115', 'rooms' => '10 Villas', 'price' => 'IDR 3.500.000', 'status' => 'Active', 'tone' => 'active', 'bookings' => '42', 'full' => '92% full'],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    public static function articles(): array
    {
        return [
            ['title' => 'Complete Guide to Nusa Penida', 'excerpt' => 'Sanur Harbor → Banjar Nyuh Pier • 6 min read', 'image' => 'articles/featured-fastboat.png', 'category' => 'Travel Guides', 'author' => 'Capt. Wayan Sudira', 'role' => 'Master Mariner', 'initials' => 'WS', 'views' => '42.5K', 'date' => '24 Oct 2024', 'status' => 'Published', 'tone' => 'published'],
            ['title' => 'Top 7 Unmissable Snorkeling Spots', 'excerpt' => 'Manta Point, Crystal Bay & Reefs • 4 min read', 'image' => 'articles/snorkeling.png', 'category' => 'Activities', 'author' => 'Dewa Krisna', 'role' => 'Divemaster & Guide', 'initials' => 'DK', 'views' => '28.1K', 'date' => '18 Oct 2024', 'status' => 'Published', 'tone' => 'published'],
            ['title' => 'Best Time of Day for Calm Waters', 'excerpt' => 'Morning departures vs afternoon swells • 5 min read', 'image' => 'articles/badung-strait.png', 'category' => 'Boat Tips', 'author' => 'Capt. Wayan Sudira', 'role' => 'Master Mariner', 'initials' => 'WS', 'views' => '19.3K', 'date' => '12 Oct 2024', 'status' => 'Published', 'tone' => 'published'],
            ['title' => 'Kelingking T-Rex Cliff & Diamond', 'excerpt' => '1-day fastboat daytrip logistics • 7 min read', 'image' => 'articles/kelingking.png', 'category' => 'Travel Guides', 'author' => 'Ayu Pradnya', 'role' => 'Travel Concierge', 'initials' => 'AP', 'views' => '15.2K', 'date' => '05 Oct 2024', 'status' => 'Published', 'tone' => 'published'],
            ['title' => 'Balinese Cultural Etiquette: Visiting', 'excerpt' => 'Sarong attire, offerings, and sacred protocols • 3 min read', 'image' => 'articles/goa-giri-putri.png', 'category' => 'Culture', 'author' => 'Made Suweta', 'role' => 'Cultural Advisor', 'initials' => 'MS', 'views' => '9.8K', 'date' => '28 Sep 2024', 'status' => 'Published', 'tone' => 'published'],
        ];
    }
}
