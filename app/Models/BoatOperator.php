<?php

namespace App\Models;

use App\Models\Concerns\HasReviews;
use App\Models\Concerns\HasSlug;
use App\Support\ImagePath;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name', 'slug', 'description', 'tagline', 'rating', 'review_count', 'image', 'hero_image',
    'top_speed_knots', 'capacity', 'facilities', 'gallery', 'is_active',
])]
class BoatOperator extends Model
{
    use HasFactory, HasReviews, HasSlug;

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:1',
            'facilities' => 'array',
            'gallery' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected function slugSource(): string
    {
        return $this->name;
    }

    public function vessels(): HasMany
    {
        return $this->hasMany(Vessel::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class)->orderBy('departure_time');
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
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
                ->map(fn (array $photo) => $photo + ['url' => ImagePath::url($photo['image'], 'boats/gallery')])
                ->values();

            if ($items->isNotEmpty()) {
                return $items->all();
            }

            // No studio shots yet: show the operator's own photo, plus any vessel photos.
            $fallback = collect([['image' => $this->image, 'alt' => $this->name, 'url' => ImagePath::url($this->image, 'boats')]]);

            return $fallback
                ->merge($this->vessels->map(fn ($vessel) => [
                    'image' => $vessel->image,
                    'alt' => $vessel->name,
                    'url' => $vessel->image_url,
                ]))
                ->unique('url')
                ->values()
                ->all();
        });
    }

    /** Public URL of the card image. */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => ImagePath::url($this->image, 'boats'));
    }

    protected function heroImageUrl(): Attribute
    {
        return Attribute::get(fn () => ImagePath::url($this->hero_image ?: $this->image, 'boats'));
    }

    /** "120+" style label for the detail hero. */
    protected function reviewCountLabel(): Attribute
    {
        return Attribute::get(fn () => $this->review_count >= 10
            ? number_format(intdiv($this->review_count, 10) * 10).'+'
            : (string) $this->review_count);
    }

    /**
     * Spec tiles for the detail page.
     *
     * @return list<array{icon: string, label: string, value: string}>
     */
    protected function specs(): Attribute
    {
        return Attribute::get(fn () => array_values(array_filter([
            $this->top_speed_knots ? ['icon' => 'speed.svg', 'label' => 'Top Speed', 'value' => $this->top_speed_knots.' Knots'] : null,
            $this->capacity ? ['icon' => 'capacity.svg', 'label' => 'Capacity', 'value' => $this->capacity.' Pax'] : null,
        ])));
    }
}
