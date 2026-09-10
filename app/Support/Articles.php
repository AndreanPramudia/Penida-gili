<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Placeholder catalogue — swap for an Eloquent model once the DB is in place.
 */
class Articles
{
    /**
     * The single article promoted above the grid.
     *
     * @return array<string, string>
     */
    public static function featured(): array
    {
        return [
            'category' => 'Fast Boat Transfers',
            'readTime' => '5 Min Read',
            'date' => 'Oct 24, 2024',
            'title' => 'Complete Guide to Nusa Penida Fast Boat Transfers: Schedules, Ports, and Travel Tips',
            'excerpt' => 'Everything you need to know before sailing from Sanur to Banjar Nyuh port, best departure hours, luggage policies, and essential safety protocols.',
            'author' => 'Captain Wayan Sudira',
            'authorRole' => 'Marine Operations Lead',
            'image' => asset('images/articles/featured-fastboat.png'),
            'href' => route('articles.show', 'complete-guide-to-nusa-penida-fast-boat-transfers'),
        ];
    }

    /**
     * @return Collection<int, array<string, string>>
     */
    public static function all(): Collection
    {
        $catalogue = [
            [
                'category' => 'Activities',
                'readTime' => '4 min read',
                'date' => 'Oct 21, 2024',
                'title' => 'Top 7 Unmissable Snorkeling Spots around Nusa Penida & Gili Meno',
                'excerpt' => 'Discover secluded bays, crystal clarity reefs, and resident sea turtle sanctuaries accessible',
                'author' => 'Dewa Krisna',
                'image' => 'snorkeling.png',
            ],
            [
                'category' => 'Boat Tips',
                'readTime' => '6 min read',
                'date' => 'Oct 18, 2024',
                'title' => 'Best Time of Day for Calm Waters: Crossing the Badung Strait Comfortably',
                'excerpt' => 'Learn how tides and morning winds impact nautical comfort, plus recommendations for',
                'author' => 'Capt. Wayan Sudira',
                'image' => 'badung-strait.png',
            ],
            [
                'category' => 'Travel Guides',
                'readTime' => '5 min read',
                'date' => 'Oct 15, 2024',
                'title' => 'Kelingking T-Rex Cliff & Diamond Beach: How to Plan Your Day Trip',
                'excerpt' => 'Timing your arrival right after the morning fast boat docking to beat inland tourist crowds and',
                'author' => 'Ayu Pradnya',
                'image' => 'kelingking.png',
            ],
            [
                'category' => 'Boat Tips',
                'readTime' => '7 min read',
                'date' => 'Oct 13, 2024',
                'title' => 'Choosing Between Fast Ferry vs Speedboat: Comfort, Speed & Price Comparison',
                'excerpt' => 'An objective breakdown comparing multi-engine aluminium hulls with traditional',
                'author' => 'Putu Ardhana',
                'image' => 'ferry-vs-speedboat.png',
            ],
            [
                'category' => 'Travel Guides',
                'readTime' => '4 min read',
                'date' => 'Oct 09, 2024',
                'title' => 'What to Pack for an Island Getaway to Nusa Lembongan and Ceningan',
                'excerpt' => 'Essential footwear, waterproof gear, cash logistics, and light luggage practices for wet',
                'author' => 'Sarah Jenkins',
                'image' => 'lembongan-packing.png',
            ],
            [
                'category' => 'Culture',
                'readTime' => '5 min read',
                'date' => 'Oct 04, 2024',
                'title' => 'Balinese Cultural Etiquette: Visiting Pura Goa Giri Putri and Sacred Temples',
                'excerpt' => 'Respectful customs, required temple sarongs, purification rituals, and cave access protocols',
                'author' => 'Made Suwerta',
                'image' => 'goa-giri-putri.png',
            ],
        ];

        // The design reports 48 articles across 8 pages; repeat the sample set to match.
        return collect(array_merge(...array_fill(0, 8, $catalogue)));
    }
}
