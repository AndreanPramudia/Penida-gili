<?php

namespace App\Models;

use App\Enums\ListingStatus;
use App\Support\ImagePath;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'boat_operator_id', 'name', 'code', 'type', 'capacity', 'top_speed_knots', 'engine',
    'facilities', 'image', 'status', 'inspected_at',
])]
class Vessel extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'facilities' => 'array',
            'status' => ListingStatus::class,
            'inspected_at' => 'date',
        ];
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(BoatOperator::class, 'boat_operator_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => ImagePath::url($this->image ?: 'boat-maruti.png', 'boats'));
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('status', ListingStatus::Active);
    }

    /** Next free code in the SFB-000 sequence. */
    public static function nextCode(): string
    {
        $last = static::query()->where('code', 'like', 'SFB-%')->orderByDesc('code')->value('code');
        $n = $last ? ((int) substr($last, 4)) + 1 : 1;

        return sprintf('SFB-%03d', $n);
    }
}
