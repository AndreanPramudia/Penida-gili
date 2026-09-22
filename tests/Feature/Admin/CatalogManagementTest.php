<?php

namespace Tests\Feature\Admin;

use App\Enums\ArticleStatus;
use App\Enums\BookingStatus;
use App\Enums\ListingStatus;
use App\Models\Activity;
use App\Models\Article;
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
            ->assertSeeInOrder(['Publishing Settings', 'Publish Immediately', 'Save as Draft', 'Boat Details', 'Initial Status', 'Boat Photos', 'Boat Facilities']);

        $base = ['boat_operator_id' => $operator->id, 'name' => 'Sanjaya Explorer', 'type' => 'Luxury Catamaran', 'capacity' => 120];

        $this->actingAs($this->admin)->post(route('admin.boats.store'), $base + ['publish' => 'draft', 'status' => ListingStatus::Active->value])
            ->assertRedirect(route('admin.boats'));
        $this->assertSame(ListingStatus::Draft, Vessel::query()->sole()->status);

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
        [$from, $to] = Port::factory()->count(2)->create();

        $this->actingAs($this->admin)->post(route('admin.schedules.store'), [
            'boat_operator_id' => $operator->id,
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
            'status' => 'active',
        ])->assertRedirect(route('admin.activities'));

        $activity = Activity::query()->sole();
        $this->assertSame(180_000, $activity->price_adult);
        $this->assertSame(250_000, $activity->price_was);
        $this->assertSame(['Entrance ticket', 'Seat reservation'], $activity->included);
        $this->assertSame('kecak-fire-dance', $activity->slug);
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
            'amenities' => ['Infinity Pool'],
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
        $this->assertSame('Infinity Pool', $hotel->amenities[0]['label']);

        $deluxe = $hotel->rooms->firstWhere('name', 'Deluxe');
        $villa = $hotel->rooms->firstWhere('name', 'Villa');

        $this->actingAs($this->admin)->put(route('admin.hotels.update', $hotel), array_merge($payload, ['rooms' => [
            ['id' => $deluxe->id, 'name' => 'Deluxe Ocean', 'guests' => 3, 'price_per_night' => '2.700.000', 'stock' => 4],
        ]]))->assertRedirect(route('admin.hotels'));

        $this->assertSame('Deluxe Ocean', $deluxe->fresh()->name);
        $this->assertModelMissing($villa);
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
        $this->actingAs($this->admin)->get(route('admin.articles.create'))
            ->assertOk()
            ->assertSee('SEO (Google)')
            ->assertSee('Article Information')
            ->assertSee('Image &amp; Content', false);

        $base = ['title' => 'Crossing Tips', 'excerpt' => 'Short summary', 'category' => 'Boat Tips', 'body' => 'Body text', 'author_name' => 'Capt. Wayan', 'status' => 'published'];

        $this->actingAs($this->admin)->post(route('admin.articles.store'), $base + [
            'meta_title' => 'Crossing Tips | Penida Gili',
            'meta_description' => 'Everything about the crossing.',
            'meta_keywords' => 'nusa penida, fast boat, , fast boat',
        ])->assertRedirect(route('admin.articles'));

        $article = Article::query()->sole();
        $this->assertSame(['nusa penida', 'fast boat'], $article->meta_keywords);
        $this->assertSame('Crossing Tips | Penida Gili', $article->seo_title);

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

        $this->actingAs($this->admin)->get(route('admin.report'))->assertOk()->assertSee('Report Person');
        $this->actingAs($this->admin)->get(route('admin.report', ['q' => 'nobody-here']))->assertOk()->assertDontSee('Report Person');

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

    public function test_hotel_room_rates_show_in_public_listing_after_admin_creates_them(): void
    {
        $hotel = Hotel::factory()->create(['name' => 'Rate Check Resort']);
        HotelRoom::factory()->for($hotel)->create(['price_per_night' => 1_234_000]);

        $this->get(route('hotels.index'))->assertOk()->assertSee('Rate Check Resort')->assertSee('IDR 1.234.000');
    }
}
