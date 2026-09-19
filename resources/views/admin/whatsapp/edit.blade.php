@extends('layouts.admin')

@section('title', 'WhatsApp & Sosial Media')

@section('content')
<div class="wa-page">
    <div class="wa-head">
        <div>
            <div class="eyebrow">CUSTOMER FLOW</div>
            <h1>WhatsApp & Sosial Media</h1>
            <p>Atur tujuan WhatsApp yang dibuka setelah pelanggan mengisi form artikel, tombol pemesanan di katalog produk, dan tautan sosial media yang tampil di footer situs.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="wa-alert">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.whatsapp.update') }}" class="wa-card">
        @csrf @method('PUT')

        <div class="wa-section-title">WhatsApp Group</div>
        <label>Nama Group
            <input name="group_name" value="{{ old('group_name', $setting->group_name) }}" required>
        </label>
        @error('group_name')<small>{{ $message }}</small>@enderror

        <label>Link Undangan WhatsApp Group
            <input type="url" name="group_link" placeholder="https://chat.whatsapp.com/..." value="{{ old('group_link', $setting->group_link) }}" required>
        </label>
        @error('group_link')<small>{{ $message }}</small>@enderror
        <div class="wa-help">Gunakan link undangan <b>chat.whatsapp.com/...</b>. Setelah form artikel berhasil dikirim, dan setiap kali pelanggan menekan tombol "Gabung Grup" atau "Pesan Sekarang" di katalog produk, mereka akan diarahkan ke link ini.</div>

        <label>Judul setelah berhasil
            <input name="success_title" value="{{ old('success_title', $setting->success_title) }}" required>
        </label>

        <label>Pesan setelah berhasil
            <textarea name="success_message" rows="4" required>{{ old('success_message', $setting->success_message) }}</textarea>
        </label>

        <div class="wa-section-title">Kontak Langsung (opsional)</div>
        <label>Nomor WhatsApp Admin
            <input name="contact_whatsapp" placeholder="08123456789" value="{{ old('contact_whatsapp', $setting->contact_whatsapp) }}">
        </label>
        @error('contact_whatsapp')<small>{{ $message }}</small>@enderror
        <div class="wa-help">Jika diisi, tombol "Chat Admin" akan muncul di footer dan mengarah langsung ke chat pribadi (bukan grup).</div>

        <label>Email Kontak
            <input type="email" name="contact_email" placeholder="hello@nluck.id" value="{{ old('contact_email', $setting->contact_email) }}">
        </label>
        @error('contact_email')<small>{{ $message }}</small>@enderror

        <div class="wa-section-title">Sosial Media</div>
        <label>Link Instagram
            <input type="url" name="instagram_url" placeholder="https://instagram.com/nluck.id" value="{{ old('instagram_url', $setting->instagram_url) }}">
        </label>
        @error('instagram_url')<small>{{ $message }}</small>@enderror

        <label>Link TikTok
            <input type="url" name="tiktok_url" placeholder="https://tiktok.com/@nluck.id" value="{{ old('tiktok_url', $setting->tiktok_url) }}">
        </label>
        @error('tiktok_url')<small>{{ $message }}</small>@enderror

        <label>Link Facebook
            <input type="url" name="facebook_url" placeholder="https://facebook.com/nluck.id" value="{{ old('facebook_url', $setting->facebook_url) }}">
        </label>
        @error('facebook_url')<small>{{ $message }}</small>@enderror
        <div class="wa-help">Kosongkan jika belum punya akun — ikon yang linknya kosong tidak akan ditampilkan di footer.</div>

        <div class="wa-actions"><button type="submit">Simpan Pengaturan</button></div>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('admin-assets/whatsapp/settings.css') }}">
<style>.wa-section-title{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#a37f5d;margin:26px 0 10px;padding-top:18px;border-top:1px solid #eee1d2}.wa-section-title:first-of-type{margin-top:0;padding-top:0;border-top:0}</style>
@endpush
