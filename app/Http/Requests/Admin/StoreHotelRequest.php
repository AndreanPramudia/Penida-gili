<?php

namespace App\Http\Requests\Admin;

use App\Enums\ListingStatus;
use App\Support\BookingOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHotelRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $rooms = collect($this->input('rooms', []))
            ->filter(fn ($room) => filled($room['name'] ?? null))
            ->map(fn ($room) => array_merge($room, ['price_per_night' => (int) preg_replace('/\D+/', '', (string) ($room['price_per_night'] ?? 0))]))
            ->values()
            ->all();

        $this->merge(['rooms' => $rooms]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'category' => ['required', 'string', 'max:40'],
            'partner_label' => ['nullable', 'string', 'max:80'],
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
            'description' => ['required', 'string', 'max:3000'],
            'address' => ['required', 'string', 'max:160'],
            'full_address' => ['nullable', 'string', 'max:255'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string', 'max:60'],
            'status' => ['required', Rule::enum(ListingStatus::class)],
            'cover' => ['nullable', 'image', 'max:4096'],
            'gallery' => ['nullable', 'array', 'max:12'],
            'gallery.*' => ['image', 'max:4096'],
            'rooms' => ['required', 'array', 'min:1'],
            'rooms.*.id' => ['nullable', 'integer'],
            'rooms.*.name' => ['required', 'string', 'max:120'],
            // Guests never exceed the online booking cap, or a room could advertise capacity nobody can book.
            'rooms.*.guests' => ['required', 'integer', 'min:1', 'max:'.BookingOptions::GUESTS_PER_ROOM],
            'rooms.*.bed' => ['nullable', 'string', 'max:60'],
            'rooms.*.size_label' => ['nullable', 'string', 'max:60'],
            'rooms.*.price_per_night' => ['required', 'integer', 'min:0'],
            'rooms.*.stock' => ['required', 'integer', 'min:0', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'rooms.required' => 'Add at least one room type with a nightly rate.',
            'rooms.*.guests.max' => 'Rooms hold at most '.BookingOptions::GUESTS_PER_ROOM.' guests online; extra adults are charged as a surcharge.',
        ];
    }
}
