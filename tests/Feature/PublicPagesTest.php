<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Article;
use App\Models\BoatOperator;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\Port;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_lists_active_operators_only(): void
    {
        $active = BoatOperator::factory()->create(['name' => 'Visible Fast Boat']);
        BoatOperator::factory()->inactive()->create(['name' => 'Hidden Fast Boat']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($active->name)
            ->assertDontSee('Hidden Fast Boat');
    }

    public function test_boat_search_narrows_to_operators_sailing_the_route(): void
    {
        $sanur = Port::factory()->create(['name' => 'Sanur', 'area' => 'Bali']);
        $penida = Port::factory()->create(['name' => 'Nusa Penida', 'area' => 'Nusa Penida']);
        $gili = Port::factory()->create(['name' => 'Gili Trawangan', 'area' => 'Gili']);

        $match = BoatOperator::factory()->create(['name' => 'Penida Express']);
        Schedule::factory()->for($match, 'operator')->create(['from_port_id' => $sanur->id, 'to_port_id' => $penida->id]);

        $other = BoatOperator::factory()->create(['name' => 'Gili Runner']);
        Schedule::factory()->for($other, 'operator')->create(['from_port_id' => $sanur->id, 'to_port_id' => $gili->id]);

        $this->get(route('boats.index', ['from' => 'Sanur', 'to' => 'penida']))
            ->assertOk()
            ->assertSee('Penida Express')
            ->assertDontSee('Gili Runner');
    }

    public function test_boat_detail_shows_only_active_schedules(): void
    {
        $operator = BoatOperator::factory()->create();
        $live = Schedule::factory()->for($operator, 'operator')->create(['departure_time' => '07:15']);
        Schedule::factory()->for($operator, 'operator')->draft()->create(['departure_time' => '21:45']);

        $this->get(route('boats.show', $operator))
            ->assertOk()
            ->assertSee($live->departure_label)
            ->assertDontSee('09:45 PM');
    }

    public function test_inactive_operator_is_not_found(): void
    {
        $operator = BoatOperator::factory()->inactive()->create();

        $this->get(route('boats.show', $operator))->assertNotFound();
    }

    public function test_boat_order_page_prices_the_selected_schedule(): void
    {
        $operator = BoatOperator::factory()->create();
        $schedule = Schedule::factory()->for($operator, 'operator')->create(['price_adult' => 200_000, 'price_child' => 100_000]);

        $this->get(route('boats.order', [$operator, 'schedule' => $schedule->id, 'adults' => 2, 'children' => 1, 'date' => now()->addWeek()->toDateString()]))
            ->assertOk()
            ->assertSee('IDR 500.000');
    }

    public function test_hotel_order_page_charges_per_night(): void
    {
        $hotel = Hotel::factory()->create();
        $room = HotelRoom::factory()->for($hotel)->create(['price_per_night' => 1_000_000]);

        $this->get(route('hotels.order', [$hotel, 'room' => $room->id, 'check_in' => '2030-01-01', 'check_out' => '2030-01-04']))
            ->assertOk()
            ->assertSee('IDR 3.000.000');

        $this->get(route('hotels.order', [$hotel, 'room' => $room->id, 'check_in' => '2030-01-01', 'check_out' => '2030-01-04', 'rooms' => 2]))
            ->assertOk()
            ->assertSee('IDR 6.000.000');

        // 6 guests need two rooms even when only one was requested.
        $this->get(route('hotels.order', [$hotel, 'room' => $room->id, 'check_in' => '2030-01-01', 'check_out' => '2030-01-04', 'adults' => 6, 'rooms' => 1]))
            ->assertOk()
            ->assertSee('IDR 6.000.000');
    }

    public function test_activity_detail_and_order_pages_render(): void
    {
        $activity = Activity::factory()->create(['price_adult' => 90_000]);

        $this->get(route('activities.show', $activity))->assertOk()->assertSee($activity->name);
        $this->get(route('activities.order', [$activity, 'adults' => 3]))->assertOk()->assertSee('IDR 270.000');
    }

    public function test_draft_activity_is_hidden_from_listing_and_detail(): void
    {
        $draft = Activity::factory()->draft()->create(['name' => 'Secret Draft Tour']);

        $this->get(route('activities.index'))->assertOk()->assertDontSee('Secret Draft Tour');
        $this->get(route('activities.show', $draft))->assertNotFound();
    }

    public function test_article_search_filters_published_articles(): void
    {
        Article::factory()->create(['title' => 'Snorkeling With Mantas']);
        Article::factory()->create(['title' => 'Packing For Lembongan']);
        Article::factory()->draft()->create(['title' => 'Unpublished Snorkeling Draft']);

        $this->get(route('articles.index', ['q' => 'snorkeling']))
            ->assertOk()
            ->assertSee('Snorkeling With Mantas')
            ->assertDontSee('Packing For Lembongan')
            ->assertDontSee('Unpublished Snorkeling Draft');
    }

    public function test_article_detail_counts_a_view_and_hides_drafts(): void
    {
        $article = Article::factory()->create(['views' => 4]);
        $draft = Article::factory()->draft()->create();

        $this->get(route('articles.show', $article))->assertOk();
        $this->get(route('articles.show', $draft))->assertNotFound();

        $this->assertSame(5, $article->fresh()->views);
    }
}
