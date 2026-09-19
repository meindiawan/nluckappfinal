NLUCK LARAVEL - STEP 7 MEDIA LIBRARY

Fitur: upload multiple images, drag/drop, search, edit name/alt text, delete, pagination, storage public.

1. Copy app/Models/MediaAsset.php
2. Copy app/Http/Controllers/Admin/MediaController.php
3. Copy migration ke database/migrations
4. Copy resources/views/admin/media/index.blade.php
5. Copy public/admin/media.css dan load di layout admin:
   <link rel="stylesheet" href="{{ asset('admin/media.css') }}">
6. Tambahkan di routes/web.php:
   require __DIR__.'/media.php';
7. Jalankan:
   php artisan migrate
   php artisan storage:link
8. Buka /admin/media setelah login.

Catatan keamanan: upload dibatasi image MIME/extensi dan 5 MB/file. Semua route dilindungi middleware auth.
