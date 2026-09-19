<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleLead;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AnalyticsController extends Controller {
    public function index(Request $request) {
        $from = $request->filled('from') ? $request->date('from')->startOfDay() : now()->subDays(29)->startOfDay();
        $to = $request->filled('to') ? $request->date('to')->endOfDay() : now()->endOfDay();
        $views = ArticleView::whereBetween('created_at',[$from,$to]);
        $leads = ArticleLead::whereBetween('created_at',[$from,$to]);
        $totalViews=(clone $views)->count(); $totalLeads=(clone $leads)->count();
        $conversion=$totalViews ? round(($totalLeads/$totalViews)*100,2) : 0;
        $dailyViews=(clone $views)->selectRaw('DATE(created_at) date, COUNT(*) total')->groupBy('date')->orderBy('date')->pluck('total','date');
        $dailyLeads=(clone $leads)->selectRaw('DATE(created_at) date, COUNT(*) total')->groupBy('date')->orderBy('date')->pluck('total','date');
        $top=Article::query()->select('articles.id','articles.title','articles.slug')
            ->withCount(['leads as leads_count'=>fn($q)=>$q->whereBetween('created_at',[$from,$to])])
            ->withCount(['views as views_count'=>fn($q)=>$q->whereBetween('created_at',[$from,$to])])
            ->orderByDesc('views_count')->limit(10)->get();
        $top->each(function($a){ $a->conversion=$a->views_count ? round(($a->leads_count/$a->views_count)*100,2) : 0; });
        return view('admin.analytics.index',compact('from','to','totalViews','totalLeads','conversion','dailyViews','dailyLeads','top'));
    }
}
