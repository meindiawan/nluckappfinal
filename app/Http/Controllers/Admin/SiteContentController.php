<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteContentController extends Controller
{
    public function edit(string $key): View
    {
        abort_unless(in_array($key, ['filosofi', 'doa'], true), 404);
        return view('admin/site-content/edit', ['content' => SiteContent::current($key), 'key' => $key]);
    }

    public function update(Request $request, string $key): RedirectResponse
    {
        abort_unless(in_array($key, ['filosofi', 'doa'], true), 404);
        $data = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:180'],
            'lead' => ['nullable', 'string', 'max:1200'],
            'quote' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'array'],
            'body.*' => ['nullable', 'string', 'max:1500'],
        ]);
        $data['body_json'] = array_values(array_filter($data['body'] ?? [], fn ($v) => trim((string) $v) !== ''));
        unset($data['body']);
        SiteContent::current($key)->update($data);
        return back()->with('success', ucfirst($key) . ' NLUCK berhasil diperbarui.');
    }
}
