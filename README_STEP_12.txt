NLUCK LARAVEL — STEP 12
ARTICLE CATALOG / CARD VIEW

Tujuan:
Mengubah halaman Admin > Artikel dari daftar sederhana menjadi katalog kartu yang menjadi pintu masuk utama ke NLUCK Studio.

ISI:
- resources/views/admin/articles/index.blade.php
- public/admin/article-catalog.css
- ARTICLE_CONTROLLER_PATCH.txt
- routes/article-catalog.php (catatan route, tidak wajib dipasang)

INSTALASI:
1. Copy index.blade.php ke resources/views/admin/articles/index.blade.php
2. Copy article-catalog.css ke public/admin/article-catalog.css
3. Tambahkan @stack('styles') pada layouts/admin.blade.php jika belum ada.
4. Terapkan method index() dari ARTICLE_CONTROLLER_PATCH.txt.
5. Pastikan route dari STEP 11 sudah terpasang karena tombol workflow memakai:
   admin.articles.preview
   admin.articles.publish
   admin.articles.unpublish
   admin.articles.duplicate
6. Pastikan route public artikel bernama articles.show tersedia untuk tombol Lihat.

HASIL:
- Grid kartu artikel responsif
- Thumbnail besar
- Status Draft / Published
- Featured badge
- Search judul/slug/ringkasan
- Filter status dan featured
- Quick action Studio / Lihat / Edit
- Menu Preview / Duplikat / Publish / Unpublish / Hapus
- Pagination

Catatan penting:
Jika nama route public artikel Anda berbeda dari articles.show, ubah route('articles.show', $article) pada Blade.
