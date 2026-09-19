<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLead;
use App\Models\WhatsAppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ArticleWhatsAppController extends Controller
{
    public function click(Request $request, string $slug, ArticleLead $lead): RedirectResponse
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->firstOrFail();

        abort_unless(
            (int) $lead->article_id === (int) $article->id &&
            (int) $request->session()->get('nluck_lead_id') === (int) $lead->id,
            404
        );

        if (! $lead->whatsapp_clicked_at) {
            $lead->forceFill(['whatsapp_clicked_at' => now()])->save();
        }

        $setting = WhatsAppSetting::current();

        if (! $setting->group_link) {
            return redirect()->route('articles.show', $article->slug)
                ->with('lead_success', 'Data sudah tersimpan. Link WhatsApp Group belum diatur admin.');
        }

        return redirect()->away($setting->group_link);
    }
}
