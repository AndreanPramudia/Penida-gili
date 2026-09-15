<?php

namespace App\Models;

use App\Support\Money;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable(['hotel_id', 'name', 'description', 'guests', 'bed', 'size_label', 'price_per_night', 'stock', 'image', 'sort_order'])]
class HotelRoom extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price_per_night' => 'integer',
        ];
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    protected function priceLabel(): Attribute
    {
        return Attribute::get(fn () => Money::idr($this->price_per_night));
    }

    protected function guestsLabel(): Attribute
    {
        return Attribute::get(fn () => $this->guests.' Guests');
    }
}
