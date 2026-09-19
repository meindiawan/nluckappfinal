@extends('layouts.admin')
@section('title', 'Edit '.ucfirst($key).' — NLUCK')
@section('heading', ucfirst($key))
@push('styles')
<style>
.content-editor{max-width:900px}.content-editor .intro{margin:-10px 0 18px;color:#81786f;font-size:13px}.content-card{background:#fffdfa;border:1px solid #e4dcd2;border-radius:20px;padding:22px;box-shadow:0 8px 28px rgba(43,35,27,.04)}.ce-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}.ce-field{display:grid;gap:6px}.ce-field.full{grid-column:1/-1}.ce-field label{font-size:11px;font-weight:800;color:#5e554c}.ce-field input,.ce-field textarea{width:100%;border:1px solid #e1d9cf;background:#fff;border-radius:11px;padding:11px 12px;outline:0;font-size:12px;color:#302a25}.ce-field textarea{min-height:100px;resize:vertical}.ce-field input:focus,.ce-field textarea:focus{border-color:#9a7655;box-shadow:0 0 0 3px rgba(154,118,85,.10)}.body-list{display:grid;gap:9px}.body-row{display:grid;grid-template-columns:1fr auto;gap:8px;align-items:start}.remove-row{border:1px solid #ead8d1;background:#fff4f1;color:#8d4b40;border-radius:9px;padding:9px 11px;cursor:pointer;font-size:11px}.ce-actions{display:flex;gap:8px;margin-top:18px;flex-wrap:wrap}.ce-btn{border:0;border-radius:10px;padding:10px 14px;font-size:11px;font-weight:800;cursor:pointer;background:#25211d;color:#fff}.ce-btn.alt{background:#fff;border:1px solid #e1d9cf;color:#403a34}.ce-preview{margin-top:18px;padding:16px;border-radius:15px;background:#f5efe7;border:1px solid #e5dbcf}.ce-preview small{font-size:9px;letter-spacing:.12em;color:#9a7655;font-weight:800}.ce-preview h3{font:500 25px Georgia,serif;margin:7px 0}.ce-preview p{font-size:11px;color:#716960;line-height:1.6;margin:5px 0}.ce-preview blockquote{margin:12px 0 0;border-left:2px solid #9a7655;padding-left:12px;font:italic 16px Georgia,serif;color:#62574d}@media(max-width:650px){.ce-grid{grid-template-columns:1fr}.ce-field.full{grid-column:auto}.body-row{grid-template-columns:1fr}.remove-row{justify-self:end}}
</style>
@endpush
@section('content')
<div class="content-editor">
  <p class="intro">Ubah teks yang tampil di halaman {{ ucfirst($key) }} dan bagian terkait di website tanpa menghilangkan fungsi lain.</p>
  @if(session('success'))<div class="alert ok">{{ session('success') }}</div>@endif
  <form method="POST" action="{{ route('admin.site-content.update',$key) }}" class="content-card">@csrf @method('PUT')
    <div class="ce-grid">
      <div class="ce-field"><label>Eyebrow</label><input name="eyebrow" value="{{ old('eyebrow',$content->eyebrow) }}"></div>
      <div class="ce-field"><label>Judul</label><input name="title" value="{{ old('title',$content->title) }}" required></div>
      <div class="ce-field full"><label>Pembuka</label><textarea name="lead">{{ old('lead',$content->lead) }}</textarea></div>
      <div class="ce-field full"><label>Isi / Filosofi / Doa</label><div class="body-list" id="bodyList">
        @foreach(old('body',$content->body) as $i=>$text)<div class="body-row"><textarea name="body[]" placeholder="Paragraf {{ $i+1 }}">{{ $text }}</textarea><button type="button" class="remove-row" onclick="this.parentElement.remove()">Hapus</button></div>@endforeach
      </div><button type="button" class="ce-btn alt" style="margin-top:8px;width:max-content" onclick="addBody()">＋ Tambah paragraf</button></div>
      <div class="ce-field full"><label>Quote / kalimat penutup</label><input name="quote" value="{{ old('quote',$content->quote) }}"></div>
      <div class="ce-field full"><label>Path gambar (opsional)</label><input name="image" value="{{ old('image',$content->image) }}" placeholder="contoh: assets/hero/dua-illustration.jpg"></div>
    </div>
    <div class="ce-preview"><small>PREVIEW</small><h3 id="previewTitle">{{ $content->title }}</h3><p id="previewLead">{{ $content->lead }}</p><blockquote id="previewQuote">{{ $content->quote }}</blockquote></div>
    <div class="ce-actions"><button class="ce-btn" type="submit">Simpan Perubahan</button><a class="ce-btn alt" href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a></div>
  </form>
</div>
<script>
function addBody(){const l=document.getElementById('bodyList');const row=document.createElement('div');row.className='body-row';row.innerHTML='<textarea name="body[]" placeholder="Paragraf baru"></textarea><button type="button" class="remove-row" onclick="this.parentElement.remove()">Hapus</button>';l.appendChild(row);row.querySelector('textarea').focus()}
const title=document.querySelector('[name="title"]'),lead=document.querySelector('[name="lead"]'),quote=document.querySelector('[name="quote"]');[['input',title,'previewTitle'],['input',lead,'previewLead'],['input',quote,'previewQuote']].forEach(([e,el,id])=>el?.addEventListener(e,()=>document.getElementById(id).textContent=el.value));
</script>
@endsection
