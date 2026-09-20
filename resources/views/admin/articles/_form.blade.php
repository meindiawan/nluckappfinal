<link rel="stylesheet" href="{{ asset('admin-assets/article-form.css') }}">
@csrf
<div class="form-grid">
  <div><label>Judul</label><input name="title" value="{{ old('title',$article->title??'') }}" required></div>
  <div><label>Slug</label><input name="slug" value="{{ old('slug',$article->slug??'') }}" placeholder="otomatis jika kosong"></div>
  <div><label>Subjudul</label><input name="subtitle" value="{{ old('subtitle',$article->subtitle??'') }}"></div>
  <div><label>Status</label><select name="status"><option value="draft" @selected(old('status',$article->status??'draft')==='draft')>Draft</option><option value="published" @selected(old('status',$article->status??'draft')==='published')>Published</option></select></div>
  <div class="full"><label>Ringkasan</label><textarea name="excerpt" rows="4">{{ old('excerpt',$article->excerpt??'') }}</textarea></div>
  <div class="full">
    <label>Gambar Cover Artikel — tampilan kartu Dashboard</label>
    <div style="display:flex;gap:18px;align-items:flex-start;flex-wrap:wrap">
      <div style="width:180px;aspect-ratio:16/10;border:1px solid #ddd;border-radius:12px;overflow:hidden;background:#f5f3ee;display:flex;align-items:center;justify-content:center">
        @if(!empty($article->thumbnail))<img id="article-cover-preview" src="{{ $article->thumbnail_url }}" alt="Cover {{ $article->title }}" style="width:100%;height:100%;object-fit:cover">@else<span id="article-cover-empty" style="font-size:12px;color:#777;text-align:center;padding:15px">Belum ada cover</span>@endif
      </div>
      <div style="flex:1;min-width:260px">
        <input id="article-cover-input" type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp,image/gif">
        <p style="font-size:12px;color:#777;margin:8px 0 0">Gambar ini khusus untuk kartu artikel di Dashboard. Mengganti Hero di Studio tidak akan menggantinya.</p>
      </div>
    </div>
  </div>
  <div><label>Urutan</label><input type="number" name="sort_order" min="0" value="{{ old('sort_order',$article->sort_order??0) }}"></div>
  <div><label>Tanggal publikasi</label><input type="datetime-local" name="published_at" value="{{ old('published_at',isset($article)&&$article->published_at?$article->published_at->format('Y-m-d\\TH:i'):'') }}"></div>
  <div class="full check"><label><input type="checkbox" name="featured" value="1" @checked(old('featured',$article->featured??false))> Jadikan artikel unggulan</label></div>
</div>
<div class="form-actions"><button class="btn primary">Simpan</button><a class="btn" href="{{ route('admin.articles.index') }}">Batal</a></div>
<script>
(function(){const input=document.getElementById('article-cover-input');if(!input)return;input.addEventListener('change',function(){const file=this.files&&this.files[0];if(!file)return;if(!file.type.startsWith('image/'))return;const old=document.getElementById('article-cover-preview');const empty=document.getElementById('article-cover-empty');const img=old||document.createElement('img');img.id='article-cover-preview';img.alt='Preview cover';img.style.cssText='width:100%;height:100%;object-fit:cover';img.src=URL.createObjectURL(file);if(!old){const box=empty&&empty.parentElement;if(box){empty.remove();box.appendChild(img)}}});})();
</script>
