@extends('layouts.catalog')
@section('title', $content['title'].' — NLUCK')
@section('content')
<main class="page-story">
    <section class="story-hero">
        <div class="wrap story-grid">
            <div class="story-copy">
                <div class="eyebrow">{{ $content['eyebrow'] }}</div>
                <h1>{{ $content['title'] }}</h1>
                <p class="story-lead">{{ $content['lead'] }}</p>
                <div class="story-body">
                    @foreach($content['body'] as $paragraph)<p>{{ $paragraph }}</p>@endforeach
                </div>
                <blockquote>{{ $content['quote'] }}</blockquote>
            </div>
            <div class="story-image"><img src="{{ asset($content['image']) }}" alt="{{ $content['title'] }}"></div>
        </div>
    </section>
    <section class="story-collection"><div class="wrap"><div class="section-head"><div><div class="eyebrow">NLUCK COLLECTION</div><h2>Temukan koleksi kami</h2><p>Warna lembut, bentuk sederhana, dan pilihan yang mudah menemani keseharian.</p></div><a class="story-link" href="{{ route('catalog.browse') }}">Lihat semua koleksi →</a></div><div class="story-products">@foreach($products as $product)<a class="story-product" href="{{ route('products.show', $product) }}"><div class="story-product-img"><img src="{{ $product->image_url }}" alt="{{ $product->name }}"></div><div><small>{{ $product->category }}</small><h3>{{ $product->name }}</h3><strong>Rp {{ number_format($product->price,0,',','.') }}</strong></div></a>@endforeach</div></div></section>
    <section class="story-journal"><div class="wrap"><div class="eyebrow">NLUCK JOURNAL</div><h2>Cerita terbaru</h2><div class="journal-grid">@foreach($articles as $article)<a href="{{ route('articles.show', $article) }}" class="journal-card"><div class="journal-img"><img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}"></div><div class="journal-body"><small>{{ optional($article->published_at)->format('d M Y') }}</small><h3>{{ $article->title }}</h3><p>{{ $article->excerpt }}</p><span>Baca cerita →</span></div></a>@endforeach</div></div></section>
</main>
@endsection
