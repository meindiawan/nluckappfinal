@extends('layouts.admin')
@section('title','Tambah Produk')
@section('content')
<div class="page-head"><div><p class="eyebrow">Katalog</p><h1>Tambah Produk</h1><p class="muted">Buat data produk baru untuk katalog.</p></div></div>
<div class="panel"><form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">@include('admin.products.form')</form></div>
@endsection
