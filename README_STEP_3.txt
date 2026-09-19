STEP 3 — PUBLIC PRODUCT CATALOG

Tujuan:
Menghubungkan tabel products dari STEP 2 ke katalog publik Laravel.

FITUR:
- Homepage / menjadi katalog produk.
- Hanya produk dengan status active yang tampil.
- Search nama/SKU/kategori.
- Filter kategori.
- Pagination.
- Produk unggulan diprioritaskan.
- Detail produk /produk/{slug}.
- Produk terkait berdasarkan kategori.
- Foto mengambil storage Laravel.
- Responsive.

PEMASANGAN:
1. Copy folder app, resources, routes dari paket ini ke project Laravel.
2. Di routes/web.php tambahkan:
   require __DIR__.'/catalog.php';
3. Pastikan route admin dari STEP 1/2 tetap ada.
4. Jalankan:
   php artisan migrate
   php artisan storage:link
5. Pastikan APP_URL di .env sesuai alamat project.

CATATAN:
STEP 3 menggunakan tabel products dari STEP 2. Jangan menjalankan migration STEP 2 dua kali jika sudah pernah dijalankan.

URL:
/                 = katalog
/produk/{slug}    = detail produk
/admin/products   = admin CRUD
/admin/login      = login admin
