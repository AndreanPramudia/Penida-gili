<?php

namespace App\Http\Requests;

use App\Models\HotelRoom;
use App\Support\BookingOptions;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreHotelBookingRequest extends StoreBookingRequest
{
    public function rules(): array
    {
        return parent::rules() + [
            'room_id' => ['required', Rule::exists('hotel_rooms', 'id')->where('hotel_id', $this->route('hotel')->id)],
            'check_out' => ['required', 'date', 'after:travel_date'],
            'rooms' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    /**
     * Guests may never exceed the room capacity; the form bumps rooms up automatically,
     * so this only trips when someone bypasses the UI.
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $people = $this->integer('adults') + $this->integer('children');
                $needed = (int) ceil($people / BookingOptions::GUESTS_PER_ROOM);

                if ($this->integer('rooms') < $needed) {
                    $validator->errors()->add('rooms', "{$people} guests need at least {$needed} rooms (max ".BookingOptions::GUESTS_PER_ROOM.' per room).');
                }
            },
        ];
    }

    public function room(): HotelRoom
    {
        return HotelRoom::query()->with('hotel')->findOrFail($this->integer('room_id'));
    }
}
