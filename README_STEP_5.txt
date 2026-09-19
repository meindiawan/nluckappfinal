NLUCK LARAVEL — STEP 5
PUBLIC ARTICLE RENDERER

Tujuan:
Artikel published dari database tampil di /artikel dan /artikel/{slug}.
Halaman detail membaca content_json hasil NLUCK Studio.

1. Copy app/Http/Controllers/ArticleController.php
2. Copy resources/views/layouts/articles.blade.php
3. Copy resources/views/articles/*.blade.php
4. Copy routes/articles-public.php ke routes/ atau paste isinya ke routes/web.php
5. Di routes/web.php tambahkan: require __DIR__.'/articles-public.php';

Pastikan model Article dari STEP 4 tersedia.

URL:
/artikel
/artikel/{slug}

Studio admin tetap:
/admin/articles
/admin/articles/{article}/studio

Catatan renderer:
Studio menyimpan desain dalam content_json. Renderer mengambil metadata hero dan field konten yang tersedia. HTML dari content_json ditampilkan karena content_json adalah data yang dibuat oleh editor internal Studio. Jika nanti Studio diperluas menjadi editor HTML bebas, tambahkan sanitasi HTML sebelum production deployment.
