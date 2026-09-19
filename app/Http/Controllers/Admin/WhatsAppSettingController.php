<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppSetting;
use Illuminate\Http\Request;

class WhatsAppSettingController extends Controller
{
    public function edit()
    {
        return view('admin.whatsapp.edit', ['setting' => WhatsAppSetting::current()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'group_name' => ['required', 'string', 'max:100'],
            'group_link' => ['required', 'url', 'max:2000'],
            'success_title' => ['required', 'string', 'max:150'],
            'success_message' => ['required', 'string', 'max:1000'],
            'contact_whatsapp' => ['nullable', 'string', 'max:30'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
        ]);

        $host = strtolower((string) parse_url($data['group_link'], PHP_URL_HOST));
        if ($host !== 'chat.whatsapp.com') {
            return back()->withErrors(['group_link' => 'Masukkan link undangan WhatsApp Group dari chat.whatsapp.com.'])->withInput();
        }

        WhatsAppSetting::current()->update($data);

        return back()->with('success', 'Pengaturan WhatsApp & sosial media berhasil disimpan.');
    }
}
