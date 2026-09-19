<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleFormSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleFormSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.form-settings.edit', ['setting' => ArticleFormSetting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required','string','max:160'],
            'description' => ['nullable','string','max:1000'],
            'cta_text' => ['required','string','max:100'],
            'success_title' => ['required','string','max:160'],
            'success_message' => ['nullable','string','max:1000'],
            'consent_text' => ['required','string','max:500'],
        ]);

        foreach (['show_name','show_whatsapp','show_email','show_birth_date','show_city','show_instagram','require_email','require_birth_date','require_city','require_instagram','require_consent'] as $key) {
            $data[$key] = $request->boolean($key);
        }

        foreach (['email','birth_date','city','instagram'] as $field) {
            if (!$data['show_'.$field]) $data['require_'.$field] = false;
        }

        ArticleFormSetting::current()->update($data);
        return back()->with('success', 'Pengaturan form artikel berhasil disimpan.');
    }
}
