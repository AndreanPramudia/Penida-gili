<?php

namespace App\Http\Controllers;

use App\Actions\CreateBooking;
use App\Enums\ListingStatus;
use App\Http\Requests\StoreActivityBookingRequest;
use App\Http\Requests\StoreBoatBookingRequest;
use App\Http\Requests\StoreHotelBookingRequest;
use App\Models\Activity;
use App\Models\BoatOperator;
use App\Models\Booking;
use App\Models\Hotel;
use App\Support\BookingQuote;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(private readonly CreateBooking $createBooking) {}

    public function storeBoat(StoreBoatBookingRequest $request, BoatOperator $boat): RedirectResponse
    {
        $quote = BookingQuote::forSchedule(
            $request->schedule(),
            $request->date('travel_date'),
            $request->integer('adults'),
            $request->integer('children'),
        );

        return $this->finish($this->createBooking->handle($quote, $request->traveller()));
    }

    public function storeHotel(StoreHotelBookingRequest $request, Hotel $hotel): RedirectResponse
    {
        abort_unless($hotel->status === ListingStatus::Active, 404);

        $quote = BookingQuote::forRoom(
            $request->room(),
            $request->date('travel_date'),
            $request->date('check_out'),
            $request->integer('adults'),
            $request->integer('children'),
            $request->integer('rooms', 1),
        );

        return $this->finish($this->createBooking->handle($quote, $request->traveller()));
    }

    public function storeActivity(StoreActivityBookingRequest $request, Activity $activity): RedirectResponse
    {
        $quote = BookingQuote::forActivity(
            $activity,
            $request->date('travel_date'),
            $request->integer('adults'),
            $request->integer('children'),
        );

        return $this->finish($this->createBooking->handle($quote, $request->traveller()));
    }

    /**
     * Confirmation page. The reference doubles as the access token — it is
     * random and unguessable, which is enough for a guest checkout.
     */
    public function show(Booking $booking): View
    {
        $booking->load('bookable');

        return view('pages.booking-confirmation', ['booking' => $booking]);
    }

    private function finish(Booking $booking): RedirectResponse
    {
        return redirect()->route('bookings.show', $booking)->with('status', 'booked');
    }
}
