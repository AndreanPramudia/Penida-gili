<?php

namespace App\Models;

use App\Enums\ListingStatus;
use App\Support\Money;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

#[Fillable([
    'boat_operator_id',
    'vessel_id',
    'route_id',
    'departure_time',
    'arrival_time',
    'price_adult',
    'price_child',
    'price_foreign',
    'days',
    'status',
])]
class Schedule extends Model
{
    use HasFactory;

    public const DAYS = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    protected function casts(): array
    {
        return [
            'days' => 'array',
            'status' => ListingStatus::class,
            'price_adult' => 'integer',
            'price_child' => 'integer',
            'price_foreign' => 'integer',
        ];
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(BoatOperator::class, 'boat_operator_id');
    }

    public function vessel(): BelongsTo
    {
        return $this->belongsTo(Vessel::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
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

    #[Scope]
    protected function betweenPorts(Builder $query, ?string $from, ?string $to): Builder
    {
        return $query
            ->when(
                filled($from),
                fn (Builder $q) => $q->whereHas(
                    'route.originPort',
                    fn (Builder $p) => $p
                        ->where('name', 'like', '%'.trim($from).'%')
                        ->orWhere('area', 'like', '%'.trim($from).'%')
                        ->orWhere('slug', 'like', '%'.str($from)->slug().'%')
                )
            )
            ->when(
                filled($to),
                fn (Builder $q) => $q->whereHas(
                    'route.destinationPort',
                    fn (Builder $p) => $p
                        ->where('name', 'like', '%'.trim($to).'%')
                        ->orWhere('area', 'like', '%'.trim($to).'%')
                        ->orWhere('slug', 'like', '%'.str($to)->slug().'%')
                )
            );
    }
    public function nextDate(?Carbon $from = null): Carbon
    {
    $date = ($from ?? Carbon::today())->copy();

    for ($i = 0; $i < 7 && ! $this->operatesOn($date); $i++) {
        $date->addDay();
    }

    return $date;
    }

    public function operatesOn(Carbon $date): bool
    {
    return empty($this->days) || in_array($date->format('D'), $this->days, true);
    }

    

    protected function from(): Attribute
    {
        return Attribute::get(fn () => $this->route->originPort->name);
    }

    protected function to(): Attribute
    {
        return Attribute::get(fn () => $this->route->destinationPort->name);
    }

    protected function departure(): Attribute
    {
        return Attribute::get(fn () => $this->departure_label);
    }

    protected function arrival(): Attribute
    {
        return Attribute::get(fn () => $this->arrival_label);
    }

    protected function price(): Attribute
    {
        return Attribute::get(fn () => $this->price_label);
    }

    protected function routeLabel(): Attribute
    {
        return Attribute::get(fn () => $this->route->name);
    }

    protected function departureLabel(): Attribute
    {
        return Attribute::get(
            fn () => Carbon::parse($this->departure_time)->format('h:i A')
        );
    }

    protected function arrivalLabel(): Attribute
    {
        return Attribute::get(
            fn () => Carbon::parse($this->arrival_time)->format('h:i A')
        );
    }

    protected function durationMinutes(): Attribute
    {
        return Attribute::get(
            fn () => Carbon::parse($this->departure_time)
                ->diffInMinutes(Carbon::parse($this->arrival_time))
        );
    }

    protected function priceLabel(): Attribute
    {
        return Attribute::get(
            fn () => Money::idr($this->price_adult, 'Rp.')
        );
    }
}