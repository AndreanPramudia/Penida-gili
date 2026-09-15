<?php

namespace App\Http\Requests\Admin;

use App\Enums\ListingStatus;
use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActivityRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        // Prices arrive formatted ("75.000"); normalise to whole rupiah.
        $this->merge([
            'price_adult' => $this->digits('price_adult'),
            'price_child' => $this->digits('price_child'),
            'price_was' => $this->digits('price_was'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'category' => ['required', 'string', 'max:80'],
            'badge' => ['nullable', 'string', 'max:40'],
            'description' => ['required', 'string', 'max:2000'],
            'intro' => ['nullable', 'string', 'max:3000'],
            'summary' => ['nullable', 'string', 'max:6000'],
            'days' => ['nullable', 'array'],
            'days.*' => [Rule::in(Schedule::DAYS)],
            'opens_at' => ['nullable', 'date_format:H:i'],
            'closes_at' => ['nullable', 'date_format:H:i', 'after:opens_at'],
            'duration_label' => ['nullable', 'string', 'max:40'],
            'place_label' => ['required', 'string', 'max:80'],
            'location' => ['required', 'string', 'max:160'],
            'price_adult' => ['required', 'integer', 'min:0'],
            'price_child' => ['nullable', 'integer', 'min:0'],
            'price_was' => ['nullable', 'integer', 'min:0'],
            'price_note' => ['nullable', 'string', 'max:160'],
            'included' => ['nullable', 'string', 'max:2000'],
            'excluded' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', Rule::enum(ListingStatus::class)],
            'cover' => ['nullable', 'image', 'max:4096'],
            'gallery' => ['nullable', 'array', 'max:8'],
            'gallery.*' => ['image', 'max:4096'],
        ];
    }

    private function digits(string $key): ?int
    {
        $raw = $this->input($key);

        return filled($raw) ? (int) preg_replace('/\D+/', '', (string) $raw) : null;
    }
}
