<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'role'])]
class Author extends Model
{
    use HasFactory;

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /** "Capt. Wayan Sudira - Master Mariner" as shown in the editor's AUTHOR bar. */
    protected function signature(): Attribute
    {
        return Attribute::get(fn () => $this->role ? "{$this->name} - {$this->role}" : $this->name);
    }
}
