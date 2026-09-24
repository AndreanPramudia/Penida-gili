<?php

namespace App\Http\Controllers;

use App\Models\BoatOperator;
use App\Models\Review;
use App\Models\Schedule;
use App\Support\Money;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Landing page — Figma node 1:55 (desktop) / 1:2386 (mobile).
     */
    public function index(): View
    {
        return view('pages.home', [
            'operators' => BoatOperator::query()
                ->active()
                // Only what the public can actually book: drafts and retired boats stay out of the counts.
                ->withCount([
                    'schedules as schedules_count' => fn (Builder $q) => $q->active(),
                    'vessels as vessels_count' => fn (Builder $q) => $q->active(),
                ])
                ->orderByDesc('rating')
                ->take(3)
                ->get(),
            'popularRoutes' => $this->popularRoutes(),
            'testimonials' => Review::query()
                ->where('is_published', true)
                ->whereMorphedTo('reviewable', BoatOperator::class)
                ->latest('experienced_at')
                ->take(2)
                ->get(),
        ]);
    }

    /**
     * The three busiest port pairs currently on sale, so the home page follows
     * whatever schedules the console publishes.
     *
     * @return Collection<int, array{title: string, body: string, icon: string, href: string}>
     */
    private function popularRoutes(): Collection
    {
        $icons = ['route-penida.svg', 'route-gili.svg', 'route-lembongan.svg'];

        return Schedule::query()
            ->active()
            ->with(['fromPort', 'toPort', 'operator'])
            ->get()
            ->groupBy(fn (Schedule $schedule) => $schedule->from_port_id.'-'.$schedule->to_port_id)
            ->sortByDesc(fn ($group) => $group->count())
            ->take(3)
            ->values()
            ->map(function ($group, $index) use ($icons) {
                /** @var Schedule $first */
                $first = $group->first();
                $sailings = $group->count();

                return [
                    'icon' => $icons[$index % count($icons)],
                    'title' => $first->fromPort->name.' ➔ '.$first->toPort->name,
                    'body' => $sailings.' daily sailing'.($sailings > 1 ? 's' : '')
                        .' from '.$group->min('departure_label').', operated by '
                        .$group->pluck('operator.name')->unique()->join(', ').'. Fares from '
                        .Money::idr($group->min('price_adult')).'.',
                    'href' => route('boats.index', ['from' => $first->fromPort->name, 'to' => $first->toPort->name]),
                ];
            });
    }
}
