<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['name', 'stars', 'quote', 'experienced_at', 'is_published'])]
class Review extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'experienced_at' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function initials(): Attribute
    {
        return Attribute::get(fn () => collect(explode(' ', $this->name))
            ->take(2)
            ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))
            ->implode(''));
    }

    protected function traveled(): Attribute
    {
        return Attribute::get(fn () => $this->experienceLabel('Traveled'));
    }

    protected function stayed(): Attribute
    {
        return Attribute::get(fn () => $this->experienceLabel('Stayed'));
    }

    /** "Traveled Oct 2023" / "Stayed Oct 2023" — verb depends on what was reviewed. */
    public function experienceLabel(string $verb = 'Traveled'): ?string
    {
        return $this->experienced_at ? $verb.' '.$this->experienced_at->format('M Y') : null;
    }
}
