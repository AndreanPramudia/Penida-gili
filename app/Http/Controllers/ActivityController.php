<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Support\BookingQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ActivityController extends Controller
{
    /**
     * Activity listing — Figma node 1:623.
     */
    public function index(): View
    {
        return view('pages.activities', [
            'activities' => Activity::query()->active()->orderByDesc('rating')->paginate(9),
        ]);
    }

    /**
     * Activity detail — Figma node 1:1442.
     */
    public function show(Activity $activity): View
    {
        abort_unless($activity->status->value === 'active', 404);

        $related = Activity::query()->active()->whereKeyNot($activity->id)->orderByDesc('sold_count')->take(4)->get();

        return view('pages.activity-detail', ['activity' => $activity, 'related' => $related]);
    }

    /**
     * Order summary — Figma node 1:2874.
     */
    public function order(Request $request, Activity $activity): View
    {
        $quote = BookingQuote::forActivity(
            $activity,
            $request->date('date') ?? Carbon::tomorrow(),
            $request->integer('adults', 1),
            $request->integer('children', 0),
        );

        return view('pages.activity-order', [
            'order' => $quote->toOrderDraft() + ['action' => route('activities.book', $activity)],
        ]);
    }
}
