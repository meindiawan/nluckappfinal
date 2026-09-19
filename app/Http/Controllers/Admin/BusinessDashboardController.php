<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleLead;
use App\Models\ArticleView;
use App\Models\Product;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BusinessDashboardController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        $from = $request->filled('from')
            ? Carbon::parse($request->input('from'))->startOfDay()
            : now()->subDays(6)->startOfDay();

        $to = $request->filled('to')
            ? Carbon::parse($request->input('to'))->endOfDay()
            : now()->endOfDay();

        $viewsQuery = ArticleView::query()->whereBetween('created_at', [$from, $to]);
        $leadsQuery = ArticleLead::query()->whereBetween('created_at', [$from, $to]);

        $totalViews = (clone $viewsQuery)->count();
        $totalLeads = (clone $leadsQuery)->count();
        $whatsapp = (clone $leadsQuery)->whereNotNull('whatsapp_clicked_at')->count();
        $conversion = $totalViews > 0 ? round(($totalLeads / $totalViews) * 100, 2) : 0;

        $daily = [];
        for ($date = $from->copy()->startOfDay(); $date->lte($to); $date->addDay()) {
            $key = $date->format('Y-m-d');
            $daily[] = [
                'date' => $key,
                'label' => $date->format('d/m'),
                'views' => (clone $viewsQuery)->whereDate('created_at', $key)->count(),
                'leads' => (clone $leadsQuery)->whereDate('created_at', $key)->count(),
            ];
        }

        $maxChart = max(1, ...array_map(
            fn (array $day) => max((int) $day['views'], (int) $day['leads']),
            $daily
        ));

        $chartPoints = [];
        $chartLeadsPoints = [];
        $chartCount = count($daily);
        foreach ($daily as $index => $day) {
            $x = $chartCount <= 1 ? 50 : 8 + ($index * 84 / ($chartCount - 1));
            $viewY = 92 - (((int) $day['views'] / $maxChart) * 78);
            $leadY = 92 - (((int) $day['leads'] / $maxChart) * 78);
            $chartPoints[] = round($x, 2) . ',' . round($viewY, 2);
            $chartLeadsPoints[] = round($x, 2) . ',' . round($leadY, 2);
        }

        $articles = Article::query()
            ->withCount([
                'views as views_count' => fn ($query) => $query->whereBetween('created_at', [$from, $to]),
                'leads as leads_count' => fn ($query) => $query->whereBetween('created_at', [$from, $to]),
            ])
            ->orderByDesc('views_count')
            ->limit(8)
            ->get();

        $articles->each(function (Article $article) {
            $article->conversion = $article->views_count > 0
                ? round(($article->leads_count / $article->views_count) * 100, 1)
                : 0;
        });

        $productStats = [
            'total' => Product::count(),
            'active' => Product::where('status', 'active')->count(),
            'draft' => Product::where('status', '!=', 'active')->count(),
            'low_stock' => Product::where('status', 'active')->where('stock', '<=', 5)->count(),
        ];

        $articleStats = [
            'total' => Article::count(),
            'published' => Article::where('status', 'published')->count(),
            'draft' => Article::where('status', 'draft')->count(),
            'featured' => Article::where('featured', true)->count(),
        ];

        $latestArticles = Article::query()
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->latest('updated_at')
            ->limit(6)
            ->get();

        $featuredArticles = Article::query()
            ->where('featured', true)
            ->orderBy('sort_order')
            ->latest('updated_at')
            ->limit(4)
            ->get();

        $latestProducts = Product::query()
            ->where('status', 'active')
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->latest('updated_at')
            ->limit(6)
            ->get();

        $recentLeads = ArticleLead::with('article')->latest()->limit(6)->get();
        $siteContent = [
            'filosofi' => SiteContent::current('filosofi'),
            'doa' => SiteContent::current('doa'),
        ];

        $activities = collect();
        foreach ($recentLeads as $lead) {
            $activities->push([
                'type' => 'lead',
                'title' => 'Lead baru: ' . $lead->name,
                'meta' => ($lead->article?->title ?: 'NLUCK Journal') . ' · ' . $lead->created_at->diffForHumans(),
                'time' => $lead->created_at,
            ]);
        }

        foreach (Article::query()->latest('updated_at')->limit(4)->get() as $article) {
            $activities->push([
                'type' => 'article',
                'title' => 'Artikel diperbarui: ' . ($article->title ?: 'Tanpa judul'),
                'meta' => ucfirst($article->status) . ' · ' . $article->updated_at->diffForHumans(),
                'time' => $article->updated_at,
            ]);
        }

        $activities = $activities->sortByDesc('time')->take(7)->values();

        $pages = [
            ['name' => 'Beranda', 'route' => 'catalog', 'description' => 'Hero, koleksi, cerita, filosofi, dan doa.'],
            ['name' => 'Koleksi', 'route' => 'catalog.browse', 'description' => 'Semua produk aktif yang tampil di katalog.'],
            ['name' => 'Artikel', 'route' => 'articles.index', 'description' => 'Artikel yang diterbitkan melalui NLUCK Studio.'],
            ['name' => 'Tentang Kami', 'route' => 'pages.about', 'description' => 'Cerita dan identitas NLUCK.'],
            ['name' => 'Filosofi', 'route' => 'pages.philosophy', 'description' => 'Nilai dan prinsip di balik NLUCK.'],
            ['name' => 'Doa', 'route' => 'pages.doa', 'description' => 'Pesan dan doa untuk setiap langkah.'],
        ];

        return view('admin.dashboard', compact(
            'from',
            'to',
            'totalViews',
            'totalLeads',
            'whatsapp',
            'conversion',
            'daily',
            'maxChart',
            'chartPoints',
            'chartLeadsPoints',
            'articles',
            'productStats',
            'articleStats',
            'latestArticles',
            'featuredArticles',
            'latestProducts',
            'recentLeads',
            'siteContent',
            'activities',
            'pages'
        ));
    }
}
