STEP 18 — Analytics Dashboard

Tujuan: mengukur performa artikel publik berdasarkan views dan leads.

FILES:
- migration create_article_views_table
- ArticleView model
- Admin AnalyticsController
- admin analytics Blade + CSS
- routes/analytics-admin.php
- Article model relationship patch

INSTALL:
1. Copy files into Laravel project.
2. Add routes/analytics-admin.php to routes/web.php (or require it).
3. Add leads() and views() relationships from patches/Article_model_patch.php.txt ke App\Models\Article.
4. Pada public ArticleController@show, setelah artikel lolos validasi published, catat 1 view per session per artikel, contoh:

use App\Models\ArticleView;
if (!session()->has('viewed_article_'.$article->id)) {
    ArticleView::create([
      'article_id'=>$article->id,
      'session_key'=>session()->getId(),
      'ip_hash'=>request()->ip() ? hash('sha256', request()->ip()) : null,
      'user_agent'=>request()->userAgent(),
      'referer'=>request()->header('referer'),
    ]);
    session()->put('viewed_article_'.$article->id, true);
}

5. Pastikan admin layout memiliki @stack('styles').
6. Tambahkan sidebar: route('admin.analytics').
7. Jalankan php artisan migrate.

Catatan: ini menghitung unique-per-session view, bukan analytics kelas Google Analytics. IP disimpan sebagai hash untuk mengurangi penyimpanan data mentah.
