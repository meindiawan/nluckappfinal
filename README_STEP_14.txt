NLUCK LARAVEL — STEP 14: UNIFIED ARTICLE → STUDIO EXPERIENCE

TUJUAN
Menyatukan pengalaman navigasi Dashboard → Article Catalog → NLUCK Studio supaya Studio terasa sebagai bagian dari admin, bukan halaman HTML terpisah.

ISI PACKAGE
1. resources/views/admin/articles/studio.blade.php
   - shell Studio full-screen
   - top bar NLUCK Studio
   - tombol kembali ke katalog artikel
   - judul artikel
   - status koneksi/simpan
   - iframe Studio tetap menggunakan public/studio/admin.html yang sudah ada
   - komunikasi load/save server tetap melalui endpoint Laravel Step 9

2. public/admin/studio/studio-shell.css
   - tampilan top bar Studio
   - responsive desktop/mobile

3. patches/layout-admin-studio-css.txt
   - patch stylesheet layout admin

CARA PASANG
1. Copy resources/views/admin/articles/studio.blade.php ke project Laravel.
2. Copy public/admin/studio/studio-shell.css ke lokasi yang sama.
3. Terapkan patch layout-admin-studio-css.txt.
4. Jangan mengganti public/studio/admin.html dari Step 9/10/8; file tersebut tetap menjadi engine Studio.
5. Pastikan route berikut tetap tersedia:
   - admin.articles.index
   - admin.articles.studio
   - admin.articles.studio.data
   - admin.articles.studio.save

ALUR
Dashboard / Artikel Catalog → klik kartu → Studio shell → edit → autosave/server save → Tutup Studio → kembali ke katalog.

CATATAN
Package ini tidak membuat migration atau tabel baru.
Tidak mengubah struktur database.
Tidak mengubah engine desain Studio.
