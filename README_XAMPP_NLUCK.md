# NLUCK Laravel — XAMPP Ready

Project ini adalah gabungan NLUCK STEP 1–22 ke dalam skeleton Laravel yang Anda upload.

## Database XAMPP
Buat database kosong bernama `nluck` di phpMyAdmin.
Default:
- host: 127.0.0.1
- port: 3306
- username: root
- password: kosong

## Menjalankan
1. XAMPP: Start MySQL (Apache tidak wajib jika memakai `php artisan serve`).
2. Di folder project:
   composer install
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   php artisan serve
3. Buka http://127.0.0.1:8000
4. Admin: http://127.0.0.1:8000/admin/login
   Username: admin
   Password: admin

Jangan membuat tabel manual di phpMyAdmin; migration Laravel yang membuat tabel.
