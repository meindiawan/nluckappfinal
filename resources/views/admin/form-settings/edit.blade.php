@extends('layouts.admin')
@section('title','Pengaturan Form Artikel')
@push('styles')<link rel="stylesheet" href="{{ asset('admin-assets/form-settings/settings.css') }}">@endpush
@section('content')
<div class="fs-page">
  <div class="fs-head"><div><span class="fs-eyebrow">KONVERSI ARTIKEL</span><h1>Pengaturan Form Pelanggan</h1><p>Atur field, teks, dan CTA yang muncul di semua artikel publik.</p></div></div>
  @if(session('success'))<div class="fs-alert">✓ {{ session('success') }}</div>@endif
  @if($errors->any())<div class="fs-error">{{ $errors->first() }}</div>@endif
  <form method="POST" action="{{ route('admin.form-settings.update') }}" class="fs-grid">
    @csrf @method('PUT')
    <section class="fs-card"><h2>Teks Form</h2>
      <label>Judul<input name="title" value="{{ old('title',$setting->title) }}" required></label>
      <label>Deskripsi<textarea name="description" rows="3">{{ old('description',$setting->description) }}</textarea></label>
      <label>Teks tombol CTA<input name="cta_text" value="{{ old('cta_text',$setting->cta_text) }}" required></label>
      <label>Judul halaman sukses<input name="success_title" value="{{ old('success_title',$setting->success_title) }}" required></label>
      <label>Pesan halaman sukses<textarea name="success_message" rows="3">{{ old('success_message',$setting->success_message) }}</textarea></label>
      <label>Teks persetujuan<textarea name="consent_text" rows="3" required>{{ old('consent_text',$setting->consent_text) }}</textarea></label>
    </section>
    <section class="fs-card"><h2>Field yang ditampilkan</h2><p class="muted">WhatsApp dan Nama selalu digunakan untuk lead utama.</p>
      @foreach([['name','Nama Lengkap',$setting->show_name],['whatsapp','No. WhatsApp',$setting->show_whatsapp],['email','Email',$setting->show_email],['birth_date','Tanggal Lahir',$setting->show_birth_date],['city','Kota',$setting->show_city],['instagram','Instagram',$setting->show_instagram]] as $f)
      <label class="toggle"><input type="checkbox" name="show_{{ $f[0] }}" value="1" {{ old('show_'.$f[0],$f[2])?'checked':'' }}><span>{{ $f[1] }}</span></label>
      @endforeach
      <h2 class="sub">Field wajib</h2>
      @foreach([['email','Email',$setting->require_email],['birth_date','Tanggal Lahir',$setting->require_birth_date],['city','Kota',$setting->require_city],['instagram','Instagram',$setting->require_instagram],['consent','Persetujuan',$setting->require_consent]] as $f)
      <label class="toggle"><input type="checkbox" name="require_{{ $f[0] }}" value="1" {{ old('require_'.$f[0],$f[2])?'checked':'' }}><span>{{ $f[1] }}</span></label>
      @endforeach
      <button class="save">Simpan Pengaturan</button>
    </section>
  </form>
</div>
@endsection
