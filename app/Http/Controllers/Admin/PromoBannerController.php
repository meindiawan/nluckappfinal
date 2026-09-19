<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PromoBannerController extends Controller
{
    public function index(): View
    {
        $banners = PromoBanner::orderBy('sort_order')->orderByDesc('id')->get();

        return view('admin.promo-banners.index', compact('banners'));
    }

    public function create(): View
    {
        return view('admin.promo-banners.create', ['banner' => new PromoBanner(['is_active' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('promo-banners', 'public');
        }

        PromoBanner::create($data);

        return redirect()->route('admin.promo-banners.index')->with('success', 'Banner promo berhasil ditambahkan.');
    }

    public function edit(PromoBanner $promoBanner): View
    {
        return view('admin.promo-banners.edit', ['banner' => $promoBanner]);
    }

    public function update(Request $request, PromoBanner $promoBanner): RedirectResponse
    {
        $data = $this->validated($request, $promoBanner);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('promo-banners', 'public');

            if ($promoBanner->image) {
                Storage::disk('public')->delete($promoBanner->image);
            }
        }

        $promoBanner->update($data);

        return redirect()->route('admin.promo-banners.index')->with('success', 'Banner promo berhasil diperbarui.');
    }

    public function destroy(PromoBanner $promoBanner): RedirectResponse
    {
        if ($promoBanner->image) {
            Storage::disk('public')->delete($promoBanner->image);
        }

        $promoBanner->delete();

        return back()->with('success', 'Banner promo berhasil dihapus.');
    }

    private function validated(Request $request, ?PromoBanner $banner = null): array
    {
        return $request->validate([
            'title' => ['nullable', 'string', 'max:150'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:60'],
            'link_url' => ['nullable', 'string', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'image' => [$banner ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
    }
}
