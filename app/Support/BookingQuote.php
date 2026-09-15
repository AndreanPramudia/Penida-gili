<?php

namespace App\Support;

use App\Models\Activity;
use App\Models\HotelRoom;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Prices a prospective reservation and shapes it for the order screens.
 *
 * One quote object serves the three product types so the booking form,
 * the summary sidebar and CreateBooking all agree on the same numbers.
 */
final class BookingQuote
{
    private function __construct(
        public readonly Model $bookable,
        public readonly Carbon $date,
        public readonly ?Carbon $checkOut,
        public readonly int $adults,
        public readonly int $children,
        public readonly int $unitAdult,
        public readonly int $unitChild,
        public readonly int $nights = 1,
        public readonly int $rooms = 1,
        public readonly int $extraAdultPrice = 0,
        public readonly int $includedAdultsPerRoom = 0,
    ) {}

    public static function forSchedule(Schedule $schedule, Carbon $date, int $adults = 1, int $children = 0): self
    {
        return new self($schedule, $date, null, max(1, $adults), max(0, $children), $schedule->price_adult, $schedule->price_child);
    }

    public static function forRoom(HotelRoom $room, Carbon $checkIn, Carbon $checkOut, int $adults = 2, int $children = 0, int $rooms = 1): self
    {
        $nights = max(1, (int) $checkIn->startOfDay()->diffInDays($checkOut->startOfDay()));

        // Hotel rooms are priced per night per room, not per guest; children ride along free.
        $people = max(1, $adults) + max(0, $children);
        $needed = (int) ceil($people / BookingOptions::GUESTS_PER_ROOM);

        return new self(
            $room, $checkIn, $checkOut, max(1, $adults), max(0, $children), $room->price_per_night, 0, $nights, max($needed, $rooms),
            (int) config('penida.booking.hotel_extra_adult_price', 0),
            (int) config('penida.booking.hotel_included_adults', 2),
        );
    }

    public static function forActivity(Activity $activity, Carbon $date, int $adults = 1, int $children = 0): self
    {
        return new self($activity, $date, null, max(1, $adults), max(0, $children), $activity->price_adult, $activity->price_child);
    }

    public function total(): int
    {
        return $this->bookable instanceof HotelRoom
            ? $this->unitAdult * $this->nights * $this->rooms + $this->extraAdultSurcharge()
            : $this->adults * $this->unitAdult + $this->children * $this->unitChild;
    }

    /** Adults beyond the included allowance across all booked rooms. */
    public function extraAdults(): int
    {
        return max(0, $this->adults - $this->includedAdultsPerRoom * $this->rooms);
    }

    public function extraAdultSurcharge(): int
    {
        return $this->extraAdults() * $this->extraAdultPrice;
    }

    /** @return list<array{label: string, amount: string}> */
    public function lines(): array
    {
        if ($this->bookable instanceof HotelRoom) {
            $label = Money::idr($this->unitAdult).' x '.$this->nights.' night'.($this->nights > 1 ? 's' : '');
            if ($this->rooms > 1) {
                $label .= ' x '.$this->rooms.' rooms';
            }

            $lines = [['label' => $label, 'amount' => Money::idr($this->unitAdult * $this->nights * $this->rooms)]];

            if ($extra = $this->extraAdults()) {
                $lines[] = ['label' => $extra.' Extra Adult'.($extra > 1 ? 's' : '').' x '.Money::idr($this->extraAdultPrice), 'amount' => Money::idr($this->extraAdultSurcharge())];
            }

            return $lines;
        }

        $lines = [['label' => $this->adults.' Adult'.($this->adults > 1 ? 's' : ''), 'amount' => Money::idr($this->adults * $this->unitAdult)]];

        if ($this->children > 0) {
            $lines[] = ['label' => $this->children.' Child'.($this->children > 1 ? 'ren' : ''), 'amount' => Money::idr($this->children * $this->unitChild)];
        }

        return $lines;
    }

    /**
     * Party-size steppers shared by all three order forms.
     *
     * @return list<array<string, mixed>>
     */
    public function party(): array
    {
        $perNight = $this->bookable instanceof HotelRoom;

        $groups = [
            [
                'name' => 'adults', 'label' => 'Adults', 'hint' => 'Age 13+',
                'value' => $this->adults, 'min' => 1,
                'price' => $perNight
                    ? ($this->extraAdults() === 0 ? 'Included in room rate' : '+'.Money::idr($this->extraAdultPrice, 'Rp').' / extra adult')
                    : Money::idr($this->unitAdult).' / adult',
            ],
            [
                'name' => 'children', 'label' => 'Child (3 - 6 Years)', 'hint' => 'Age 3-6',
                'value' => $this->children, 'min' => 0,
                'price' => $perNight ? 'Stays free' : Money::idr($this->unitChild).' / child',
            ],
        ];

        if ($perNight) {
            $groups[] = [
                'name' => 'rooms', 'label' => 'Rooms', 'hint' => 'Max '.BookingOptions::GUESTS_PER_ROOM.' guests per room',
                'value' => $this->rooms, 'min' => 1,
                'price' => Money::idr($this->unitAdult * $this->nights).' / room ('.$this->nights.' night'.($this->nights > 1 ? 's' : '').')',
            ];
        }

        return $groups;
    }

