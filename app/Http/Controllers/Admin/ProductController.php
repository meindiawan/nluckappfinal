<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $term = trim($request->string('search')->toString());
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%")
                  ->orWhere('category', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status') && in_array($request->status, ['active', 'draft'], true)) {
            $query->where('status', $request->status);
        }

        $products = $query->orderByDesc('featured')->orderBy('sort_order')->orderByDesc('id')->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.create', ['product' => new Product(['status' => 'active'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            $data['gallery'] = collect($request->file('gallery'))
                ->map(fn ($file) => $file->store('products', 'public'))
                ->values()->all();
        }

        $data['colors'] = $this->parseColors($request->string('colors_raw')->toString());
        $data['highlights'] = $this->parseLines($request->string('highlights_raw')->toString());

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request, $product);

        $newImagePath = null;
        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $newImagePath;
        }

        if ($request->boolean('remove_image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }
            $data['image'] = null;
        } elseif ($newImagePath && $product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $existingGallery = (array) $product->gallery;
        $keep = (array) $request->input('keep_gallery', array_keys($existingGallery));
        foreach ($existingGallery as $index => $path) {
            if (! in_array((string) $index, array_map('strval', $keep), true)) {
                Storage::disk('public')->delete($path);
                unset($existingGallery[$index]);
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $existingGallery[] = $file->store('products', 'public');
            }
        }

        $data['gallery'] = array_values($existingGallery);
        $data['colors'] = $this->parseColors($request->string('colors_raw')->toString());
        $data['highlights'] = $this->parseLines($request->string('highlights_raw')->toString());

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'sku' => ['nullable', 'string', 'max:80', 'unique:products,sku,' . ($product?->id ?? 'NULL')],
            'category' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'integer', 'min:0', 'max:999999999'],
            'compare_price' => ['nullable', 'integer', 'min:0', 'max:999999999'],
            'stock' => ['required', 'integer', 'min:0', 'max:999999'],
            'status' => ['required', 'in:active,draft'],
            'featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'gallery' => ['nullable', 'array', 'max:8'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'keep_gallery' => ['nullable', 'array'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'review_count' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'colors_raw' => ['nullable', 'string', 'max:2000'],
            'highlights_raw' => ['nullable', 'string', 'max:2000'],
        ]);
    }

    /** Parse "Nama|#hex" lines from the admin form into a clean [{name,hex}] array. */
    private function parseColors(string $raw): array
    {
        $colors = [];

        foreach ($this->parseLines($raw) as $line) {
            [$name, $hex] = array_pad(explode('|', $line, 2), 2, null);
            $hex = trim((string) ($hex ?? $name));
            $name = $hex === trim((string) $name) ? '' : trim((string) $name);

            if (preg_match('/^#[0-9a-fA-F]{3,8}$/', $hex)) {
                $colors[] = ['name' => $name, 'hex' => $hex];
            }
        }

        return $colors;
    }

    /** Split a textarea into trimmed, non-empty lines. */
    private function parseLines(string $raw): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $raw))
            ->map(fn ($line) => trim($line))
            ->filter(fn ($line) => $line !== '')
            ->values()->all();
    }
}
