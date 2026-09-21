<?php

namespace App\Models;

use App\Enums\ListingStatus;
use App\Models\Concerns\HasReviews;
use App\Models\Concerns\HasSlug;
use App\Support\ImagePath;
use App\Support\Money;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

#[Fillable([
    'name', 'slug', 'badge', 'category', 'location', 'place_label', 'opens_at', 'closes_at', 'duration_label',
    'description', 'intro', 'summary', 'summary_image', 'image', 'gallery', 'highlights', 'experiences',
    'included', 'excluded', 'days', 'price_adult', 'price_child', 'price_was', 'price_note',
    'rating', 'review_count', 'sold_count', 'status',
])]
class Activity extends Model
{
    use HasFactory, HasReviews, HasSlug;

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:1',
            'gallery' => 'array',
            'highlights' => 'array',
            'experiences' => 'array',
            'included' => 'array',
            'excluded' => 'array',
            'days' => 'array',
            'price_adult' => 'integer',
            'price_child' => 'integer',
            'price_was' => 'integer',
            'status' => ListingStatus::class,
        ];
    }

    protected function slugSource(): string
    {
        return $this->name;
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('status', ListingStatus::Active);
    }

    /**
     * Gallery entries with resolved URLs; falls back to the cover so detail
     * pages always have a lead photo.
     *
     * @return list<array{image: string, alt: string, url: string, more?: string}>
     */
    protected function galleryPhotos(): Attribute
    {
        return Attribute::get(function () {
            $items = collect($this->gallery ?: [])
                ->map(fn (array $photo) => $photo + ['url' => ImagePath::url($photo['image'], 'activities/detail')])
                ->values();

            $cover = ['image' => $this->image, 'alt' => $this->name, 'url' => ImagePath::url($this->image, 'activities')];

            if ($items->isEmpty()) {
                $items = collect([$cover]);
            }

            // The detail collage has three frames; repeat what we have rather than leave holes.
            $pool = $items->all();
            while (count($pool) < 3) {
                $pool[] = $pool[(count($pool) - 1) % count($items)];
            }

            return $pool;
        });
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => ImagePath::url($this->image, 'activities'));
    }

    /** "08:00 - 18:00" */
    protected function hoursLabel(): Attribute
    {
        return Attribute::get(fn () => $this->opens_at && $this->closes_at
            ? Carbon::parse($this->opens_at)->format('H:i').' - '.Carbon::parse($this->closes_at)->format('H:i')
            : null);
    }

    protected function priceLabel(): Attribute
    {
        return Attribute::get(fn () => Money::idr($this->price_adult));
    }

    protected function priceWasLabel(): Attribute
    {
        return Attribute::get(fn () => $this->price_was ? Money::idr($this->price_was, 'Rp.') : null);
    }

    /** Card meta rows: location, hours, category. */
    protected function meta(): Attribute
    {
        return Attribute::get(fn () => array_values(array_filter([
            ['icon' => 'location.svg', 'label' => $this->place_label ?: $this->location],
            $this->hours_label ? ['icon' => 'clock.svg', 'label' => $this->hours_label] : null,
            ['icon' => 'category.svg', 'label' => $this->category],
        ])));
    }

    /**
     * Anchor tabs on the detail page.
     *
     * @return list<array{label: string, anchor: string}>
     */
    protected function tabs(): Attribute
    {
        return Attribute::get(fn () => array_values(array_filter([
            ['label' => 'Summary', 'anchor' => 'summary'],
            $this->experiences ? ['label' => 'Experiences', 'anchor' => 'experiences'] : null,
            $this->included ? ['label' => 'Inclusions', 'anchor' => 'inclusions'] : null,
            ['label' => 'Important Info', 'anchor' => 'important-info'],
        ])));
    }

    /** Detail-page meta uses a different icon set than the cards. */
    protected function detailMeta(): Attribute
    {
        return Attribute::get(fn () => array_values(array_filter([
            ['icon' => 'pin.svg', 'label' => $this->place_label ?: $this->location],
            $this->hours_label ? ['icon' => 'clock.svg', 'label' => $this->hours_label] : null,
            ['icon' => 'camera.svg', 'label' => $this->category],
        ])));
    }
}
