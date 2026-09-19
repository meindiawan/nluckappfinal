<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoBanner extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'image', 'button_text', 'link_url', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->resolveAssetUrl($this->image);
    }

    /** Banners shown on the public homepage carousel, in admin-defined order. */
    public static function forCarousel()
    {
        return static::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
    }

    private function resolveAssetUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, 'assets/')) {
            return asset($path);
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
