<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicAssetController extends Controller
{
    /**
     * Fallback for /storage/* when the public/storage symlink is unavailable
     * (common with Windows + PHP's built-in server). The normal static file
     * route is still preferred when public/storage works.
     */
    public function show(string $path): BinaryFileResponse|Response
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');

        if ($path === '' || str_contains($path, '..')) {
            abort(404);
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($path)) {
            abort(404);
        }

        $absolute = $disk->path($path);
        if (!is_file($absolute)) {
            abort(404);
        }

        $mime = $disk->mimeType($path) ?: 'application/octet-stream';

        return response()->file($absolute, [
            'Content-Type' => $mime,
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
