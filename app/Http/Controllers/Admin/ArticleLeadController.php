<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleLead;
use Illuminate\Http\Request;

class ArticleLeadController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->string('q')->toString());

        $leads = ArticleLead::query()
            ->leftJoin('articles', 'articles.id', '=', 'article_leads.article_id')
            ->select('article_leads.*', 'articles.title as article_title')
            ->when($q, fn ($query) => $query->where(function ($inner) use ($q) {
                $inner->where('article_leads.name', 'like', "%{$q}%")
                    ->orWhere('article_leads.whatsapp', 'like', "%{$q}%")
                    ->orWhere('article_leads.email', 'like', "%{$q}%")
                    ->orWhere('articles.title', 'like', "%{$q}%");
            }))
            ->latest('article_leads.created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.leads.index', compact('leads', 'q'));
    }
}
