@extends('layouts.catalog')
@section('title','NLUCK — Elegan dalam Setiap Langkah')
@section('content')
<main>
@if($promoBanners->count())
<section class="home-hero"><div class="wrap">
    <div class="hero-carousel" data-hero-carousel>
        <div class="hero-track">
            @foreach($promoBanners as $banner)
            <div class="hero-slide" style="background-image:url('{{ $banner->image_url }}')">
                <div class="hero-slide-inner">
                    <div class="eyebrow">NLUCK PROMO</div>
                    @if($banner->title)<h1>{{ $banner->title }}</h1>@endif
                    @if($banner->subtitle)<p>{{ $banner->subtitle }}</p>@endif
                    @if($banner->button_text && $banner->link_url)<a class="btn" href="{{ $banner->link_url }}">{{ $banner->button_text }}</a>@endif
                </div>
            </div>
            @endforeach
        </div>
        @if($promoBanners->count() > 1)
        <button class="hero-arrow prev" type="button" aria-label="Sebelumnya">‹</button>
        <button class="hero-arrow next" type="button" aria-label="Berikutnya">›</button>
        <div class="hero-dots">
            @foreach($promoBanners as $i => $banner)
            <button class="hero-dot @if($i===0) active @endif" type="button" data-index="{{ $i }}" aria-label="Slide {{ $i+1 }}"></button>
            @endforeach
        </div>
        @endif
    </div>
</div></section>
@push('scripts')
<script>
(function(){
    document.querySelectorAll('[data-hero-carousel]').forEach(function(carousel){
        var track = carousel.querySelector('.hero-track');
        var slides = Array.prototype.slice.call(carousel.querySelectorAll('.hero-slide'));
        var dots = Array.prototype.slice.call(carousel.querySelectorAll('.hero-dot'));
        var prev = carousel.querySelector('.hero-arrow.prev');
        var next = carousel.querySelector('.hero-arrow.next');
        var i = 0, timer;

        function go(n){
            i = (n + slides.length) % slides.length;
            track.style.transform = 'translateX(-' + (i * 100) + '%)';
            dots.forEach(function(d, idx){ d.classList.toggle('active', idx === i); });
        }
        function play(){ timer = setInterval(function(){ go(i + 1); }, 5500); }
        function stop(){ clearInterval(timer); }

        if (next) next.addEventListener('click', function(){ stop(); go(i + 1); play(); });
        if (prev) prev.addEventListener('click', function(){ stop(); go(i - 1); play(); });
        dots.forEach(function(d){ d.addEventListener('click', function(){ stop(); go(parseInt(d.dataset.index, 10)); play(); }); });

        if (slides.length > 1) play();
    });
})();
</script>
@endpush
@else
<section class="home-hero"><div class="wrap home-hero-grid"><div class="home-copy"><div class="eyebrow">NEW COLLECTION · MODEST ESSENTIALS</div><h1>Elegan dalam<br>setiap langkah.</h1><p>Katalog digital Nluck menghadirkan koleksi kerudung dengan pengalaman yang sederhana, hangat, dan premium. Sentuh salah satu produk untuk melihat detail lengkapnya, seperti berbelanja di marketplace favoritmu.</p><div class="hero-actions"><a class="btn" href="#koleksi">Jelajahi Koleksi</a><a class="btn soft" href="{{ route('pages.about') }}">Cerita Kami</a></div></div><div class="home-hero-image"><img src="{{ asset('assets/hero/hero-illustration.jpg') }}" alt="NLUCK Collection"><span>Everyday Veil · 2026</span></div></div></section>
@endif
<section class="home-section" id="koleksi"><div class="wrap"><div class="section-head"><div><div class="eyebrow">NEW COLLECTION</div><h2>Koleksi pilihan</h2><p>Koleksi terbaru dengan desain fresh, nyaman, dan tetap elegan.</p></div><a class="story-link" href="{{ route('catalog.browse') }}">Lihat katalog →</a></div><div class="home-products">@foreach($featuredProducts as $product)<a class="home-product" href="{{ route('products.show',$product) }}"><div class="home-product-img"><img src="{{ $product->image_url }}" alt="{{ $product->name }}"><span>{{ $product->featured ? 'Featured' : 'NLUCK' }}</span></div><div class="home-product-body"><small>{{ $product->category }}</small><h3>{{ $product->name }}</h3><strong>Rp {{ number_format($product->price,0,',','.') }}</strong></div></a>@endforeach</div></div></section>
<section class="home-about"><div class="wrap about-grid"><div class="about-image"><img src="{{ asset('assets/hero/about-illustration.jpg') }}" alt="Tentang NLUCK"></div><div class="about-copy"><div class="eyebrow">TENTANG NLUCK</div><h2>Lebih dari sekadar kerudung.</h2><p>NLUCK percaya bahwa kesederhanaan dapat menjadi bentuk elegansi yang paling personal. Kami merancang warna, tekstur, dan detail untuk menemani perempuan modern menjalani hari dengan nyaman dan percaya diri.</p><a class="btn soft" href="{{ route('pages.about') }}">Tentang Kami →</a></div></div></section>
<section class="home-philosophy"><div class="wrap philosophy-inner"><div><div class="eyebrow">FILOSOFI</div><h2>Grace Beyond Beauty</h2><p>Simple, thoughtful, meaningful. Karena yang indah tidak selalu harus ramai.</p></div><a class="btn" href="{{ route('pages.philosophy') }}">Baca Filosofi →</a></div></section>
<section class="home-journal"><div class="wrap"><div class="section-head"><div><div class="eyebrow">NLUCK JOURNAL</div><h2>Artikel terbaru</h2><p>Inspirasi dan cerita yang dibuat langsung melalui NLUCK Studio.</p></div><a class="story-link" href="{{ route('articles.index') }}">Semua artikel →</a></div><div class="journal-grid">@foreach($latestArticles as $article)<a class="journal-card" href="{{ route('articles.show',$article) }}"><div class="journal-img">@if($article->thumbnail_url)<img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}">@else<div class="journal-img-fallback"><img src="{{ asset('studio/assets/nluck-wordmark.png') }}" alt="NLUCK"></div>@endif</div><div class="journal-body"><small>{{ optional($article->published_at)->format('d M Y') }}</small><h3>{{ $article->title }}</h3><p>{{ $article->excerpt }}</p><span>Baca cerita →</span></div></a>@endforeach</div></div></section>
<section class="home-doa"><div class="wrap doa-inner"><div class="doa-image"><img src="{{ asset('assets/hero/dua-illustration.jpg') }}" alt="Doa NLUCK"></div><div><div class="eyebrow">DOA</div><h2>Semoga setiap langkah membawa kebaikan.</h2><p>Semoga apa yang kamu kenakan menjadi pengingat untuk berjalan dengan tenang, menjaga hati, dan membawa kebaikan di mana pun berada.</p><a class="story-link" href="{{ route('pages.doa') }}">Baca doa NLUCK →</a></div></div></section>
</main>
@endsection
