@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="page-head">
    <div><p class="eyebrow">Katalog</p><h1>Produk</h1><p class="muted">Kelola produk yang tampil di katalog publik.</p></div>
    <a class="btn btn-primary" href="{{ route('admin.products.create') }}">＋ Tambah Produk</a>
</div>

@if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif

<form class="filters" method="GET">
    <input name="search" value="{{ request('search') }}" placeholder="Cari nama, SKU, kategori…">
    <select name="status"><option value="">Semua status</option><option value="active" @selected(request('status')==='active')>Aktif</option><option value="draft" @selected(request('status')==='draft')>Draft</option></select>
    <button class="btn btn-soft">Filter</button>
    @if(request()->hasAny(['search','status'])) <a class="clear" href="{{ route('admin.products.index') }}">Reset</a> @endif
</form>

<div class="product-grid">
@forelse($products as $product)
    <article class="product-card">
        <div class="product-media">
            @if($product->image)<img src="{{ $product->image_url }}" alt="{{ $product->name }}">@else<div class="placeholder">NL</div>@endif
            @if($product->featured)<span class="badge featured">Unggulan</span>@endif
            <span class="badge {{ $product->status === 'active' ? 'active' : 'draft' }}">{{ $product->status === 'active' ? 'Aktif' : 'Draft' }}</span>
        </div>
        <div class="product-body">
            <div class="category">{{ $product->category ?: 'Tanpa kategori' }}</div>
            <h3>{{ $product->name }}</h3>
            <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="meta">Stok {{ number_format($product->stock) }} @if($product->sku) · {{ $product->sku }} @endif</div>
            <div class="actions"><a class="btn btn-soft" href="{{ route('admin.products.edit', $product) }}">Edit</a><form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></div>
        </div>
    </article>
@empty
    <div class="empty"><strong>Belum ada produk</strong><span>Tambahkan produk pertama Anda untuk mulai mengisi katalog.</span><a class="btn btn-primary" href="{{ route('admin.products.create') }}">Tambah Produk</a></div>
@endforelse
</div>

<div class="pagination">{{ $products->links() }}</div>
@endsection
