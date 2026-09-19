NLUCK LARAVEL — STEP 2: PRODUCT CRUD

Tujuan:
- Produk disimpan di database.
- Admin bisa melihat, mencari, memfilter, menambah, mengedit, dan menghapus produk.
- Foto produk di-upload ke storage/app/public/products.
- Status active/draft, featured, stok, harga, SKU, kategori, urutan, deskripsi.

INSTALL:
1. Copy app/Models/Product.php
2. Copy app/Http/Controllers/Admin/ProductController.php
3. Copy database/migrations/2026_09_09_000002_create_products_table.php
4. Copy resources/views/admin/products/*
5. Tambahkan isi routes/products.php ke routes/web.php (jangan include file jika route admin dari STEP 1 sudah memakai group berbeda; satukan resource route ke group auth yang sama).
6. Jalankan: php artisan migrate
7. Jalankan: php artisan storage:link
8. Tambahkan menu Produk ke layout admin.
9. Tambahkan PRODUCT_ADMIN_CSS.txt ke CSS/layout admin.

Catatan:
- Modul ini memakai middleware auth dari STEP 1.
- Jangan membuat route admin kedua yang bentrok. Jika routes/web.php STEP 1 sudah memiliki Route::middleware('auth')->prefix('admin')->name('admin.')->group(...), masukkan baris resource('products', ...) ke dalam group tersebut.
- Harga disimpan sebagai integer Rupiah, tanpa desimal.
- SKU boleh kosong, tetapi jika diisi harus unik.
