@extends('layouts.admin')

@section('title', 'Promo Carousel')

@push('styles')
<style>
.banner-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}
.banner-card{background:#fff;border:1px solid var(--admin-line);border-radius:18px;overflow:hidden;box-shadow:0 6px 20px rgba(30,24,18,.04)}
.banner-media{aspect-ratio:16/9;position:relative;background:#eee8de;overflow:hidden}
.banner-media img{width:100%;height:100%;object-fit:cover;display:block}
.banner-body{padding:17px}
.banner-body .order{font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:#8c8378}
.banner-body h3{font:500 20px/1.25 Georgia,serif;margin:6px 0}
.banner-body p{margin:0;font-size:12px;color:#8a8278}
@media(max-width:1050px){.banner-grid{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<div class="page-head">
    <div><p class="eyebrow">Beranda</p><h1>Promo Carousel</h1><p class="muted">Kelola gambar dan teks promo yang tampil bergantian di bagian paling atas halaman utama.</p></div>
    <a class="btn btn-primary" href="{{ route('admin.promo-banners.create') }}">＋ Tambah Banner</a>
</div>

@if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif

<div class="banner-grid">
@forelse($banners as $banner)
    <article class="banner-card">
        <div class="banner-media">
            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}">
            <span class="badge {{ $banner->is_active ? 'active' : 'draft' }}">{{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
        <div class="banner-body">
            <div class="order">Urutan {{ $banner->sort_order }}</div>
            <h3>{{ $banner->title ?: '(Tanpa judul)' }}</h3>
            <p>{{ $banner->subtitle }}</p>
            <div class="actions"><a class="btn btn-soft" href="{{ route('admin.promo-banners.edit', $banner) }}">Edit</a><form method="POST" action="{{ route('admin.promo-banners.destroy', $banner) }}" onsubmit="return confirm('Hapus banner ini?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></div>
        </div>
    </article>
@empty
    <div class="empty"><strong>Belum ada banner promo</strong><span>Tambahkan banner pertama untuk menampilkan carousel promo di halaman utama. Jika belum ada banner, halaman utama akan menampilkan hero standar seperti sebelumnya.</span><a class="btn btn-primary" href="{{ route('admin.promo-banners.create') }}">Tambah Banner</a></div>
@endforelse
</div>
@endsection
