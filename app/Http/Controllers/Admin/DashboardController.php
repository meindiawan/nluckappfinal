<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $productStats = [
            'total' => Product::count(),
            'active' => Product::where('status', 'active')->count(),
            'draft' => Product::where('status', 'draft')->count(),
            'low_stock' => Product::where('status', 'active')->where('stock', '<=', 5)->count(),
        ];

        $articleStats = [
            'total' => Article::count(),
            'published' => Article::where('status', 'published')->count(),
            'draft' => Article::where('status', 'draft')->count(),
            'featured' => Article::where('featured', true)->count(),
        ];

        $latestProducts = Product::query()->latest()->limit(5)->get();
        $latestArticles = Article::query()->latest()->limit(6)->get();
        $featuredArticles = Article::query()
            ->where('featured', true)
            ->where('status', 'published')
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('admin.dashboard', compact(
            'productStats',
            'articleStats',
            'latestProducts',
            'latestArticles',
            'featuredArticles'
        ));
    }
}
