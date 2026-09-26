@extends('layouts.articles')
@section('title','Artikel — NLUCK')
@section('content')<header class="hero wrap"><div class="eyebrow">NLUCK Journal</div><h1>Inspirasi, cerita &amp; insight.</h1><p>Kumpulan artikel yang dibuat melalui NLUCK Studio. Semua konten yang berstatus terbit akan tampil otomatis di sini.</p><form class="search"><input name="q" value="{{ $q }}" placeholder="Cari artikel..." aria-label="Cari artikel"><button class="btn">Cari</button></form></header><main class="wrap article-catalog-page">@if($articles->count())<section class="grid">@foreach($articles as $article)<a class="card" href="{{ route('articles.show',$article->slug) }}"><div class="thumb">@if($article->thumbnail)<img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" loading="lazy">@else<div class="thumb-fallback"><img src="{{ asset('studio/assets/nluck-wordmark.png') }}" alt="NLUCK"></div>@endif</div><div class="body"><div class="meta">{{ $article->featured ? 'Featured · ' : '' }}{{ optional($article->published_at)->format('d M Y') }}</div><h2>{{ $article->title }}</h2><p>{{ $article->excerpt }}</p></div></a>@endforeach</section><div class="pagination">{{ $articles->onEachSide(1)->links('partials.pagination') }}</div>@else<div class="empty">Belum ada artikel yang diterbitkan.</div>@endif</main>
<style>
.article-catalog-page .card{position:relative;isolation:isolate}
.article-catalog-page .card:after{content:"BACA ARTIKEL →";position:absolute;right:16px;bottom:16px;padding:7px 10px;border-radius:999px;background:rgba(255,255,255,.9);font-size:9px;letter-spacing:.08em;font-weight:700;opacity:0;transform:translateY(5px);transition:.25s;box-shadow:0 6px 18px rgba(0,0,0,.08)}
.article-catalog-page .card:hover:after{opacity:1;transform:none}
.article-catalog-page .card .thumb img{transition:transform .5s cubic-bezier(.2,.7,.2,1)}
.article-catalog-page .card:hover .thumb img{transform:scale(1.035)}
.article-catalog-page .search input{transition:.2s}.article-catalog-page .search input:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 4px rgba(120,130,91,.10)}
@media(max-width:560px){.article-catalog-page .card:after{opacity:1;transform:none}}
</style>
<script>
(function(){
 document.querySelectorAll('.article-catalog-page .card').forEach((card,i)=>{
   card.style.opacity='0';card.style.transform='translateY(12px)';
   setTimeout(()=>{card.style.transition='opacity .45s ease,transform .45s ease';card.style.opacity='1';card.style.transform='none'},i*70);
 });
})();
</script>

@endsection
