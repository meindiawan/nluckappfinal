<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleWorkflowController extends Controller
{
    public function publish(Article $article)
    {
        $article->update([
            'status' => 'published',
            'published_at' => ($article->published_at && $article->published_at->lte(now())) ? $article->published_at : now(),
        ]);

        return back()->with('success', 'Artikel berhasil diterbitkan.');
    }

    public function unpublish(Article $article)
    {
        $article->update(['status' => 'draft']);

        return back()->with('success', 'Artikel dikembalikan menjadi draft.');
    }

    public function duplicate(Article $article)
    {
        $copy = $article->replicate();
        $copy->title = $article->title . ' (Salinan)';
        $copy->slug = $this->uniqueSlug($copy->title);
        $copy->status = 'draft';
        $copy->published_at = null;
        $copy->featured = false;
        $copy->sort_order = ((int) $article->sort_order) + 1;
        $copy->save();

        return redirect()->route('admin.articles.studio', $copy)
            ->with('success', 'Artikel berhasil diduplikasi.');
    }

    public function preview(Article $article)
    {
        $design = $article->design();

        return view('admin.articles.preview', compact('article', 'design'));
    }

    private function uniqueSlug(string $value): string
    {
        $base = Str::slug($value) ?: Str::random(8);
        $slug = $base;
        $i = 1;

        while (Article::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
