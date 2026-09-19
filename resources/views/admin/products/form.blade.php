@csrf
<div class="form-grid">
    <div class="field full"><label>Nama produk *</label><input name="name" value="{{ old('name', $product->name) }}" required></div>
    <div class="field"><label>SKU</label><input name="sku" value="{{ old('sku', $product->sku) }}" placeholder="Contoh: AMARA-001"></div>
    <div class="field"><label>Kategori</label><input name="category" value="{{ old('category', $product->category) }}" placeholder="Contoh: Koleksi"></div>
    <div class="field"><label>Harga *</label><input type="number" name="price" value="{{ old('price', $product->price ?? 0) }}" min="0" required></div>
    <div class="field"><label>Harga coret</label><input type="number" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}" min="0" placeholder="Opsional"></div>
    <div class="field"><label>Stok *</label><input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required></div>
    <div class="field"><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}" min="0"></div>
    <div class="field"><label>Status</label><select name="status"><option value="active" @selected(old('status',$product->status)==='active')>Aktif</option><option value="draft" @selected(old('status',$product->status)==='draft')>Draft</option></select></div>
    <div class="field check"><label><input type="checkbox" name="featured" value="1" @checked(old('featured',$product->featured))> Jadikan produk unggulan</label></div>
    <div class="field"><label>Rating (opsional)</label><input type="number" name="rating" step="0.1" min="0" max="5" value="{{ old('rating', $product->rating) }}" placeholder="Contoh: 4.8"><small>Kosongkan jika belum ada ulasan asli — bintang tidak akan tampil di halaman produk.</small></div>
    <div class="field"><label>Jumlah ulasan</label><input type="number" name="review_count" min="0" value="{{ old('review_count', $product->review_count) }}" placeholder="Contoh: 320"></div>
    <div class="field full"><label>Deskripsi</label><textarea name="description" rows="6" placeholder="Deskripsi produk yang akan digunakan katalog…">{{ old('description', $product->description) }}</textarea></div>
    <div class="field full"><label>Poin unggulan (satu per baris)</label><textarea name="highlights_raw" rows="3" placeholder="Bahan premium voal&#10;Jahitan rapi &amp; kuat&#10;Tersedia berbagai pilihan warna">{{ old('highlights_raw', collect($product->highlights ?? [])->implode("\n")) }}</textarea><small>Kosongkan untuk memakai poin standar.</small></div>
    <div class="field full"><label>Pilihan warna (satu per baris, format: Nama|#kodewarna)</label><textarea name="colors_raw" rows="3" placeholder="Coklat|#5c3a2e&#10;Hitam|#1c1c1c&#10;Sand|#c9a877">{{ old('colors_raw', collect($product->colors ?? [])->map(fn($c)=>trim(($c['name']??'').'|'.($c['hex']??'')))->implode("\n")) }}</textarea><small>Kosongkan jika produk ini hanya punya satu warna — bagian "Pilihan Warna" akan disembunyikan.</small></div>
    <div class="field full"><label>Foto produk (utama)</label><input type="file" name="image" accept="image/jpeg,image/png,image/webp"><small>JPG, PNG, WEBP. Maksimal 4 MB. Ini foto pertama yang tampil.</small>
    @if($product->image)<div class="current-image"><img src="{{ $product->image_url }}" alt=""><label><input type="checkbox" name="remove_image" value="1"> Hapus foto saat disimpan</label></div>@endif</div>
    <div class="field full"><label>Galeri foto tambahan</label><input type="file" name="gallery[]" accept="image/jpeg,image/png,image/webp" multiple><small>Boleh pilih beberapa sekaligus, akan tampil sebagai thumbnail di halaman produk. Maksimal 4 MB per foto.</small>
    @if(!empty($product->gallery))<div class="current-image gallery-current">@foreach($product->gallery as $i => $path)<label class="gallery-thumb"><input type="checkbox" name="keep_gallery[]" value="{{ $i }}" checked><img src="{{ $product->resolveGalleryPreviewUrl($path) }}" alt=""><span>Simpan</span></label>@endforeach</div><small>Hilangkan centang untuk menghapus foto tersebut saat disimpan.</small>@endif</div>
</div>
@if($errors->any())<div class="alert error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="form-actions"><a class="btn btn-soft" href="{{ route('admin.products.index') }}">Batal</a><button class="btn btn-primary">Simpan Produk</button></div>
