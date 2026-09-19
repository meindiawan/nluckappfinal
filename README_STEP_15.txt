NLUCK LARAVEL — STEP 15
PUBLIC ARTICLE = REAL STUDIO RENDER

Tujuan:
Membuat artikel publik benar-benar memakai dokumen Studio yang disimpan di database,
bukan dibungkus lagi oleh layout katalog yang dapat menyebabkan HTML <html> bersarang.

FILE:
- app/Http/Controllers/ArticleController.php
- resources/views/articles/studio-render.blade.php
- public/studio/layouts.css
- public/studio/themes.css
- routes/articles-public.php
- patches/public-article-route.txt

ALUR:
Dashboard -> Artikel -> Studio -> Terbitkan -> /artikel/{slug}

PERILAKU:
- Hanya status published yang dapat dibuka publik.
- published_at null atau waktu yang sudah lewat tetap dianggap publik.
- Design JSON di content_json dipakai langsung oleh Studio renderer.
- Theme, layout, background, accent, font, ukuran, alignment, toggle, dan asset
  mengikuti design yang tersimpan.
- URL artikel publik tidak lagi menampilkan Studio di dalam layout katalog.

INTEGRASI:
Jika routes/articles-public.php sudah di-require oleh routes/web.php,
tidak perlu menambah route lain. Hindari mendefinisikan route articles.show dua kali.

CATATAN:
Langkah ini fokus pada rendering publik yang konsisten dengan Studio. Pengembangan
berikutnya dapat menambahkan SEO metadata, Open Graph, social sharing, dan halaman
artikel terkait tanpa mengganggu renderer Studio.
