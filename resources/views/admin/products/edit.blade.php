@extends('layouts.admin')
@section('title','Edit Produk')
@section('content')
<div class="page-head"><div><p class="eyebrow">Katalog</p><h1>Edit Produk</h1><p class="muted">Perbarui informasi {{ $product->name }}.</p></div></div>
<div class="panel"><form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">@method('PUT') @include('admin.products.form')</form></div>
@endsection
