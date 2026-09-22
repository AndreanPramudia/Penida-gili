<?php

namespace App\Http\Requests\Admin;

use App\Enums\ListingStatus;
use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActivityRequest extends FormRequest
{
    public const CANCELLATION_POLICIES = [
        'free_24h' => 'Free Cancellation (Up to 24 hours prior)',
        'free_48h' => 'Free Cancellation (Up to 48 hours prior)',
        'partial' => 'Partial Refund (50% within 24 hours)',
        'none' => 'Non-refundable',
    ];

    protected function prepareForValidation(): void
    {
        // "Scheduled" is a publishing choice, not a listing status: it stays a draft
        // until publish_at. The header buttons (Save Draft / Publish Activity) win over the radios.
        $status = match ($this->input('submit_as')) {
            'draft' => ListingStatus::Draft->value,
            'publish' => ListingStatus::Active->value,
            default => $this->input('status') === 'scheduled' ? ListingStatus::Draft->value : $this->input('status'),
        };

        // Prices arrive formatted ("75.000"); normalise to whole rupiah.
        $this->merge([
            'status' => $status,
            'scheduled' => $this->input('status') === 'scheduled' && $this->input('submit_as') !== 'publish',
            'price_adult' => $this->digits('price_adult'),
            'price_child' => $this->digits('price_child'),
            'price_was' => $this->digits('price_was'),
            'price_foreign' => $this->digits('price_foreign'),
            'max_daily_capacity' => $this->digits('max_daily_capacity'),
            // Checkbox switches post "on"; the boolean rule wants a real flag.
            'instant_confirmation' => $this->boolean('instant_confirmation'),
            'dual_pricing' => $this->boolean('dual_pricing'),
            'is_public' => $this->boolean('is_public'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'category' => ['required', 'string', 'max:80'],
            'badge' => ['nullable', 'string', 'max:40'],
            'description' => ['required', 'string', 'max:6000'],
            'intro' => ['nullable', 'string', 'max:3000'],
            'summary' => ['nullable', 'string', 'max:6000'],
            'days' => ['nullable', 'array'],
            'days.*' => [Rule::in(Schedule::DAYS)],
            'opens_at' => ['nullable', 'date_format:H:i'],
            'closes_at' => ['nullable', 'date_format:H:i', 'after:opens_at'],
            'duration_label' => ['nullable', 'string', 'max:40'],
            'instant_confirmation' => ['nullable', 'boolean'],
            'cancellation_policy' => ['nullable', Rule::in(array_keys(self::CANCELLATION_POLICIES))],
            'place_label' => ['nullable', 'string', 'max:80'],
            'location' => ['nullable', 'string', 'max:160'],
            'price_adult' => ['required', 'integer', 'min:0'],
            'price_child' => ['nullable', 'integer', 'min:0'],
            'price_was' => ['nullable', 'integer', 'min:0'],
            'dual_pricing' => ['nullable', 'boolean'],
            'price_foreign' => ['nullable', 'integer', 'min:0'],
            'price_note' => ['nullable', 'string', 'max:160'],
            'max_daily_capacity' => ['required', 'integer', 'min:1', 'max:10000'],
            'included' => ['nullable', 'string', 'max:2000'],
            'excluded' => ['nullable', 'string', 'max:2000'],
            'important_notes' => ['nullable', 'string', 'max:3000'],
            'status' => ['required', Rule::enum(ListingStatus::class)],
            'scheduled' => ['nullable', 'boolean'],
            'publish_at' => ['nullable', 'date', Rule::requiredIf(fn () => $this->boolean('scheduled'))],
            'is_public' => ['nullable', 'boolean'],
            'submit_as' => ['nullable', Rule::in(['draft', 'publish'])],
            'cover' => ['nullable', 'image', 'max:10240'],
            'gallery' => ['nullable', 'array', 'max:8'],
            'gallery.*' => ['image', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'publish_at.required' => 'Pick the date and time the activity should go live.',
        ];
    }

    private function digits(string $key): ?int
    {
        $raw = $this->input($key);

        return filled($raw) ? (int) preg_replace('/\D+/', '', (string) $raw) : null;
    }
}
