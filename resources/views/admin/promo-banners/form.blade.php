@csrf
<div class="form-grid">
    <div class="field full"><label>Judul promo</label><input name="title" value="{{ old('title', $banner->title) }}" placeholder="Contoh: Diskon Spesial 9.9"><small>Ditampilkan besar di atas gambar. Boleh dikosongkan jika hanya ingin menampilkan gambar.</small></div>
    <div class="field full"><label>Sub-judul / teks pendukung</label><input name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" placeholder="Contoh: Berlaku sampai akhir bulan, khusus koleksi terbaru"></div>
    <div class="field"><label>Teks tombol</label><input name="button_text" value="{{ old('button_text', $banner->button_text) }}" placeholder="Contoh: Belanja Sekarang"><small>Kosongkan jika tidak perlu tombol.</small></div>
    <div class="field"><label>Link tujuan tombol</label><input name="link_url" value="{{ old('link_url', $banner->link_url) }}" placeholder="Contoh: /katalog atau https://wa.me/..."></div>
    <div class="field"><label>Urutan tampil</label><input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" min="0"><small>Angka lebih kecil tampil lebih dulu.</small></div>
    <div class="field check"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $banner->is_active ?? true))> Tampilkan di halaman utama</label></div>
    <div class="field full"><label>Gambar banner {{ $banner->exists ? '' : '*' }}</label><input type="file" name="image" accept="image/jpeg,image/png,image/webp"><small>JPG, PNG, atau WEBP. Maksimal 4 MB. Disarankan gambar lanskap (mis. 1600×1000px) agar tampil rapi di carousel.</small>
    @if($banner->image)<div class="current-image"><img src="{{ $banner->image_url }}" alt=""></div>@endif</div>
</div>
@if($errors->any())<div class="alert error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="form-actions"><a class="btn btn-soft" href="{{ route('admin.promo-banners.index') }}">Batal</a><button class="btn btn-primary">Simpan Banner</button></div>
