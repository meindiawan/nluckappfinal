NLUCK LARAVEL — STEP 1: ADMIN AUTHENTICATION
============================================
Target: Laravel 13 / PHP 8.3+ (juga mudah diadaptasi ke Laravel 12)

FITUR
- /admin/login halaman login admin terpisah
- akun awal: admin / admin
- password tersimpan sebagai hash
- /admin dan semua route di grup auth tidak bisa dibuka tanpa login
- CSRF protection dari Laravel
- session regenerate setelah login
- logout + invalidate session
- rate limit 5 percobaan login per username/IP
- remember me
- pengaturan username dan password admin
- validasi current password sebelum mengubah kredensial
- tampilan responsive

CARA PASANG
1. Copy semua file sesuai struktur foldernya ke project Laravel.
2. Ikuti USER_MODEL_PATCH.txt.
3. Ikuti DATABASE_SEEDER_PATCH.txt.
4. Pastikan database di .env sudah benar.
5. Jalankan:

   php artisan migrate
   php artisan db:seed --class=AdminUserSeeder

6. Jalankan project:

   composer run dev

   atau:
   php artisan serve

7. Buka:
   /admin/login

   Username: admin
   Password: admin

8. Setelah berhasil login, segera ubah password melalui:
   /admin/account

CATATAN
- Untuk project produksi, jangan pertahankan password "admin".
- Route publik / saat ini memakai view welcome bawaan sebagai placeholder.
  Pada langkah integrasi katalog, route ini akan diganti dengan halaman NLUCK dari ZIP.
- File ZIP Anda sekarang berbasis HTML/JS statis. Step berikutnya sebaiknya CRUD Produk
  agar data tidak lagi hanya tersimpan di browser/localStorage, tetapi di database Laravel.
