<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleFormSetting;
use App\Models\ArticleLead;
use App\Models\WhatsAppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ArticleLeadController extends Controller
{
    public function store(Request $request, string $slug): RedirectResponse
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->firstOrFail();

        $setting = ArticleFormSetting::current();

        $rules = [
            'name' => $setting->show_name
                ? ['required', 'string', 'max:120']
                : ['nullable'],
            'whatsapp' => $setting->show_whatsapp
                ? ['required', 'string', 'max:30', 'regex:/^[0-9+()\\-\\s.]{3,30}$/']
                : ['nullable'],
            'email' => $setting->show_email
                ? ['nullable', 'string', 'max:150']
                : ['nullable'],
            'birth_date' => $setting->show_birth_date
                ? ['nullable', 'date_format:d/m/Y']
                : ['nullable'],
            'city' => $setting->show_city
                ? ['required', 'string', 'max:100']
                : ['nullable'],
            'instagram' => $setting->show_instagram
                ? ['nullable', 'string', 'max:100']
                : ['nullable'],
            'consent' => $setting->require_consent ? ['accepted'] : ['nullable'],
        ];

        $data = $request->validate($rules, [
            'whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka, spasi, tanda +, -, titik, atau tanda kurung (minimal 3 karakter).',
            'email.max' => 'Email maksimal 150 karakter.',
            'birth_date.date_format' => 'Format tanggal lahir harus DD/MM/YYYY.',
        ]);

        if (! empty($data['whatsapp'])) {
            $data['whatsapp'] = preg_replace('/[^0-9+]/', '', $data['whatsapp']);
        }

        if (! empty($data['birth_date'])) {
            $data['birth_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d');
        }

        $data = array_merge([
            'article_id' => $article->id,
            'consent' => true,
            'source_url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
        ], $data);

        $lead = ArticleLead::create($data);

        // Keep the lead id in session for the verification/analytics flow.
        $request->session()->put('nluck_lead_id', $lead->id);

        // The requested customer journey is immediate: successful form submission
        // goes straight to the configured WhatsApp Group. We still record the click
        // here so no intermediate page can prevent the redirect.
        $setting = WhatsAppSetting::current();
        if ($setting->group_link) {
            $lead->forceFill(['whatsapp_clicked_at' => now()])->save();
            return redirect()->away($setting->group_link);
        }

        return redirect()->route('articles.show', $article->slug)
            ->with('lead_success', 'Data sudah tersimpan. Link WhatsApp Group belum diatur admin.');
    }
}
