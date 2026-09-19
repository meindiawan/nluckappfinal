NLUCK LARAVEL — STEP 11
ARTICLE WORKFLOW: DRAFT / PUBLISH / UNPUBLISH / DUPLICATE / PREVIEW

Tujuan
- Membuat status artikel benar-benar menjadi workflow.
- Publish dan unpublish harus eksplisit.
- Artikel draft bisa dipreview tanpa membuatnya publik.
- Artikel bisa diduplikasi menjadi draft baru.
- Artikel published punya tombol Lihat Artikel.

FILE
- app/Http/Controllers/Admin/ArticleWorkflowController.php
- resources/views/admin/articles/preview.blade.php
- resources/views/admin/articles/index-workflow.blade.php
- routes/article-workflow.php
- ARTICLE_CONTROLLER_PATCH.txt
- ADMIN_ARTICLE_INDEX_PATCH.txt

INSTALL
1. Copy file ke project Laravel.
2. Di routes/web.php tambahkan:
   require __DIR__.'/article-workflow.php';
   (sesuaikan path jika file diletakkan di routes/)
3. Pada daftar artikel, pasang action dari index-workflow.blade.php.
4. Pastikan STEP 10 sudah terpasang karena preview menggunakan articles/studio-render.blade.php.

ROUTES
POST /admin/articles/{article}/publish
POST /admin/articles/{article}/unpublish
POST /admin/articles/{article}/duplicate
GET  /admin/articles/{article}/preview

CATATAN
- Semua workflow route memakai auth middleware.
- Preview draft hanya bisa dibuka admin.
- Duplicate selalu menjadi draft dan published_at=null.
- Publish mengisi published_at jika sebelumnya kosong.
- Unpublish hanya mengubah status menjadi draft; tanggal publish disimpan agar riwayat tidak hilang.
