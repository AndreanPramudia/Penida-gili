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
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name', 'slug', 'category', 'partner_label', 'stars', 'rating', 'review_count', 'description',
    'address', 'full_address', 'image', 'gallery', 'amenities', 'status',
    'region', 'harbor_distance', 'coordinates',
])]
class Hotel extends Model
{
    use HasFactory, HasReviews, HasSlug;

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:1',
            'gallery' => 'array',
            'amenities' => 'array',
            'status' => ListingStatus::class,
        ];
    }

    protected function slugSource(): string
    {
        return $this->name;
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(HotelRoom::class)->orderBy('sort_order')->orderBy('price_per_night');
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
                ->map(fn (array $photo) => $photo + ['url' => ImagePath::url($photo['image'], 'hotels/detail')])
                ->values();

            return $items->isNotEmpty()
                ? $items->all()
                : [['image' => $this->image, 'alt' => $this->name, 'url' => ImagePath::url($this->image, 'hotels')]];
        });
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => ImagePath::url($this->image, 'hotels'));
    }

    /** Cheapest room rate, in rupiah. */
    protected function priceFrom(): Attribute
    {
        return Attribute::get(fn () => (int) ($this->relationLoaded('rooms')
            ? $this->rooms->min('price_per_night')
            : $this->rooms()->min('price_per_night')));
    }

    protected function priceFromLabel(): Attribute
    {
        return Attribute::get(fn () => Money::idr($this->price_from));
    }

    protected function priceFromCompact(): Attribute
    {
        return Attribute::get(fn () => Money::compact($this->price_from));
    }

    /**
     * Sidebar picker choices; the value is "guests-rooms" so the label's room count
     * is what the order page actually quotes.
     *
     * @return array<string, string> "guests-rooms" => label
     */
    protected function guestOptions(): Attribute
    {
        return Attribute::get(fn () => ['2-1' => '2 Guests, 1 Room', '3-1' => '3 Guests, 1 Room', '4-2' => '4 Guests, 2 Rooms']);
    }

    protected function defaultNights(): Attribute
    {
        return Attribute::get(fn () => 2);
    }

    protected function defaultTotalLabel(): Attribute
    {
        return Attribute::get(fn () => Money::idr($this->price_from * $this->default_nights));
    }

    /** Card meta rows (location pin). */
    protected function meta(): Attribute
    {
        return Attribute::get(fn () => [
            ['icon' => 'location.svg', 'label' => $this->address],
        ]);
    }
}
