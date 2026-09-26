@extends('layouts.catalog')
@section('title',$product->name.' — Nluck')
@section('content')
@php
    $wa = $whatsappSetting ?? \App\Models\WhatsAppSetting::current();
    $galleryUrls = $product->gallery_urls;
    $baseMessage = 'Halo NLUCK, saya ingin memesan '.$product->name.' (Rp '.number_format($product->price,0,',','.').'). Boleh dibantu info stok, warna, dan ongkirnya ya, kak?';
    $buyNumber = $wa->contact_whatsapp ?: '082246798794';
    $buyDigits = preg_replace('/\D+/', '', $buyNumber);
    if (str_starts_with($buyDigits, '0')) { $buyDigits = '62' . substr($buyDigits, 1); }
    $buyLink = 'https://wa.me/' . $buyDigits . '?text=' . rawurlencode($baseMessage);
    $qrTarget = $wa->waLink($baseMessage) ?: route('products.show', $product->slug);
    $qrImage = 'https://api.qrserver.com/v1/create-qr-code/?size=280x280&margin=8&data='.urlencode($qrTarget);
@endphp
<section class="detail"><div class="wrap">
    <a class="back" href="{{ route('catalog.browse') }}">← Kembali ke katalog</a>

    <div class="detailGrid" data-product-name="{{ $product->name }}" data-base-message="{{ $baseMessage }}">

        @if(count($galleryUrls) > 1)
        <div class="detailThumbs">
            @foreach($galleryUrls as $i => $url)
            <button type="button" class="thumb {{ $i===0?'active':'' }}" data-full="{{ $url }}" onclick="nluckSwapImage(this)">
                <img src="{{ $url }}" alt="{{ $product->name }} {{ $i+1 }}">
            </button>
            @endforeach
        </div>
        @endif

        <div class="detailImg">
            @if($galleryUrls)
                <img id="mainProductImage" src="{{ $galleryUrls[0] }}" alt="{{ $product->name }}">
            @endif
        </div>

        <div class="detailInfo">
            <div class="eyebrow">{{ $product->category ?: 'Nluck Collection' }}</div>
            <h1>{{ $product->name }}</h1>

            <div class="bigprice">Rp {{ number_format($product->price,0,',','.') }} @if($product->compare_price)<span class="old">Rp {{ number_format($product->compare_price,0,',','.') }}</span>@endif</div>

            @if($product->rating)
            <div class="rating">
                <span class="stars" aria-hidden="true">
                    @for($i=1;$i<=5;$i++)<span class="{{ $i <= round($product->rating) ? 'on' : '' }}">★</span>@endfor
                </span>
                <span class="rating-num">{{ number_format($product->rating,1) }}</span>
                @if($product->review_count)<span class="rating-count">({{ $product->review_count }} ulasan)</span>@endif
            </div>
            @endif

            <div class="meta">
                @if($product->sku)<span class="chip">SKU {{ $product->sku }}</span>@endif
                @if($product->stock>0)<span class="chip">Stok tersedia</span>@else<span class="chip">Stok habis</span>@endif
            </div>

            @if($product->description)<div class="description">{{ $product->description }}</div>@endif

            <ul class="highlights">
                @foreach($product->highlight_list as $point)
                <li><span class="check">✓</span>{{ $point }}</li>
                @endforeach
            </ul>

            @if($product->color_options)
            <div class="colorPicker">
                <div class="colorPicker-label">Pilihan Warna</div>
                <div class="swatches">
                    @foreach($product->color_options as $i => $color)
                    <button type="button" class="swatch {{ $i===0?'active':'' }}" style="background:{{ $color['hex'] }}" title="{{ $color['name'] ?: $color['hex'] }}" data-color-name="{{ $color['name'] ?: $color['hex'] }}" onclick="nluckPickColor(this)"></button>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="buy-actions">
                <a class="btn wa" id="waCtaGroup" target="_blank" rel="noopener" href="{{ $buyLink }}">Buy Now — Pesan via WhatsApp →</a>
                @if($wa->contact_whatsapp)
                    <a class="btn soft" id="waCtaContact" target="_blank" rel="noopener" href="{{ $wa->waLink($baseMessage) }}">Tanya Harga Spesial via WhatsApp</a>
                @endif
            </div>
            <div class="stock-note">Konfirmasi ketersediaan &amp; ongkir langsung lewat WhatsApp sebelum transfer.</div>
        </div>

        <div class="qrCard">
            <div class="qrCard-title">Scan QR Produk</div>
            <div class="qrCard-sub">Langsung chat WhatsApp untuk produk ini</div>
            <div class="qrCard-box"><img id="productQr" src="{{ $qrImage }}" alt="QR chat WhatsApp untuk {{ $product->name }}" width="220" height="220" loading="lazy"></div>
            @if($product->sku)<div class="qrCard-sku">SKU: {{ $product->sku }}</div>@endif
            <button type="button" class="btn dark qrCard-download" onclick="nluckDownloadQr(this)" data-src="{{ $qrImage }}" data-filename="qr-{{ $product->slug }}.png">Download QR</button>
        </div>

    </div>
</div></section>

@if($related->count())<section class="section"><div class="wrap"><div class="eyebrow">Pilihan lainnya</div><h2 style="font:500 36px Georgia,serif;margin:0 0 25px">Produk terkait</h2><div class="grid">@foreach($related as $item)<article class="product"><a href="{{ route('products.show',$item->slug) }}"><div class="prodImg">@if($item->image)<img src="{{ $item->image_url }}" alt="{{ $item->name }}" loading="lazy">@endif</div><div class="body"><small>{{ $item->category ?: 'Koleksi' }}</small><h2>{{ $item->name }}</h2><div class="price">Rp {{ number_format($item->price,0,',','.') }}</div></div></a></article>@endforeach</div></div></section>@endif

@push('scripts')
<script>
function nluckSwapImage(btn){
    var full = btn.dataset.full;
    var img = document.getElementById('mainProductImage');
    if(img && full) img.src = full;
    btn.parentElement.querySelectorAll('.thumb').forEach(function(t){t.classList.remove('active')});
    btn.classList.add('active');
}
function nluckPickColor(btn){
    btn.parentElement.querySelectorAll('.swatch').forEach(function(s){s.classList.remove('active')});
    btn.classList.add('active');
    var grid = document.querySelector('.detailGrid');
    var colorName = btn.dataset.colorName;
    var base = grid ? grid.dataset.baseMessage : '';
    var message = base + ' Warna: ' + colorName + '.';
    ['waCtaGroup','waCtaContact'].forEach(function(id){
        var a = document.getElementById(id);
        if(!a) return;
        try{
            var url = new URL(a.href);
            if(url.searchParams.has('text')){ url.searchParams.set('text', message); a.href = url.toString(); }
        }catch(e){}
    });
}
async function nluckDownloadQr(btn){
    var src = btn.dataset.src, filename = btn.dataset.filename || 'qr-produk.png';
    try{
        var res = await fetch(src);
        var blob = await res.blob();
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        link.remove();
        setTimeout(function(){URL.revokeObjectURL(link.href)}, 2000);
    }catch(e){
        window.open(src, '_blank');
    }
}
</script>
@endpush
@endsection
