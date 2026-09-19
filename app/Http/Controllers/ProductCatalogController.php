<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PromoBanner;
use Illuminate\Http\Request;

class ProductCatalogController extends Controller
{
    public function index(Request $request)
    {
        $featuredProducts = Product::where('status', 'active')->orderByDesc('featured')->orderBy('sort_order')->limit(4)->get();
        $latestArticles = \App\Models\Article::where('status', 'published')->where(fn($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()))->orderByDesc('featured')->orderBy('sort_order')->latest('published_at')->limit(3)->get();
        $promoBanners = PromoBanner::forCarousel();

        return view('welcome', compact('featuredProducts', 'latestArticles', 'promoBanners'));
    }

    /**
     * Full product catalog listing with search, category filter and pagination.
     * This is the page every "Lihat katalog" / "Koleksi" link across the site points to.
     */
    public function browse(Request $request)
    {
        $query = Product::where('status', 'active');

        if ($request->filled('q')) {
            $term = trim((string) $request->string('q'));
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%")
                  ->orWhere('category', 'like', "%{$term}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        $categories = Product::where('status', 'active')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $products = $query->orderByDesc('featured')->orderBy('sort_order')->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->where('status', 'active')->firstOrFail();
        $related = Product::where('status', 'active')->where('id','!=',$product->id)
            ->when($product->category, fn ($q) => $q->where('category', $product->category))
            ->orderByDesc('featured')->orderBy('sort_order')->limit(4)->get();

        return view('products.show', compact('product', 'related'));
    }
}
