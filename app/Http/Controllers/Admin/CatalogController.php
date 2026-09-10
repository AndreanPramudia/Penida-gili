<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminCatalog;
use App\Support\AdminDashboard;
use Illuminate\View\View;

/**
 * The six console listings — Figma nodes 1:6901, 1:9017, 1:9970, 1:9280,
 * 1:9637 and 1:10402. They share one Blade shell and differ only in data.
 */
class CatalogController extends Controller
{
    public function boats(): View
    {
        return view('admin.boats', ['boats' => AdminCatalog::boats()]);
    }

    public function schedules(): View
    {
        return view('admin.schedules', ['schedules' => AdminCatalog::schedules()]);
    }

    public function activities(): View
    {
        return view('admin.activities', ['activities' => AdminCatalog::activities()]);
    }

    public function hotels(): View
    {
        return view('admin.hotels', ['hotels' => AdminCatalog::hotels()]);
    }

    public function articles(): View
    {
        return view('admin.articles', ['articles' => AdminCatalog::articles()]);
    }

    public function report(): View
    {
        return view('admin.report', ['transactions' => AdminDashboard::transactions()]);
    }

    /**
     * Add New Boat — Figma node 1:7132.
     */
    public function createBoat(): View
    {
        return view('admin.boats-create', [
            'facilities' => [
                ['label' => 'Air Conditioning', 'checked' => true],
                ['label' => 'Toilet', 'checked' => true],
                ['label' => 'Life Jackets', 'checked' => true],
                ['label' => 'Insurance', 'checked' => true],
                ['label' => 'Sound System', 'checked' => false],
                ['label' => 'Free Water', 'checked' => false],
            ],
        ]);
    }

    /**
     * Add New Schedule — Figma node 1:7269.
     */
    public function createSchedule(): View
    {
        return view('admin.schedules-create', [
            'days' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        ]);
    }

    /**
     * Add New Activity — Figma node 1:8502.
     */
    public function createActivity(): View
    {
        return view('admin.activities-create', [
            'days' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'included' => ['Traditional Balinese Attire', 'Makeup & Hair Styling', 'Local Accessories', 'Village Entrance Ticket'],
            'excluded' => ['Transportation to location', 'Personal expenses', 'Food & drinks'],
            'gallery' => [
                'activities/detail/costume-main.png',
                'activities/detail/family-dress.png',
                'activities/detail/village-street.png',
            ],
            'statuses' => [
                ['label' => 'Active / Published', 'description' => 'Visible & bookable immediately', 'checked' => true],
                ['label' => 'Draft', 'description' => 'Save work without releasing'],
                ['label' => 'Scheduled', 'description' => 'Go live at specific timestamp'],
            ],
        ]);
    }

