<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q'));

        $assets = MediaAsset::query()
            ->when($q, fn ($query) => $query->where(function ($x) use ($q) {
                $x->where('name', 'like', "%{$q}%")
                    ->orWhere('alt_text', 'like', "%{$q}%");
            }))
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('admin.media.index', compact('assets', 'q'));
    }

    public function libraryJson(Request $request)
    {
        $q = trim((string) $request->input('q'));

        $assets = MediaAsset::query()
            ->when($q, fn ($query) => $query->where(function ($x) use ($q) {
                $x->where('name', 'like', "%{$q}%")
                    ->orWhere('alt_text', 'like', "%{$q}%");
            }))
            ->latest()
            ->limit(100)
            ->get()
            ->map(fn (MediaAsset $asset) => $this->toJsonAsset($asset));

        return response()->json(['data' => $assets]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => ['required', 'array', 'max:20'],
            'files.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        $created = collect();

        foreach ($request->file('files', []) as $file) {
            $path = $file->store('media', 'public');

            $asset = MediaAsset::create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'disk' => 'public',
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            $created->push($asset);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Asset berhasil diunggah.',
                'data' => $created->map(fn (MediaAsset $asset) => $this->toJsonAsset($asset))->values(),
            ], 201);
        }

        return back()->with('success', 'Asset berhasil diunggah.');
    }

    public function update(Request $request, MediaAsset $media)
    {
        $data = $request->validate([
            'alt_text' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $media->update($data);

        return back()->with('success', 'Asset diperbarui.');
    }

    public function destroy(MediaAsset $media)
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();

        return back()->with('success', 'Asset dihapus.');
    }

    private function toJsonAsset(MediaAsset $asset): array
    {
        $width = null;
        $height = null;

        try {
            $absolutePath = Storage::disk($asset->disk)->path($asset->path);
            if (is_file($absolutePath) && str_starts_with((string) $asset->mime_type, 'image/')) {
                $size = @getimagesize($absolutePath);
                if (is_array($size)) {
                    $width = $size[0] ?? null;
                    $height = $size[1] ?? null;
                }
            }
        } catch (\Throwable $e) {
            // Dimensions are optional metadata; never break the library response.
        }

        return [
            'id' => $asset->id,
            'name' => $asset->name,
            'url' => $asset->url,
            'mime_type' => $asset->mime_type,
            'size' => $asset->size,
            'alt_text' => $asset->alt_text,
            'width' => $width,
            'height' => $height,
        ];
    }
}
