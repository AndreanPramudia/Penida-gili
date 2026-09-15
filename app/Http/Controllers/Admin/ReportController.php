<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\HotelRoom;
use App\Models\Schedule;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Booking Report — Figma node 1:10402.
     */
    public function index(Request $request): View
    {
        $bookings = $this->filtered($request)->paginate(10)->withQueryString();

        return view('admin.report', [
            'bookings' => $bookings,
            'rows' => $bookings->getCollection()->map->toReportRow(),
            'filters' => $request->only(['q', 'status', 'date']),
            'statuses' => BookingStatus::cases(),
        ]);
    }

    /** Change a reservation's status from the report row menu. */
    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::enum(BookingStatus::class)]]);

        match (BookingStatus::from($data['status'])) {
            BookingStatus::Confirmed => $booking->confirm(),
            BookingStatus::Cancelled => $booking->cancel(),
            BookingStatus::Pending => $booking->forceFill(['status' => BookingStatus::Pending, 'confirmed_at' => null])->save(),
        };

        return back()->with('flash', "Booking {$booking->reference} marked ".$booking->status->label().'.');
    }

    /** CSV export of the current filter. */
    public function export(Request $request): StreamedResponse
    {
        $query = $this->filtered($request);
        $filename = 'bookings-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($query): void {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Reference', 'Customer', 'Email', 'Phone', 'Nationality', 'Product', 'Travel date', 'Adults', 'Children', 'Total (IDR)', 'Status', 'Payment', 'Booked at']);

            $query->lazyById(200)->each(function (Booking $b) use ($out): void {
                fputcsv($out, [
                    $b->reference, $b->customer_name, $b->customer_email, $b->dial_code.' '.$b->phone, $b->nationality,
                    $b->product_label, $b->travel_date->toDateString(), $b->adults, $b->children, $b->total,
                    $b->status->label(), $b->payment_status->label(), $b->created_at->toDateTimeString(),
                ]);
            });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function filtered(Request $request): Builder
    {
        return Booking::query()
            ->with(['bookable' => fn (MorphTo $morph) => $morph->morphWith([
                Schedule::class => ['operator', 'vessel', 'fromPort', 'toPort'],
                HotelRoom::class => ['hotel'],
            ])])
            ->search($request->string('q')->value())
            ->when($request->filled('status'), fn (Builder $q) => $q->where('status', $request->string('status')->value()))
            ->when($request->filled('date'), fn (Builder $q) => $q->whereDate('travel_date', $request->date('date')))
            ->latest();
    }
}
