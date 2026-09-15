<?php

namespace App\Support;

/**
 * Prices are stored as whole rupiah integers; this is the single place that
 * turns them into the "IDR 180.000" strings the Figma screens use.
 */
final class Money
{
    public static function idr(int|float|null $amount, string $prefix = 'IDR'): string
    {
        return trim($prefix.' '.number_format((int) round($amount ?? 0), 0, ',', '.'));
    }

    /** Compact form used on price-from labels, e.g. "IDR 2,500K". */
    public static function compact(int|float|null $amount, string $prefix = 'IDR'): string
    {
        $amount = (int) round($amount ?? 0);

        if ($amount >= 1_000_000) {
            return sprintf('%s %sM', $prefix, rtrim(rtrim(number_format($amount / 1_000_000, 1), '0'), '.'));
        }

        if ($amount >= 1_000) {
            return sprintf('%s %sK', $prefix, number_format(intdiv($amount, 1_000), 0, ',', ','));
        }

        return self::idr($amount, $prefix);
    }
}