    /**
     * The array the order Blade views were built against.
     *
     * @return array<string, mixed>
     */
    public function toOrderDraft(): array
    {
        $base = [
            'bookable_id' => $this->bookable->getKey(),
            'travel_date' => $this->date->toDateString(),
            'check_out' => $this->checkOut?->toDateString(),
            'adults' => $this->adults,
            'children' => $this->children,
            'rooms' => $this->rooms,
            'lines' => $this->lines(),
            'total' => Money::idr($this->total()),
            'total_raw' => $this->total(),
            'party' => $this->party(),
            'nationalities' => BookingOptions::nationalities(),
            'dialCodes' => BookingOptions::dialCodes(),
            'countries' => BookingOptions::countries(),
            // Consumed by resources/js/order-quote.js to recompute the total client-side.
            'quote' => [
                'perRoom' => $this->bookable instanceof HotelRoom,
                'unitAdult' => $this->unitAdult,
                'unitChild' => $this->unitChild,
                'nights' => $this->nights,
                'guestsPerRoom' => BookingOptions::GUESTS_PER_ROOM,
                'includedAdults' => $this->includedAdultsPerRoom,
                'extraAdultPrice' => $this->extraAdultPrice,
            ],
        ];

        return $base + match (true) {
            $this->bookable instanceof Schedule => $this->scheduleDraft($this->bookable),
            $this->bookable instanceof HotelRoom => $this->roomDraft($this->bookable),
            $this->bookable instanceof Activity => $this->activityDraft($this->bookable),
        };
    }

    /** @return array<string, mixed> */
    private function scheduleDraft(Schedule $schedule): array
    {
        return [
            'schedule_id' => $schedule->id,
            'slug' => $schedule->operator->slug,
            'tripType' => 'One Way',
            'operator' => $schedule->operator->name,
            'service' => 'Standard Fast Boat Service',
            'date' => $this->date->format('D, d M Y'),
            'departure' => Carbon::parse($schedule->departure_time)->format('H:i'),
            'arrival' => Carbon::parse($schedule->arrival_time)->format('H:i'),
            'from' => $schedule->fromPort->name,
            'to' => $schedule->toPort->name,
        ];
    }

    /** @return array<string, mixed> */
    private function roomDraft(HotelRoom $room): array
    {
        $hotel = $room->hotel;

        return [
            'room_id' => $room->id,
            'slug' => $hotel->slug,
            'summaryTitle' => 'Hotel Booking Summary',
            'propertyType' => $hotel->category,
            'property' => $hotel->name,
            'location' => $hotel->address,
            'thumb' => 'summary-thumb.png',
            'details' => [
                ['icon' => 'room-type.svg', 'label' => 'Room Type', 'value' => $room->name.($this->rooms > 1 ? ' × '.$this->rooms : '')],
                ['icon' => 'calendar.svg', 'label' => 'Dates', 'value' => $this->date->format('d M Y').' - '.$this->checkOut->format('d M Y'), 'note' => '('.$this->nights.' Night'.($this->nights > 1 ? 's' : '').')'],
                ['icon' => 'guests.svg', 'label' => 'Guests', 'value' => $this->adults.' Adult'.($this->adults > 1 ? 's' : '').($this->children ? ', '.$this->children.' Child'.($this->children > 1 ? 'ren' : '') : '')],
            ],
            'lineLabel' => $this->lines()[0]['label'],
            'lineAmount' => $this->lines()[0]['amount'],
            'extraLabel' => $this->lines()[1]['label'] ?? '',
            'extraAmount' => $this->lines()[1]['amount'] ?? '',
        ];
    }

    /** @return array<string, mixed> */
    private function activityDraft(Activity $activity): array
    {
        return [
            'slug' => $activity->slug,
            'summaryTitle' => 'Activity Booking Summary',
            'rows' => [
                ['label' => 'Activity', 'value' => $activity->name],
                ['label' => 'Date', 'value' => $this->date->format('d M Y')],
                ['label' => 'Participants', 'value' => $this->adults.' Adult'.($this->adults > 1 ? 's' : '').($this->children ? ', '.$this->children.' Child'.($this->children > 1 ? 'ren' : '') : '')],
                ['label' => 'Price', 'value' => Money::idr($this->unitAdult).' / person'],
            ],
        ];
    }
}
