<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    /** Route model binding uses slug (e.g. /produk/aluna-sand) instead of the numeric id. */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'name', 'slug', 'sku', 'category', 'description', 'price',
        'compare_price', 'stock', 'status', 'featured', 'image', 'sort_order',
        'rating', 'review_count', 'gallery', 'colors', 'highlights',
    ];

    protected $casts = [
        'price' => 'integer',
        'compare_price' => 'integer',
        'stock' => 'integer',
        'featured' => 'boolean',
        'sort_order' => 'integer',
        'rating' => 'float',
        'review_count' => 'integer',
        'gallery' => 'array',
        'colors' => 'array',
        'highlights' => 'array',
    ];

    /** Default marketing bullets used only when the admin hasn't set custom ones. */
    public const DEFAULT_HIGHLIGHTS = [
        'Bahan premium voal',
        'Jahitan rapi & kuat',
        'Tersedia berbagai pilihan warna',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->resolveAssetUrl($this->image);
    }

    /** All photos for the gallery/thumbnails, main image first. */
    public function getGalleryUrlsAttribute(): array
    {
        $urls = [];

        if ($this->image_url) {
            $urls[] = $this->image_url;
        }

        foreach ((array) $this->gallery as $path) {
            $url = $this->resolveAssetUrl($path);
            if ($url && ! in_array($url, $urls, true)) {
                $urls[] = $url;
            }
        }

        return $urls;
    }

    /** Highlight bullets, falling back to a generic default set. */
    public function getHighlightListAttribute(): array
    {
        $custom = array_values(array_filter((array) $this->highlights, fn ($h) => trim((string) $h) !== ''));

        return $custom ?: self::DEFAULT_HIGHLIGHTS;
    }

    /** Color options as a clean [{name, hex}] list, skipping anything malformed. */
    public function getColorOptionsAttribute(): array
    {
        return array_values(array_filter(array_map(function ($c) {
            if (! is_array($c) || blank($c['hex'] ?? null)) {
                return null;
            }

            return [
                'name' => $c['name'] ?? '',
                'hex' => $c['hex'],
            ];
        }, (array) $this->colors)));
    }

    /** Public helper so admin views can preview a raw gallery path before it's saved. */
    public function resolveGalleryPreviewUrl(?string $path): ?string
    {
        return $this->resolveAssetUrl($path);
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

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (blank($product->slug)) {
                $product->slug = static::uniqueSlug($product->name);
            }
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name') && ! $product->isDirty('slug')) {
                $product->slug = static::uniqueSlug($product->name, $product->id);
            }
        });
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id','!=',$ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
