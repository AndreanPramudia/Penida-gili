<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;

/**
 * Stores console uploads on the public disk under uploads/<folder>/ and returns
 * the relative path that ImagePath::url() understands.
 */
final class Uploads
{
    public static function store(?UploadedFile $file, string $folder): ?string
    {
        if (! $file) {
            return null;
        }

        return $file->store('uploads/'.$folder, 'public');
    }

    /**
     * @param  array<int, UploadedFile>|null  $files
     * @return list<array{image: string, alt: string}>
     */
    public static function gallery(?array $files, string $folder, string $alt): array
    {
        return collect($files ?? [])
            ->filter()
            ->map(fn (UploadedFile $file) => ['image' => self::store($file, $folder), 'alt' => $alt])
            ->values()
            ->all();
    }
}
