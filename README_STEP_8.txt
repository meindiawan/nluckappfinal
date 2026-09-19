NLUCK LARAVEL — STEP 8
Media Library terhubung langsung ke NLUCK Studio.

TUJUAN
- Studio sekarang punya tombol "Pilih dari Media Library".
- Asset dipilih dari /admin/media/json tanpa upload ulang.
- URL Storage disimpan ke design JSON sehingga tidak bergantung pada data URL browser.
- Target gambar tetap mengikuti slot Studio: Hero Banner, Foto Filosofi, Foto Pesan, Background Tema.

FILE UTAMA
- app/Http/Controllers/Admin/MediaController.php (versi Step 7 + endpoint JSON)
- routes/media.php
- public/studio/admin.html (Media Picker)
- migration + model MediaAsset

PASANG
1. Salin file Step 8 ke project Laravel sesuai foldernya.
2. Jika Step 7 sudah terpasang, ganti MediaController.php dan routes/media.php dengan versi Step 8.
3. Pastikan routes/web.php memuat:
   require __DIR__.'/media.php';
   require __DIR__.'/articles.php';
4. Pastikan storage siap:
   php artisan migrate
   php artisan storage:link
5. Ganti public/studio/admin.html dengan file Step 8.

CATATAN
- Endpoint JSON hanya bisa diakses admin yang sudah login.
- Upload tetap dilakukan dari Media Library, bukan dari Studio.
- Studio masih mendukung upload lokal sebagai fallback.
- SVG tetap diterima oleh Media Library Step 7; pastikan hanya admin tepercaya yang dapat mengunggah file tersebut.
