<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaAsset extends Model
{
    protected $fillable = ['name', 'path', 'disk', 'mime_type', 'size', 'alt_text'];
    protected $casts = ['size' => 'integer'];

    public function getUrlAttribute(): string
    {
        $path = ltrim((string) $this->path, '/');
        if ($path === '') return '';
        if (str_starts_with($path, 'assets/')) return '/' . $path;
        return '/storage/' . $path;
    }
}