    /**
     * Add New Hotel — Figma node 1:7501.
     */
    public function createHotel(): View
    {
        return view('admin.hotels-create', [
            'rooms' => [
                [
                    'name' => 'Deluxe Ocean Room',
                    'badge' => 'Available',
                    'tone' => 'available',
                    'stats' => [
                        ['label' => 'Capacity & Bed', 'value' => '2 Guests, 1 King Bed'],
                        ['label' => 'Room Size', 'value' => '45 m2 Ocean Terrace'],
                        ['label' => 'Base Price / Night', 'value' => 'IDR 2.500.000', 'accent' => true],
                        ['label' => 'Inventory Allotment', 'value' => '8 Units Left', 'accent' => true],
                    ],
                ],
                [
                    'name' => 'Private Pool Villa',
                    'badge' => 'High Demand',
                    'tone' => 'demand',
                    'stats' => [
                        ['label' => 'Capacity & Bed', 'value' => '2 Guests, 1 King Bed'],
                        ['label' => 'Room Size', 'value' => '120 m2 Private Oasis'],
                        ['label' => 'Base Price / Night', 'value' => 'IDR 5.800.000', 'accent' => true],
                        ['label' => 'Inventory Allotment', 'value' => '4 Units Left', 'accent' => true],
                    ],
                ],
            ],
            'amenities' => [
                ['label' => 'Free High-Speed Wi-Fi', 'note' => 'Starlink Mesh', 'icon' => 'hotel/wifi.svg'],
                ['label' => 'Oceanfront Infinity Pool', 'note' => 'Panoramic view', 'icon' => 'hotel/pool.svg'],
                ['label' => 'Full-Service Spa', 'note' => 'Balinese therapy', 'icon' => 'hotel/spa.svg'],
                ['label' => 'Sunset Cliff Bar', 'note' => 'Signature cocktails', 'icon' => 'hotel/bar.svg'],
                ['label' => 'Oceanfront Restaurant', 'note' => 'Fresh seafood dining', 'icon' => 'hotel/restaurant.svg'],
                ['label' => '24/7 Butler Service', 'note' => 'VIP guest assistance', 'icon' => 'detail/support.svg'],
                ['label' => 'Airport/Harbor Shuttle', 'note' => 'Included for boats', 'icon' => 'admin/nav-boat.svg'],
                ['label' => 'Air Conditioning', 'note' => 'Climate controlled', 'icon' => 'vessel/air-conditioning.svg'],
            ],
            'gallery' => [
                ['image' => 'hotels/detail/pool-main.png', 'label' => 'Cliffside Infinity Pool'],
                ['image' => 'hotels/detail/bedroom.png', 'label' => 'Ocean Deluxe Bedroom'],
                ['image' => 'hotels/detail/sunset-dining.png', 'label' => 'Cliff Restaurant & Lounge'],
                ['image' => 'hotels/detail/suite.png', 'label' => 'Lotus Botanical Spa'],
            ],
            'listingStatuses' => [
                ['label' => 'Active (Visible to island travelers)', 'description' => 'Bookable across every channel', 'checked' => true],
                ['label' => 'In Review (Pending harbor audit)', 'description' => 'Awaiting partner verification'],
                ['label' => 'Inactive (Hidden from booking engine)', 'description' => 'Retained but not listed'],
            ],
        ]);
    }

    /**
     * Add New Article — Figma node 1:8059 (the frame is labelled "add activity"
     * there, but its content and highlighted sidebar item are the article editor).
     */
    public function createArticle(): View
    {
        return view('admin.articles-create', [
            'toolbarGroups' => [
                [
                    ['label' => 'Heading 2', 'glyph' => 'H2'],
                    ['label' => 'Heading 3', 'glyph' => 'H3'],
                ],
                [
                    ['label' => 'Bold', 'glyph' => '<strong>B</strong>'],
                    ['label' => 'Italic', 'glyph' => '<em>I</em>'],
                    ['label' => 'Link', 'glyph' => '&#128279;'],
                ],
                [
                    ['label' => 'Bulleted list', 'glyph' => '&bull;&mdash;'],
                    ['label' => 'Numbered list', 'glyph' => '1.'],
                    ['label' => 'Quote', 'glyph' => '&ldquo;'],
                ],
                [
                    ['label' => 'Insert image', 'glyph' => '&#9635;'],
                    ['label' => 'Insert table', 'glyph' => '&#9638;'],
                    ['label' => 'Code block', 'glyph' => '&lt;/&gt;'],
                ],
            ],
            'body' => "The Badung Strait has long held legendary status among Indonesian seafarers. Today, crossing from Bali's mainland to the dramatic sheer sea cliffs of Nusa Penida is an exhilarating, 35-minute hop aboard modern multi-engine fast catamarans. Yet navigating the harbor choices, tide variations, and baggage allowances requires insider knowledge to ensure a hassle-free island holiday.

01  Departure Ports: Sanur vs Kusamba vs Padang Bai

Depending on your initial lodging location in Bali, choosing the appropriate terminal harbor drastically reduces overall transit friction.

02  Luggage Policies & Boarding Tips

Unlike conventional aviation carriers, maritime baggage stowage allows 25 kg complimentary hold luggage. Sanjaya Express vessels provide enclosed, waterproof hull compartments for luggage safety against ocean spray.",
            'publishModes' => [
                ['label' => 'Publish Immediately', 'description' => 'Live to all passenger channels right away', 'checked' => true],
                ['label' => 'Schedule for Later', 'description' => 'Automated release at designated time'],
                ['label' => 'Save as Draft', 'description' => 'Internal review without public URL'],
            ],
            'tags' => ['#NusaPenida', '#FastBoatBali', '#SanurPort', '#TravelGuide', '#SnorkelingTips'],
        ]);
    }
}