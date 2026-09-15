<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'area'])]
class Port extends Model
{
    use HasFactory, HasSlug;

    protected function slugSource(): string
    {
        return $this->name;
    }

    public function departures(): HasMany
    {
        return $this->hasMany(Schedule::class, 'from_port_id');
    }

    public function arrivals(): HasMany
    {
        return $this->hasMany(Schedule::class, 'to_port_id');
    }
}
