<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;

/*------------------------------------------------------------------
|  FUNGSI GENERIK
|-----------------------------------------------------------------*/

/**
 * Kembalikan URL file di disk default, atau placeholder bila tak ada.
 */
if (!function_exists('storage_image_url')) {
    function storage_image_url(?string $path, string $placeholder): string
    {
        $disk = config('filesystems.default');      // <-- aman untuk config:cache

        return $path && Storage::disk($disk)->exists($path)
            ? Storage::disk($disk)->url($path)
            : $placeholder;
    }
}

/**
 * Base-64 avatar sederhana.
 */
if (!function_exists('avatar_placeholder')) {
    function avatar_placeholder(string $name): string
    {
        return Avatar::create(Str::limit($name, 50))->toBase64();
    }
}

/*------------------------------------------------------------------
|  HELPER SPESIFIK
|-----------------------------------------------------------------*/

function getUserImageProfilePath($user): string
{
    return $user?->image && Storage::disk(config('filesystems.default'))->exists($user->image)
        ? Storage::disk(config('filesystems.default'))->url($user->image)
        : avatar_placeholder($user?->name ?? 'User');
}
