@extends('layouts.admin')
@section('title','Edit Banner Promo')
@section('content')
<div class="page-head"><div><p class="eyebrow">Beranda</p><h1>Edit Banner Promo</h1><p class="muted">Perbarui banner {{ $banner->title ?: 'ini' }}.</p></div></div>
<div class="panel"><form method="POST" action="{{ route('admin.promo-banners.update', $banner) }}" enctype="multipart/form-data">@method('PUT') @include('admin.promo-banners.form')</form></div>
@endsection
