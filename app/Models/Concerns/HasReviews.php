<?php

namespace App\Models\Concerns;

use App\Models\Review;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasReviews
{
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable')->latest('experienced_at');
    }

    /** Recalculate the cached rating + count from published reviews. */
    public function refreshRating(): void
    {
        $stats = $this->reviews()->where('is_published', true)
            ->selectRaw('COUNT(*) as total, AVG(stars) as average')
            ->first();

        $this->forceFill([
            'rating' => round((float) ($stats->average ?? 0), 1),
            'review_count' => (int) ($stats->total ?? 0),
        ])->saveQuietly();
    }
}
