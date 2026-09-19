@extends('layouts.admin')
@section('title','Media Library')
@push('styles')<link rel="stylesheet" href="{{ asset('admin-assets/media.css') }}">@endpush
@section('content')
<div class="media-page"><div class="media-head"><div><span class="eyebrow">CONTENT ASSETS</span><h1>Media Library</h1><p>Satu tempat untuk mengelola gambar yang dipakai Produk, Artikel, dan NLUCK Studio.</p></div><button class="btn primary" onclick="document.getElementById('mediaFiles').click()">＋ Upload Asset</button></div>
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
<form id="uploadForm" method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="dropzone"><input type="hidden" name="_token" value="{{ csrf_token() }}"><input id="mediaFiles" type="file" name="files[]" accept="image/*" multiple hidden><div class="drop-icon">↑</div><div class="drop-copy"><strong>Tarik gambar ke sini atau pilih file</strong><span>JPG, PNG, WEBP, GIF · maksimal 5 MB/file</span></div></form>
<form class="toolbar" method="GET"><div class="search"><span>⌕</span><input name="q" value="{{ $q }}" placeholder="Cari nama atau alt text..."></div><button class="btn">Cari</button></form>
<div class="grid">@forelse($assets as $asset)<article class="asset"><div class="thumb"><img src="{{ $asset->url }}" alt="{{ $asset->alt_text ?: $asset->name }}" loading="lazy"></div><div class="asset-body"><div class="asset-name" title="{{ $asset->name }}">{{ $asset->name }}</div><div class="meta">{{ strtoupper(pathinfo($asset->name,PATHINFO_EXTENSION)) }} · {{ number_format(($asset->size ?? 0)/1024,0) }} KB</div><form method="POST" action="{{ route('admin.media.update',$asset) }}" class="edit-form">@csrf @method('PATCH')<input name="name" value="{{ $asset->name }}" aria-label="Nama asset"><input name="alt_text" value="{{ $asset->alt_text }}" placeholder="Alt text" aria-label="Alt text"><button class="mini">Simpan</button></form><form method="POST" action="{{ route('admin.media.destroy',$asset) }}" onsubmit="return confirm('Hapus asset ini?')">@csrf @method('DELETE')<button class="delete">Hapus</button></form></div></article>@empty<div class="empty"><div>🖼️</div><h3>Belum ada asset</h3><p>Upload gambar pertama untuk mulai membangun library.</p></div>@endforelse</div><div class="pager">{{ $assets->links() }}</div></div>
<script>
const input=document.getElementById('mediaFiles');
const form=document.getElementById('uploadForm');
if(input&&form){
  const submitFiles=()=>{ if(input.files.length){ form.classList.add('dragging'); form.submit(); } };
  input.addEventListener('change',submitFiles);
  form.addEventListener('dragover',e=>{e.preventDefault();form.classList.add('dragging')});
  form.addEventListener('dragleave',()=>form.classList.remove('dragging'));
  form.addEventListener('drop',e=>{e.preventDefault();form.classList.remove('dragging');if(e.dataTransfer.files.length){input.files=e.dataTransfer.files;submitFiles()}});
}
</script>
@endsection
