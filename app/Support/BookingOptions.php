<?php

namespace App\Support;

/**
 * Static option lists for the traveller-details form.
 */
final class BookingOptions
{
    public const GUESTS_PER_ROOM = 4;

    /**
     * Countries offered for nationality + dialling code, with their flag emoji.
     *
     * @return list<array{name: string, flag: string, dial: string}>
     */
    public static function countries(): array
    {
        return [
            ['name' => 'Indonesia', 'flag' => '🇮🇩', 'dial' => '+62'],
            ['name' => 'Australia', 'flag' => '🇦🇺', 'dial' => '+61'],
            ['name' => 'Singapore', 'flag' => '🇸🇬', 'dial' => '+65'],
            ['name' => 'Malaysia', 'flag' => '🇲🇾', 'dial' => '+60'],
            ['name' => 'United Kingdom', 'flag' => '🇬🇧', 'dial' => '+44'],
            ['name' => 'United States', 'flag' => '🇺🇸', 'dial' => '+1'],
            ['name' => 'Germany', 'flag' => '🇩🇪', 'dial' => '+49'],
            ['name' => 'France', 'flag' => '🇫🇷', 'dial' => '+33'],
            ['name' => 'Netherlands', 'flag' => '🇳🇱', 'dial' => '+31'],
            ['name' => 'Spain', 'flag' => '🇪🇸', 'dial' => '+34'],
            ['name' => 'Italy', 'flag' => '🇮🇹', 'dial' => '+39'],
            ['name' => 'Japan', 'flag' => '🇯🇵', 'dial' => '+81'],
            ['name' => 'South Korea', 'flag' => '🇰🇷', 'dial' => '+82'],
            ['name' => 'China', 'flag' => '🇨🇳', 'dial' => '+86'],
            ['name' => 'India', 'flag' => '🇮🇳', 'dial' => '+91'],
            ['name' => 'Thailand', 'flag' => '🇹🇭', 'dial' => '+66'],
            ['name' => 'Philippines', 'flag' => '🇵🇭', 'dial' => '+63'],
            ['name' => 'Vietnam', 'flag' => '🇻🇳', 'dial' => '+84'],
            ['name' => 'New Zealand', 'flag' => '🇳🇿', 'dial' => '+64'],
            ['name' => 'Canada', 'flag' => '🇨🇦', 'dial' => '+1'],
            ['name' => 'Russia', 'flag' => '🇷🇺', 'dial' => '+7'],
            ['name' => 'United Arab Emirates', 'flag' => '🇦🇪', 'dial' => '+971'],
        ];
    }

    /** @return list<string> */
    public static function nationalities(): array
    {
        return array_column(self::countries(), 'name');
    }

    /** @return list<string> */
    public static function dialCodes(): array
    {
        return array_values(array_unique(array_column(self::countries(), 'dial')));
    }
}
