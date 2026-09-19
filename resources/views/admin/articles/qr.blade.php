@extends('layouts.admin')
@section('title','QR Artikel — '.$article->title)
@section('heading','QR Artikel')
@push('styles')
<style>
.qr-page{max-width:760px}.qr-card{background:#fffdfa;border:1px solid #e4dcd2;border-radius:22px;padding:24px;display:grid;grid-template-columns:300px 1fr;gap:26px;align-items:center;box-shadow:0 10px 30px rgba(43,35,27,.05)}.qr-box{background:#fff;border:1px solid #eee5dc;border-radius:18px;padding:14px;box-shadow:0 8px 20px rgba(43,35,27,.05)}.qr-box img{display:block;width:100%;height:auto;aspect-ratio:1;object-fit:contain}.qr-copy small{font-size:9px;letter-spacing:.15em;color:#9a7655;font-weight:800}.qr-copy h2{font:500 30px/1.05 Georgia,serif;margin:7px 0 12px}.qr-copy p{font-size:12px;color:#81786f;line-height:1.65}.qr-url{padding:10px 12px;background:#f5efe7;border-radius:10px;font-size:10px;word-break:break-all;color:#6e645b}.qr-actions{display:flex;gap:8px;flex-wrap:wrap;margin-top:16px}.qr-btn{display:inline-flex;align-items:center;justify-content:center;border-radius:10px;padding:10px 13px;background:#25211d;color:#fff;font-size:11px;font-weight:800;text-decoration:none}.qr-btn.alt{background:#fff;border:1px solid #e1d9cf;color:#403a34}@media(max-width:700px){.qr-card{grid-template-columns:1fr;padding:16px}.qr-box{max-width:310px;margin:auto}.qr-copy h2{font-size:26px}}
</style>
@endpush
@section('content')
<div class="qr-page">
 @if(session('error'))<div class="alert error">{{ session('error') }}</div>@endif
 <div class="qr-card">
  <div class="qr-box"><img src="{{ $qrImage }}" alt="QR {{ $article->title }}"></div>
  <div class="qr-copy"><small>ARTICLE QR / BARCODE</small><h2>{{ $article->title }}</h2><p>QR ini mengarah langsung ke detail artikel yang sesuai. Cetak atau tempelkan QR ini pada kemasan/kartu ucapan setelah pembelian offline.</p><div class="qr-url">{{ $target }}</div><div class="qr-actions"><a class="qr-btn" href="{{ route('admin.articles.qr.download',$article) }}">↓ Download PNG</a><a class="qr-btn alt" target="_blank" href="{{ $target }}">Buka Artikel</a><a class="qr-btn alt" href="{{ route('admin.articles.studio',$article) }}">Kembali ke Studio</a></div></div>
 </div>
</div>
@endsection
