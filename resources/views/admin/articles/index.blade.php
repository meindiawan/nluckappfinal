@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('admin-assets/article-catalog.css') }}">
@endpush

@section('content')
<div class="article-catalog-page">
  <div class="catalog-head">
    <div>
      <div class="eyebrow">CONTENT STUDIO</div>
      <h1>Artikel</h1>
      <p>Kelola semua artikel seperti katalog. Pilih artikel untuk langsung masuk ke NLUCK Studio.</p>
    </div>
    <a class="catalog-btn catalog-btn-primary" href="{{ route('admin.articles.create') }}">＋ Artikel baru</a>
  </div>

  @if(session('success'))<div class="catalog-alert success">{{ session('success') }}</div>@endif

  <form class="catalog-toolbar" method="get">
    <label class="search-box"><span>⌕</span><input name="q" value="{{ $q ?? request('q') }}" placeholder="Cari judul, slug, atau ringkasan…"></label>
    <select name="status" aria-label="Status artikel">
      <option value="">Semua status</option>
      <option value="published" @selected(request('status')==='published')>Published</option>
      <option value="draft" @selected(request('status')==='draft')>Draft</option>
    </select>
    <select name="featured" aria-label="Featured">
      <option value="">Semua artikel</option>
      <option value="1" @selected(request('featured')==='1')>Featured</option>
      <option value="0" @selected(request('featured')==='0')>Non-featured</option>
    </select>
    <button class="catalog-btn" type="submit">Filter</button>
    @if(request()->hasAny(['q','status','featured']))<a class="clear-link" href="{{ route('admin.articles.index') }}">Reset</a>@endif
  </form>

  <div class="catalog-summary"><strong>{{ $articles->total() }}</strong> artikel <span>•</span> tampil {{ $articles->firstItem() ?: 0 }}–{{ $articles->lastItem() ?: 0 }}</div>

  <div class="article-grid">
    @forelse($articles as $article)
      <article class="article-card">
        <a class="article-cover" href="{{ route('admin.articles.studio', $article) }}">
          @if($article->thumbnail)
            <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" loading="lazy">
          @else
            <div class="cover-placeholder"><img src="{{ asset('studio/assets/nluck-wordmark.png') }}" alt="NLUCK"></div>
          @endif
          <div class="cover-overlay"><span>BUKA STUDIO</span></div>
          <div class="status-pill {{ $article->status }}">{{ $article->status === 'published' ? 'Published' : 'Draft' }}</div>
          @if($article->featured)<div class="featured-pill">★ Featured</div>@endif
        </a>
        <div class="article-body">
          <div class="article-date">{{ $article->published_at?->format('d M Y') ?? 'Belum diterbitkan' }}</div>
          <h2><a href="{{ route('admin.articles.studio', $article) }}">{{ $article->title ?: 'Tanpa judul' }}</a></h2>
          <p>{{ $article->excerpt ?: 'Belum ada ringkasan artikel.' }}</p>
          <div class="article-slug">/{{ $article->slug }}</div>
          <div class="article-actions">
            <a class="catalog-btn catalog-btn-primary" href="{{ route('admin.articles.studio', $article) }}">Studio</a>
            @if($article->status === 'published')
              <a class="catalog-btn" target="_blank" href="{{ route('articles.show', $article) }}">Lihat</a>
            @endif
            <a class="catalog-btn" href="{{ route('admin.articles.edit', $article) }}">Edit</a>
            <a class="catalog-btn" href="{{ route('admin.articles.qr', $article) }}">QR</a>
            <div class="more-actions">
              <button type="button" class="more-btn" aria-label="Aksi artikel" onclick="this.nextElementSibling.classList.toggle('open')">•••</button>
              <div class="more-menu">
                <a href="{{ route('admin.articles.preview', $article) }}" target="_blank">Preview</a>
                <form method="post" action="{{ route('admin.articles.duplicate', $article) }}">@csrf<button>Duplikat</button></form>
                @if($article->status === 'published')
                  <form method="post" action="{{ route('admin.articles.unpublish', $article) }}">@csrf<button>Kembali ke Draft</button></form>
                @else
                  <form method="post" action="{{ route('admin.articles.publish', $article) }}">@csrf<button>Terbitkan</button></form>
                @endif
                <form method="post" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?')">@csrf @method('DELETE')<button class="danger">Hapus</button></form>
              </div>
            </div>
          </div>
        </div>
      </article>
    @empty
      <div class="catalog-empty"><div class="empty-icon">✦</div><h2>Belum ada artikel</h2><p>Buat artikel pertama dan lanjutkan desainnya di NLUCK Studio.</p><a class="catalog-btn catalog-btn-primary" href="{{ route('admin.articles.create') }}">Buat artikel</a></div>
    @endforelse
  </div>

  <div class="catalog-pagination">{{ $articles->links() }}</div>
</div>
<script>
document.addEventListener('click', function(e){
  if(!e.target.closest('.more-actions')) document.querySelectorAll('.more-menu.open').forEach(el=>el.classList.remove('open'));
});
</script>
@endsection
