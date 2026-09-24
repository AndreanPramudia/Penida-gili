<?php

namespace Tests\Feature\Admin;

use App\Enums\ArticleStatus;
use App\Enums\BookingStatus;
use App\Enums\ListingStatus;
use App\Models\Activity;
use App\Models\Article;
use App\Models\Author;
use App\Models\BoatOperator;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\Port;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Vessel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CatalogManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_boat_form_shows_publishing_settings_and_draft_overrides_operational_status(): void
    {
        $operator = BoatOperator::factory()->create();

        $this->actingAs($this->admin)->get(route('admin.boats.create'))
            ->assertOk()
            ->assertSeeInOrder(['Publishing Settings', 'Publish Immediately', 'Save as Draft', 'Boat Details', 'Initial Status', 'Boat Photos', 'Boat Facilities'])
            ->assertDontSee('Top Speed')
            ->assertDontSee('Vessel Code')
            ->assertDontSee('Last Inspection Date')
            ->assertDontSee('name="boat_operator_id"', false);

        // No operator field on the form: the vessel is attached to the operator on file.
        $base = ['name' => 'Sanjaya Explorer', 'type' => 'Luxury Catamaran', 'capacity' => 120];

        $this->actingAs($this->admin)->post(route('admin.boats.store'), $base + ['publish' => 'draft', 'status' => ListingStatus::Active->value])
            ->assertRedirect(route('admin.boats'));
        $this->assertSame(ListingStatus::Draft, Vessel::query()->sole()->status);
        $this->assertSame($operator->id, Vessel::query()->sole()->boat_operator_id);

        Vessel::query()->delete();

        $this->actingAs($this->admin)->post(route('admin.boats.store'), $base + ['publish' => 'publish', 'status' => ListingStatus::Inactive->value])
            ->assertRedirect(route('admin.boats'));
        $this->assertSame(ListingStatus::Inactive, Vessel::query()->sole()->status);

        $this->actingAs($this->admin)->get(route('admin.boats.edit', Vessel::query()->sole()))
            ->assertOk()
            ->assertSee('Non-Active (Maintenance)');
    }

    public function test_admin_can_create_edit_and_delete_a_vessel(): void
    {
        Storage::fake('public');
        $operator = BoatOperator::factory()->create();

        $this->actingAs($this->admin)->get(route('admin.boats.create'))->assertOk();

        $this->actingAs($this->admin)->post(route('admin.boats.store'), [
            'boat_operator_id' => $operator->id,
            'name' => 'Sanjaya Ocean Queen',
            'type' => 'Catamaran Fast Ferry',
            'capacity' => 150,
            'status' => ListingStatus::Active->value,
            'facilities' => ['Toilet', 'Life Jackets'],
            'photos' => [UploadedFile::fake()->image('queen.jpg')],
        ])->assertRedirect(route('admin.boats'));

        $vessel = Vessel::query()->sole();
        $this->assertSame('SFB-001', $vessel->code);
        $this->assertSame(['Toilet', 'Life Jackets'], $vessel->facilities);
        Storage::disk('public')->assertExists($vessel->image);
        $this->actingAs($this->admin)->get(route('admin.boats.edit', $vessel))->assertOk()->assertSee('Sanjaya Ocean Queen');

        $this->actingAs($this->admin)->put(route('admin.boats.update', $vessel), [
            'boat_operator_id' => $operator->id,
            'name' => 'Sanjaya Ocean Queen II',
            'type' => 'Luxury Catamaran',
            'capacity' => 120,
            'status' => ListingStatus::Inactive->value,
        ])->assertRedirect(route('admin.boats'));

        $this->assertSame(ListingStatus::Inactive, $vessel->fresh()->status);
        $this->assertSame('Sanjaya Ocean Queen II', $vessel->fresh()->name);

        $this->actingAs($this->admin)->delete(route('admin.boats.destroy', $vessel))->assertRedirect(route('admin.boats'));
        $this->assertModelMissing($vessel);
    }

    public function test_vessel_listing_filters_by_status_and_search(): void
    {
        Vessel::factory()->create(['name' => 'Alpha Express', 'status' => ListingStatus::Active]);
        Vessel::factory()->create(['name' => 'Beta Voyager', 'status' => ListingStatus::Inactive]);

        $this->actingAs($this->admin)->get(route('admin.boats', ['status' => 'inactive']))
            ->assertOk()->assertSee('Beta Voyager')->assertDontSee('Alpha Express');

        $this->actingAs($this->admin)->get(route('admin.boats', ['q' => 'alpha']))
            ->assertOk()->assertSee('Alpha Express')->assertDontSee('Beta Voyager');
    }

    public function test_schedule_listing_filters_by_route_boat_and_date(): void
    {
        $sanur = Port::factory()->create(['name' => 'Sanur Beach Port', 'area' => 'Bali']);
        $penida = Port::factory()->create(['name' => 'Banjar Nyuh Nusa Penida', 'area' => 'Nusa Penida']);
        $gili = Port::factory()->create(['name' => 'Gili Trawangan', 'area' => 'Lombok']);
        $queen = Vessel::factory()->create(['name' => 'Sanjaya Ocean Queen']);
        $explorer = Vessel::factory()->create(['name' => 'Sanjaya Explorer']);

        $daily = Schedule::factory()->create(['from_port_id' => $sanur->id, 'to_port_id' => $penida->id, 'vessel_id' => $queen->id, 'days' => null, 'departure_time' => '08:00']);
        $weekend = Schedule::factory()->create(['from_port_id' => $sanur->id, 'to_port_id' => $gili->id, 'vessel_id' => $explorer->id, 'days' => ['Sat', 'Sun'], 'departure_time' => '10:00']);

        $this->actingAs($this->admin)->get(route('admin.schedules'))
            ->assertOk()
            ->assertSeeInOrder(['Search Route', 'Boat', 'Date', 'Filter'])
            ->assertDontSee('All Statuses');

        $this->actingAs($this->admin)->get(route('admin.schedules', ['q' => 'Sanur to Nusa Penida']))
            ->assertSee('Banjar Nyuh Nusa Penida')->assertDontSee('Gili Trawangan');

        $this->actingAs($this->admin)->get(route('admin.schedules', ['q' => 'Gili']))
            ->assertSee('Gili Trawangan')->assertDontSee('Banjar Nyuh Nusa Penida');

        $this->actingAs($this->admin)->get(route('admin.schedules', ['vessel' => $explorer->id]))
            ->assertSee('Gili Trawangan')->assertDontSee('Banjar Nyuh Nusa Penida');

        // 2030-05-08 is a Wednesday: only the daily run operates; the weekend run appears on the Saturday.
        $this->actingAs($this->admin)->get(route('admin.schedules', ['date' => '2030-05-08']))
            ->assertSee('Banjar Nyuh Nusa Penida')->assertDontSee('Gili Trawangan');
        $this->actingAs($this->admin)->get(route('admin.schedules', ['date' => '2030-05-11']))
            ->assertSee('Gili Trawangan');
    }

    public function test_schedule_form_matches_figma_and_derives_ports_operator_and_status(): void
    {
        $operator = BoatOperator::factory()->create();
        $vessel = Vessel::factory()->for($operator, 'operator')->create(['name' => 'Sanjaya Explorer I', 'capacity' => 60]);
        [$from, $to] = Port::factory()->count(2)->create();

        $this->actingAs($this->admin)->get(route('admin.schedules.create'))
            ->assertOk()
            ->assertSeeInOrder([
                'Schedule Details', 'Route Segment', 'Select an established route...', 'Assigned Vessel', 'Departure Time', 'Est. Arrival Time',
                'Operating Days (Frequency)', 'Pricing Configuration', 'Base Price (Local Pax)', 'Base Price (Foreign Pax)', 'Child Price',
                'Publishing Settings', 'Publish Immediately', 'Save as Draft', 'High Season Alert', 'View Analytics',
                'Schedule Summary', 'Total Capacity', 'Est. Duration', 'Publish Schedule', 'Cancel',
            ])
            ->assertDontSee('Departure Port')
            ->assertDontSee('name="boat_operator_id"', false);

        $this->actingAs($this->admin)->post(route('admin.schedules.store'), [
            'route' => $from->id.'-'.$to->id,
            'vessel_id' => $vessel->id,
            'departure_time' => '08:00',
            'arrival_time' => '08:45',
            'price_adult' => 100000,
            'price_foreign' => 150000,
            'price_child' => 75000,
            'days' => ['Mon', 'Wed'],
            'publish' => 'draft',
        ])->assertRedirect(route('admin.schedules'));

        $schedule = Schedule::query()->sole();
        $this->assertSame($from->id, $schedule->from_port_id);
        $this->assertSame($to->id, $schedule->to_port_id);
        $this->assertSame($operator->id, $schedule->boat_operator_id);
        $this->assertSame(ListingStatus::Draft, $schedule->status);
        $this->assertSame(['Mon', 'Wed'], $schedule->days);

        $this->actingAs($this->admin)->get(route('admin.schedules.edit', $schedule))
            ->assertOk()
            ->assertSee('60 pax')
            ->assertSee('45 mins');
    }

    public function test_schedule_requires_distinct_ports_and_ordered_times(): void
    {
        $operator = BoatOperator::factory()->create();
        $port = Port::factory()->create();

        $this->actingAs($this->admin)->post(route('admin.schedules.store'), [
            'boat_operator_id' => $operator->id,
            'from_port_id' => $port->id,
            'to_port_id' => $port->id,
            'departure_time' => '09:00',
            'arrival_time' => '08:00',
            'price_adult' => 100000,
            'price_child' => 75000,
            'status' => 'active',
        ])->assertSessionHasErrors(['to_port_id', 'arrival_time']);

        $this->assertDatabaseCount('schedules', 0);
    }

    public function test_schedule_with_every_day_selected_is_stored_as_daily(): void
    {
        $operator = BoatOperator::factory()->create();
        $vessel = Vessel::factory()->for($operator, 'operator')->create();
        [$from, $to] = Port::factory()->count(2)->create();

        $this->actingAs($this->admin)->post(route('admin.schedules.store'), [
            'boat_operator_id' => $operator->id,
            'vessel_id' => $vessel->id,
            'from_port_id' => $from->id,
            'to_port_id' => $to->id,
            'departure_time' => '08:00',
            'arrival_time' => '08:45',
            'price_adult' => 100000,
            'price_child' => 75000,
            'days' => Schedule::DAYS,
            'status' => 'active',
        ])->assertRedirect(route('admin.schedules'));

        $this->assertNull(Schedule::query()->sole()->days);
    }

    public function test_admin_can_create_an_activity_with_formatted_prices(): void
    {
        $this->actingAs($this->admin)->post(route('admin.activities.store'), [
            'name' => 'Kecak Fire Dance',
            'category' => 'Cultural Show',
            'description' => 'Sunset chant on the Uluwatu cliff.',
            'place_label' => 'South Bali',
            'location' => 'Uluwatu Temple, Badung',
            'opens_at' => '17:45',
            'closes_at' => '19:00',
            'price_adult' => '180.000',
            'price_was' => 'Rp 250.000',
            'included' => "Entrance ticket\nSeat reservation",
            'max_daily_capacity' => '50',
            'status' => 'active',
        ])->assertRedirect(route('admin.activities'));

        $activity = Activity::query()->sole();
        $this->assertSame(180_000, $activity->price_adult);
        $this->assertSame(250_000, $activity->price_was);
        $this->assertSame(['Entrance ticket', 'Seat reservation'], $activity->included);
        $this->assertSame('kecak-fire-dance', $activity->slug);
    }

    public function test_activity_editor_follows_figma_and_stores_the_new_fields(): void
    {
        $this->actingAs($this->admin)->get(route('admin.activities.create'))
            ->assertOk()
            ->assertSeeInOrder([
                'Save Draft', 'Publish Activity',
                'Basic Information', 'Short Catchy Tagline / Badge', 'Full Description',
                'Schedule & Operational Hours', 'Select All Days', 'Instant Confirmation', 'Cancellation Policy',
                'Experience Highlights & Inclusions', '+ Add inclusion...', '+ Add exclusion...', 'Important Notes',
                'Media & Gallery Upload', '/ 8 Photos', 'Hero Featured Cover',
                'Publishing Status', 'Public Visibility',
                'Pricing & Quota Capacity', 'Original / Strikethrough Price', 'Domestic vs Foreign Price', 'Max Daily Capacity / Quota', 'pax / day',
            ])
            ->assertDontSee('Location Details');

        // Chips arrive comma separated; the header "Save Draft" button overrides the radio;
        // "Scheduled" keeps the draft with a go-live timestamp.
        $this->actingAs($this->admin)->post(route('admin.activities.store'), [
            'name' => 'Manta Point Snorkel',
            'category' => 'Water Sports',
            'description' => "Swim with mantas.\nBoat departs at dawn.",
            'price_adult' => '350.000',
            'dual_pricing' => 'on',
            'max_daily_capacity' => '24',
            'included' => 'Snorkel gear, Lunch box',
            'excluded' => 'Hotel transfer',
            'instant_confirmation' => 'on',
            'cancellation_policy' => 'free_48h',
            'important_notes' => 'Bring reef-safe sunscreen.',
            'status' => 'scheduled',
            'publish_at' => '2026-10-01 08:00',
            'is_public' => 'on',
        ])->assertSessionHasNoErrors()->assertRedirect(route('admin.activities'));

        $activity = Activity::query()->sole();
        $this->assertSame(ListingStatus::Draft, $activity->status);
        $this->assertSame('2026-10-01 08:00', $activity->publish_at->format('Y-m-d H:i'));
        $this->assertSame(['Snorkel gear', 'Lunch box'], $activity->included);
        $this->assertSame(['Hotel transfer'], $activity->excluded);
        $this->assertTrue($activity->dual_pricing);
        $this->assertSame(24, $activity->max_daily_capacity);
        $this->assertTrue($activity->is_public);
        $this->assertSame('free_48h', $activity->cancellation_policy);
        $this->assertSame('Swim with mantas.', $activity->intro);

        // Publish Activity wins over the radios and clears the schedule; foreign price is dropped when single-tier.
        $this->actingAs($this->admin)->put(route('admin.activities.update', $activity), [
            'name' => 'Manta Point Snorkel',
            'category' => 'Water Sports',
            'description' => 'Swim with mantas.',
            'price_adult' => '350.000',
            'max_daily_capacity' => '24',
            'status' => 'draft',
            'submit_as' => 'publish',
        ])->assertSessionHasNoErrors();

        $activity->refresh();
        $this->assertSame(ListingStatus::Active, $activity->status);
        $this->assertNull($activity->publish_at);
        $this->assertFalse($activity->dual_pricing);
        $this->assertNull($activity->price_foreign);

        $this->actingAs($this->admin)->post(route('admin.activities.store'), [
            'name' => 'No quota', 'category' => 'Adventure', 'description' => 'x', 'price_adult' => '1', 'status' => 'active',
        ])->assertSessionHasErrors('max_daily_capacity');
    }

    public function test_activity_toolbar_filters_by_search_category_status_and_sort(): void
    {
        Activity::factory()->create(['name' => 'Kecak Dance', 'category' => 'Cultural Show', 'location' => 'Uluwatu', 'status' => ListingStatus::Active, 'sold_count' => 10, 'rating' => 4.9]);
        Activity::factory()->create(['name' => 'Manta Snorkel', 'category' => 'Water Sports', 'location' => 'Manta Bay', 'status' => ListingStatus::Draft, 'sold_count' => 500, 'rating' => 4.1]);

        $this->actingAs($this->admin)->get(route('admin.activities'))
            ->assertOk()
            ->assertSee('Search by title, location or vendor...')
            ->assertSeeInOrder(['All Categories', 'Status: All', 'Most Booked', 'Reset filters'])
            ->assertSeeInOrder(['Manta Snorkel', 'Kecak Dance']);

        $this->actingAs($this->admin)->get(route('admin.activities', ['q' => 'manta bay']))
            ->assertSee('Manta Snorkel')->assertDontSee('Kecak Dance');

        $this->actingAs($this->admin)->get(route('admin.activities', ['category' => 'Cultural Show']))
            ->assertSee('Kecak Dance')->assertDontSee('Manta Snorkel');

        $this->actingAs($this->admin)->get(route('admin.activities', ['status' => 'draft']))
            ->assertSee('Manta Snorkel')->assertDontSee('Kecak Dance');

        $this->actingAs($this->admin)->get(route('admin.activities', ['sort' => 'top_rated']))
            ->assertSeeInOrder(['Kecak Dance', 'Manta Snorkel']);
    }

    public function test_activity_listing_shows_figma_columns_and_duplicates_as_a_draft(): void
    {
        $activity = Activity::factory()->create([
            'name' => 'Kecak Fire Dance', 'category' => 'Cultural Show', 'location' => 'Uluwatu, Badung',
            'price_adult' => 180_000, 'price_was' => 250_000, 'sold_count' => 520, 'status' => ListingStatus::Active,
        ]);

        $this->actingAs($this->admin)->get(route('admin.activities'))
            ->assertOk()
            ->assertSeeInOrder(['Activity Details', 'Category', 'Location', 'Price / Pax', 'Status', 'Total Sold', 'Actions'])
            ->assertSee('cat-cultural-show.svg')
            ->assertSee('IDR 180.000')
            ->assertSee('Rp. 250.000')
            ->assertSee('520')
            ->assertSee(route('admin.activities.duplicate', $activity));

        $this->actingAs($this->admin)->post(route('admin.activities.duplicate', $activity))
            ->assertRedirect();

        $copy = Activity::query()->where('id', '!=', $activity->id)->sole();
        $this->assertSame('Kecak Fire Dance (Copy)', $copy->name);
        $this->assertSame(ListingStatus::Draft, $copy->status);
        $this->assertSame(0, $copy->sold_count);
        $this->assertNotSame($activity->slug, $copy->slug);
        $this->assertSame(180_000, $copy->price_adult);
    }

    public function test_admin_can_create_a_hotel_with_rooms_and_sync_them_on_update(): void
    {
        $payload = [
            'name' => 'Cliff Edge Resort',
            'category' => 'Resort',
            'stars' => 5,
            'description' => 'Perched on the cliffs.',
            'address' => 'Nusa Penida, Bali',
            'status' => 'active',
            'amenities' => ['Oceanfront Infinity Pool'],
            'rooms' => [
                ['name' => 'Deluxe', 'guests' => 2, 'bed' => '1 King Bed', 'price_per_night' => '2.500.000', 'stock' => 4],
                ['name' => 'Villa', 'guests' => 2, 'bed' => '1 King Bed', 'price_per_night' => '5.800.000', 'stock' => 2],
                ['name' => '', 'guests' => 2, 'price_per_night' => '', 'stock' => 1],
            ],
        ];

        $this->actingAs($this->admin)->post(route('admin.hotels.store'), $payload)->assertRedirect(route('admin.hotels'));

        $hotel = Hotel::query()->sole();
        $this->assertCount(2, $hotel->rooms);
        $this->assertSame(2_500_000, $hotel->price_from);
        $this->assertSame('Oceanfront Infinity Pool', $hotel->amenities[0]['label']);

        $deluxe = $hotel->rooms->firstWhere('name', 'Deluxe');
        $villa = $hotel->rooms->firstWhere('name', 'Villa');

        $this->actingAs($this->admin)->put(route('admin.hotels.update', $hotel), array_merge($payload, ['rooms' => [
            ['id' => $deluxe->id, 'name' => 'Deluxe Ocean', 'guests' => 3, 'price_per_night' => '2.700.000', 'stock' => 4],
        ]]))->assertRedirect(route('admin.hotels'));

        $this->assertSame('Deluxe Ocean', $deluxe->fresh()->name);
        $this->assertModelMissing($villa);
    }

    public function test_hotel_editor_follows_figma_and_stores_partner_fields(): void
    {
        $this->actingAs($this->admin)->get(route('admin.hotels.create'))
            ->assertOk()
            ->assertSeeInOrder([
                'Save Draft', 'Publish Hotel Listing',
                'Property Overview', 'Property Name', 'Accommodation Type', 'Star Rating', 'Property Description',
                'Room Categories & Inventory Manager', 'Categories Active', '+ Add Another Room Category',
                'Premium Hotel Amenities', 'Starlink Mesh', '24/7 Butler Service', 'Air Conditioning',
                'Photo Gallery & Room Images', 'images uploaded', 'Browse Files', 'Featured Hero',
                'Publishing Settings', 'Publish Immediately', 'Save as Draft',
                'Location & Harbor Proximity', 'Island / Region', 'Specific Coastal Area', 'Harbor Transfer Distance', 'Map Pin Coordinates',
            ])
            ->assertDontSee('Fastboat Transfer Bundle')
            ->assertDontSee('Partner Commission Rate');

        $payload = [
            'name' => 'Toya Pakeh Cliff Resort',
            'category' => 'Luxury Resort',
            'stars' => 5,
            'description' => 'Cliffside sanctuary.',
            'region' => 'Nusa Penida',
            'address' => 'Toya Pakeh, Crystal Bay Road',
            'harbor_distance' => '8 minutes from Banjar Nyuh Harbor',
            'coordinates' => '-8.6792° S, 115.4851° E',
            'publish' => 'draft',
            'rooms' => [['name' => 'Deluxe', 'guests' => 2, 'price_per_night' => '2.500.000', 'stock' => 8]],
        ];

        $this->actingAs($this->admin)->post(route('admin.hotels.store'), $payload)
            ->assertSessionHasNoErrors()->assertRedirect(route('admin.hotels'));

        $hotel = Hotel::query()->sole();
        // "Save as Draft" parks the listing in review.
        $this->assertSame(ListingStatus::Draft, $hotel->status);
        $this->assertSame('Nusa Penida', $hotel->region);
        $this->assertSame('8 minutes from Banjar Nyuh Harbor', $hotel->harbor_distance);
        $this->assertSame('-8.6792° S, 115.4851° E', $hotel->coordinates);

        $this->actingAs($this->admin)->get(route('admin.hotels.edit', $hotel))
            ->assertOk()
            ->assertSee('Toya Pakeh Cliff Resort')
            ->assertSee('8 Units Left')
            ->assertSee('IDR 2.500.000');

        // "Publish Immediately" (or the header button) flips it live.
        $this->actingAs($this->admin)->put(route('admin.hotels.update', $hotel), ['publish' => 'publish'] + $payload)->assertSessionHasNoErrors();
        $this->assertSame(ListingStatus::Active, $hotel->fresh()->status);
    }

    public function test_hotel_requires_at_least_one_room(): void
    {
        $this->actingAs($this->admin)->post(route('admin.hotels.store'), [
            'name' => 'Empty Inn', 'category' => 'Hotel', 'stars' => 3, 'description' => 'x', 'address' => 'y', 'status' => 'active',
            'rooms' => [['name' => '', 'price_per_night' => '']],
        ])->assertSessionHasErrors('rooms');

        $this->assertDatabaseCount('hotels', 0);
    }

    public function test_room_capacity_cannot_exceed_the_online_booking_cap(): void
    {
        $this->actingAs($this->admin)->post(route('admin.hotels.store'), [
            'name' => 'Big Rooms Inn', 'category' => 'Hotel', 'stars' => 3, 'description' => 'x', 'address' => 'y', 'status' => 'active',
            'rooms' => [['name' => 'Family', 'guests' => 6, 'bed' => '2 Queen Beds', 'price_per_night' => '1.000.000', 'stock' => 1]],
        ])->assertSessionHasErrors('rooms.0.guests');

        $this->assertDatabaseCount('hotels', 0);
    }

    public function test_article_listing_matches_figma_and_filters_by_author_category_and_status(): void
    {
        Article::factory()->create(['title' => 'Complete Guide to Nusa Penida', 'category' => 'Travel Guides', 'author_name' => 'Capt. Wayan Sudira', 'author_role' => 'Master Mariner', 'views' => 42_500, 'status' => ArticleStatus::Published]);
        Article::factory()->create(['title' => 'Top 7 Snorkeling Spots', 'category' => 'Activities', 'author_name' => 'Dewa Krisna', 'views' => 980, 'status' => ArticleStatus::Draft]);

        $this->actingAs($this->admin)->get(route('admin.articles'))
            ->assertOk()
            ->assertSeeInOrder(['Search by title, keyword, or author...', 'Author:', 'All Authors', 'Category:', 'All Categories', 'Status:', 'All Statuses', 'Active Filters:', 'Category: All', 'Clear all'])
            ->assertSeeInOrder(['Article Details', 'Category', 'Author & Role', 'Views', 'Published Date', 'Status', 'Quick Actions'])
            ->assertSee('42.5K')->assertSee('Master Mariner');

        $this->actingAs($this->admin)->get(route('admin.articles', ['author' => 'Dewa Krisna']))
            ->assertSee('Top 7 Snorkeling Spots')->assertDontSee('Complete Guide to Nusa Penida');

        $this->actingAs($this->admin)->get(route('admin.articles', ['category' => 'Travel Guides']))
            ->assertSee('Complete Guide to Nusa Penida')->assertDontSee('Top 7 Snorkeling Spots');

        $this->actingAs($this->admin)->get(route('admin.articles', ['status' => 'draft']))
            ->assertSee('Top 7 Snorkeling Spots')->assertDontSee('Complete Guide to Nusa Penida')
            ->assertSee('Status: Draft');
    }

    public function test_article_scheduling_requires_a_date_and_drafts_stay_unpublished(): void
    {
        $base = ['title' => 'Crossing Tips', 'excerpt' => 'Short', 'category' => 'Boat Tips', 'body' => str_repeat('word ', 400), 'author_name' => 'Capt. Wayan'];

        $this->actingAs($this->admin)->post(route('admin.articles.store'), $base + ['status' => 'scheduled'])
            ->assertSessionHasErrors('published_at');

        $this->actingAs($this->admin)->post(route('admin.articles.store'), $base + ['status' => 'draft', 'tags' => 'nusapenida, #tips'])
            ->assertRedirect(route('admin.articles'));

        $article = Article::query()->sole();
        $this->assertSame(ArticleStatus::Draft, $article->status);
        $this->assertNull($article->published_at);
        $this->assertSame(['#nusapenida', '#tips'], $article->tags);
        $this->assertSame(2, $article->read_time_minutes);
    }

    public function test_article_form_renders_and_stores_seo_fields_with_fallbacks(): void
    {
        // Figma 1:8059: editorial card, formatting toolbar, hero image, and the sidebar cards incl. the author form.
        $this->actingAs($this->admin)->get(route('admin.articles.create'))
            ->assertOk()
            ->assertSeeInOrder([
                'Save Draft', 'Publish Article',
                'Article Core Editorial', 'min read', 'Article Title', 'Subtitle / Summary Hook', 'Primary Category', 'Target Reader Segment', 'Author', '+ Add new author…',
                'H2', 'H3', 'Word Count:',
                'Featured Hero Image', 'Replace Photo', 'Image Caption', 'Descriptive Alt Text (Accessibility & SEO)',
                'Publishing Settings', 'Publish Immediately', 'Save as Draft',

                'SEO Optimization', 'Score:', 'URL Permalink Slug', 'Meta Title', '/60 chars', 'Meta Description', '/160 chars', 'Live Google SERP Preview',
                'Tags & Taxonomy', 'Type tag and hit Enter...',
            ])
            ->assertDontSee('Schedule for Later')
            ->assertDontSee('Contextual Fast Ticket Desk')
            ->assertDontSee('Keywords');

        $base = ['title' => 'Crossing Tips', 'excerpt' => 'Short summary', 'category' => 'Boat Tips', 'body' => 'Body text', 'author_id' => 'new', 'author_name' => 'Capt. Wayan', 'status' => 'published'];

        $this->actingAs($this->admin)->post(route('admin.articles.store'), $base + [
            'meta_title' => 'Crossing Tips | Penida Gili',
            'meta_description' => 'Everything about the crossing.',
            'meta_keywords' => 'nusa penida, fast boat, , fast boat',
            'author_role' => 'Master Mariner',
            'reader_segment' => 'First-time Island Travelers',
            'hero_alt' => 'Fast boat at sea',
            'submit_as' => 'draft',
        ])->assertSessionHasNoErrors()->assertRedirect(route('admin.articles'));

        $article = Article::query()->sole();
        $this->assertSame(['nusa penida', 'fast boat'], $article->meta_keywords);
        $this->assertSame('Crossing Tips | Penida Gili', $article->seo_title);
        $this->assertSame('Master Mariner', $article->author_role);
        $this->assertSame('First-time Island Travelers', $article->reader_segment);
        $this->assertSame('Fast boat at sea', $article->hero_alt);
        // The header "Save Draft" button beats the Publish Immediately radio.
        $this->assertSame(ArticleStatus::Draft, $article->status);

        $author = Author::query()->sole();
        $this->assertSame($author->id, $article->author_id);
        $this->actingAs($this->admin)->get(route('admin.articles.edit', $article))->assertOk()->assertSee('Capt. Wayan - Master Mariner');

        // Picking an existing author from the bar fills the byline from that record.
        $other = Author::factory()->create(['name' => 'Putri Pratiwi', 'role' => 'Travel Concierge']);
        $this->actingAs($this->admin)->put(route('admin.articles.update', $article), ['author_id' => $other->id, 'submit_as' => 'publish'] + $base)->assertSessionHasNoErrors();
        $this->assertSame('Putri Pratiwi', $article->fresh()->author_name);
        $this->assertSame('Travel Concierge', $article->fresh()->author_role);

        $this->actingAs($this->admin)->put(route('admin.articles.update', $article), $base + [
            'submit_as' => 'publish',
            'meta_title' => 'Crossing Tips | Penida Gili',
            'meta_description' => 'Everything about the crossing.',
            'meta_keywords' => 'nusa penida, fast boat',
        ])->assertSessionHasNoErrors();
        $article->refresh();
        $this->assertSame(ArticleStatus::Published, $article->status);

        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertSee('<title>Crossing Tips | Penida Gili — Penida Gili</title>', false)
            ->assertSee('<meta name="description" content="Everything about the crossing.">', false)
            ->assertSee('<meta name="keywords" content="nusa penida, fast boat">', false);

        $article->update(['meta_title' => null, 'meta_description' => null, 'meta_keywords' => null]);

        $this->get(route('articles.show', $article))
            ->assertSee('<title>Crossing Tips — Penida Gili</title>', false)
            ->assertSee('<meta name="description" content="Short summary">', false)
            ->assertDontSee('name="keywords"', false);
    }

    public function test_report_lists_bookings_and_changes_status(): void
    {
        $booking = Booking::factory()->create(['customer_name' => 'Report Person', 'status' => BookingStatus::Pending]);

        $this->actingAs($this->admin)->get(route('admin.report'))
            ->assertOk()
            ->assertSeeInOrder(['Booking Report', 'Download Report', 'Search Route', 'Boat', 'Date', 'Filter'])
            ->assertSeeInOrder(['Passenger', 'Route', 'Date & Time', 'Amount', 'Status', 'Action'])
            ->assertSee('Report Person')
            ->assertSee('Mark as Confirmed');
        $this->actingAs($this->admin)->get(route('admin.report', ['q' => 'nobody-here']))->assertOk()->assertDontSee('Report Person');

        // Search Route matches the ports of the booked schedule; the Boat filter matches its vessel.
        $sanur = Port::factory()->create(['name' => 'Sanur Beach Port', 'area' => 'Bali']);
        $penida = Port::factory()->create(['name' => 'Banjar Nyuh Nusa Penida', 'area' => 'Nusa Penida']);
        $queen = Vessel::factory()->create(['name' => 'Sanjaya Ocean Queen']);
        $schedule = Schedule::factory()->create(['from_port_id' => $sanur->id, 'to_port_id' => $penida->id, 'vessel_id' => $queen->id]);
        Booking::factory()->create(['customer_name' => 'Route Person', 'bookable_type' => $schedule->getMorphClass(), 'bookable_id' => $schedule->id]);

        $this->actingAs($this->admin)->get(route('admin.report', ['q' => 'Sanur to Nusa Penida']))
            ->assertSee('Route Person')->assertDontSee('Report Person');
        $this->actingAs($this->admin)->get(route('admin.report', ['vessel' => $queen->id]))
            ->assertSee('Route Person')->assertDontSee('Report Person');

        $this->actingAs($this->admin)->patch(route('admin.report.update', $booking), ['status' => 'confirmed'])
            ->assertRedirect();

        $this->assertSame(BookingStatus::Confirmed, $booking->fresh()->status);
        $this->assertNotNull($booking->fresh()->confirmed_at);
    }

    public function test_report_export_streams_csv(): void
    {
        Booking::factory()->create(['customer_email' => 'csv@example.com']);

        $response = $this->actingAs($this->admin)->get(route('admin.report.export'));

        $response->assertOk()->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('csv@example.com', $response->streamedContent());
    }

    public function test_dashboard_renders_with_seeded_style_data(): void
    {
        $vessel = Vessel::factory()->create();
        Schedule::factory()->for($vessel->operator, 'operator')->create(['vessel_id' => $vessel->id]);
        Booking::factory()->confirmed()->create();

        $this->actingAs($this->admin)->get(route('admin.dashboard'))->assertOk()->assertSee('Total Revenue');
    }

    public function test_hotel_toolbar_filters_by_search_destination_stars_and_status(): void
    {
        Hotel::factory()->create(['name' => 'Semabu Hills', 'address' => 'Ped, Nusa Penida, Bali', 'stars' => 5, 'status' => ListingStatus::Active, 'partner_label' => 'Hilltop Panorama']);
        Hotel::factory()->create(['name' => 'Batu Karang', 'address' => 'Jungutbatu, Nusa Lembongan', 'stars' => 4, 'status' => ListingStatus::Draft]);

        $this->actingAs($this->admin)->get(route('admin.hotels'))
            ->assertOk()
            ->assertSee('Search by hotel name, beach or area...')
            ->assertSeeInOrder(['All Destinations', 'Nusa Penida', 'All Star Ratings', '5 Stars', 'Status: All', 'Status: Active'])
            ->assertSeeInOrder(['Registered Partner Accommodations', '1 of 2 Active Listed', 'Refresh Rates'])
            ->assertSeeInOrder(['Hotel / Resort', 'Location', 'Rating', 'Room Types', 'Starting Price / Night', 'Status', 'Bookings (Mo)', 'Actions'])
            ->assertSee('Excl. taxes')->assertSee('% full')
            ->assertSee('Semabu Hills')->assertSee('Batu Karang');

        $this->actingAs($this->admin)->get(route('admin.hotels', ['q' => 'hilltop']))
            ->assertSee('Semabu Hills')->assertDontSee('Batu Karang');

        $this->actingAs($this->admin)->get(route('admin.hotels', ['destination' => 'Nusa Lembongan']))
            ->assertSee('Batu Karang')->assertDontSee('Semabu Hills');

        $this->actingAs($this->admin)->get(route('admin.hotels', ['stars' => 5]))
            ->assertSee('Semabu Hills')->assertDontSee('Batu Karang');

        $this->actingAs($this->admin)->get(route('admin.hotels', ['status' => 'draft']))
            ->assertSee('Batu Karang')->assertDontSee('Semabu Hills');
    }

    public function test_hotel_room_rates_show_in_public_listing_after_admin_creates_them(): void
    {
        $hotel = Hotel::factory()->create(['name' => 'Rate Check Resort']);
        HotelRoom::factory()->for($hotel)->create(['price_per_night' => 1_234_000]);

        $this->get(route('hotels.index'))->assertOk()->assertSee('Rate Check Resort')->assertSee('IDR 1.234.000');
    }
}
