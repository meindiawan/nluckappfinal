# NLUCK Laravel — Final audited build

Build ini merapikan integrasi katalog, artikel, NLUCK Studio, admin dashboard, Media Library, lead pelanggan, analytics, dan WhatsApp Group.

## Fitur yang sudah disiapkan

- Public homepage NLUCK dengan logo, hero, katalog produk, Tentang Kami, Filosofi, Doa, dan artikel.
- Katalog produk dinamis dari database.
- Admin login dengan username.
- Admin dashboard dengan statistik produk, artikel, views, leads, conversion, WhatsApp, artikel terbaru, produk terbaru, dan grafik 7 hari.
- Artikel CRUD + featured + draft/publish.
- NLUCK Studio: template, tema, warna, background, tipografi, konten editable, autosave, publish, preview, export JSON.
- Upload gambar Studio langsung ke server dan Media Library.
- Media Library dengan pencarian, upload, edit nama/alt, dan hapus.
- Public article renderer menggunakan desain tersimpan.
- Form lead pelanggan.
- Halaman sukses setelah form dan pengalihan otomatis ke WhatsApp Group.
- Tracking klik WhatsApp.
- Customer Leads + status + export.
- Analytics.
- Pengaturan WhatsApp Group.
- Pengaturan form artikel.
- Pengaturan akun admin.
- Asset path dibuat konsisten agar tidak rusak karena halaman berada di `/artikel/...` atau `/studio/...`.

## XAMPP / Windows

Folder target:

`C:\xampp\htdocs\nluck`

Database:

`nluck`

`.env` bawaan sudah diset untuk:

- MySQL host `127.0.0.1`
- port `3306`
- database `nluck`
- username `root`
- password kosong

Setelah menyalin folder:

```powershell
cd C:\xampp\htdocs\nluck
composer install
php artisan optimize:clear
php artisan migrate --seed
php artisan serve
```

Buka:

`http://127.0.0.1:8000`

Admin:

`http://127.0.0.1:8000/admin/login`

Login demo:

- Username: `admin`
- Password: `admin`

## Jika database sudah berisi data

Jangan memakai `migrate:fresh` karena itu menghapus seluruh tabel.

Gunakan:

```powershell
php artisan migrate --seed
php artisan optimize:clear
```

Seeder hanya memperbarui data demo NLUCK berdasarkan slug/username yang sudah ditentukan.

## Upload gambar

Gambar baru dari Produk dan Media Library disimpan langsung di:

`public/uploads/`

Jadi tidak bergantung pada symbolic link `storage:link` untuk upload baru.

## WhatsApp Group

Seeder demo sudah memasang link group NLUCK yang diberikan untuk pengujian. Link tetap dapat diubah dari:

`Admin → WhatsApp Group`

## Hosting

Project tetap Laravel standar. Saat hosting, ubah `.env` untuk database dan `APP_URL`, lalu jalankan migration/seed sesuai kebutuhan. Karena asset bawaan berada di `public/assets` dan upload baru berada di `public/uploads`, path gambar tidak bergantung pada folder URL halaman.
