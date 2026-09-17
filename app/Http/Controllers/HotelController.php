<?php

namespace App\Http\Controllers;

use App\Enums\ListingStatus;
use App\Models\Hotel;
use App\Support\BookingQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class HotelController extends Controller
{
    /**
     * Hotel listing — Figma node 1:946.
     */
    public function index(): View
    {
        return view('pages.hotels', [
            'hotels' => Hotel::query()->active()->with('rooms')->orderByDesc('rating')->paginate(9),
        ]);
    }

    /**
     * Hotel detail — Figma node 1:1694.
     */
    public function show(Hotel $hotel): View
    {
        abort_unless($hotel->status === ListingStatus::Active, 404);

        $hotel->load(['rooms', 'reviews' => fn ($q) => $q->where('is_published', true)->take(4)]);

        return view('pages.hotel-detail', ['hotel' => $hotel]);
    }

    /**
     * Order summary — Figma node 1:3024. Reached from the sidebar with
     * ?room=&check_in=&check_out=&guests=.
     */
    public function order(Request $request, Hotel $hotel): View
    {
        abort_unless($hotel->status === ListingStatus::Active, 404);

        // Without ?room= the cheapest listed room type is offered, never an arbitrary row.
        $room = $hotel->rooms()
            ->when($request->filled('room'), fn ($q) => $q->whereKey($request->integer('room')))
            ->orderBy('sort_order')
            ->orderBy('price_per_night')
            ->firstOrFail();

        $room->setRelation('hotel', $hotel);

        $checkIn = $request->date('check_in') ?? Carbon::tomorrow();
        $checkOut = $request->date('check_out') ?? $checkIn->copy()->addDays(2);

        if ($checkOut->lte($checkIn)) {
            $checkOut = $checkIn->copy()->addDay();
        }

        $quote = BookingQuote::forRoom(
            $room,
            $checkIn,
            $checkOut,
            $request->integer('adults', $request->integer('guests', 2)),
            $request->integer('children', 0),
            $request->integer('rooms', 1),
        );

        return view('pages.hotel-order', [
            'order' => $quote->toOrderDraft() + ['action' => route('hotels.book', $hotel)],
        ]);
    }
}
