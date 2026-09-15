<?php

namespace App\Enums;

/**
 * Publication state shared by catalogue rows (vessels, hotels, activities, schedules).
 */
enum ListingStatus: string
{
    case Active = 'active';
    case Draft = 'draft';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Draft => 'Draft',
            self::Inactive => 'Non-Active',
        };
    }

    /** Tone key consumed by the <x-admin.status> badge. */
    public function tone(): string
    {
        return match ($this) {
            self::Active => 'active',
            self::Draft => 'draft',
            self::Inactive => 'inactive',
        };
    }

    /** @return array<string, string> value => label */
    public static function options(): array
    {
        return array_combine(
            array_map(fn (self $s) => $s->value, self::cases()),
            array_map(fn (self $s) => $s->label(), self::cases()),
        );
    }
}
