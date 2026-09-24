<?php

namespace App\Http\Controllers;

use App\Models\BoatOperator;
use App\Models\Schedule;
use App\Support\BookingQuote;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class BoatOperatorController extends Controller
{
    /**
     * Boat Operators listing — Figma node 1:408. Also serves the hero search
     * (?from=&to=&date=&guests=) by narrowing to operators sailing that route.
     */
    public function index(Request $request): View
    {
        $from = $request->string('from')->trim()->value();
        $to = $request->string('to')->trim()->value();
        $date = $request->date('date');

        $operators = BoatOperator::query()
            ->active()
            ->withCount(['schedules', 'vessels'])
            ->when($from || $to, fn (Builder $q) => $q->whereHas('schedules', fn (Builder $s) => $s->active()->betweenPorts($from, $to)))
            ->orderByDesc('rating')
            ->paginate(9)
            ->withQueryString();

        return view('pages.boats', [
            'operators' => $operators,
            'search' => ['from' => $from, 'to' => $to, 'date' => $date?->toDateString(), 'guests' => $request->integer('guests') ?: null],
        ]);
    }

    /**
     * Boat detail — Figma node 1:1179.
     */
    public function show(BoatOperator $boat): View
    {
        abort_unless($boat->is_active, 404);

        $boat->load([
            'vessels' => fn ($q) => $q->active()->orderBy('name'),
            'schedules' => fn ($q) => $q->active()->with(['fromPort', 'toPort']),
            'reviews' => fn ($q) => $q->where('is_published', true)->take(4),
        ]);

        return view('pages.boat-detail', ['boat' => $boat]);
    }

    /**
     * Order summary — Figma node 1:1923. Reached from the booking widget with
     * ?schedule=&date=&adults=&children=.
     */
    public function order(Request $request, BoatOperator $boat): View
    {
        $schedule = $boat->schedules()->active()->with(['fromPort', 'toPort'])
            ->when($request->filled('schedule'), fn ($q) => $q->whereKey($request->integer('schedule')))
            ->firstOrFail();

        $schedule->setRelation('operator', $boat);

        $quote = BookingQuote::forSchedule(
            $schedule,
            $request->date('date') ?? Carbon::tomorrow(),
            $request->integer('adults', 1),
            $request->integer('children', 0),
        );

        return view('pages.boat-order', [
            'order' => $quote->toOrderDraft() + ['action' => route('boats.book', $boat)],
        ]);
    }
}
