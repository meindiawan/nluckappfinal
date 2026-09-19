@extends('layouts.admin')
@section('title','Tambah Banner Promo')
@section('content')
<div class="page-head"><div><p class="eyebrow">Beranda</p><h1>Tambah Banner Promo</h1><p class="muted">Banner ini akan tampil di carousel paling atas halaman utama.</p></div></div>
<div class="panel"><form method="POST" action="{{ route('admin.promo-banners.store') }}" enctype="multipart/form-data">@include('admin.promo-banners.form')</form></div>
@endsection
