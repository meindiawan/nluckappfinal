NLUCK LARAVEL — STEP 13: DASHBOARD HOME + ARTICLE SHOWCASE

Tujuan:
Dashboard sekarang menjadi pusat kerja admin. Artikel terbaru ditampilkan sebagai katalog kartu, bukan daftar tabel. Klik kartu membuka NLUCK Studio.

ISI:
1. app/Http/Controllers/Admin/DashboardController.php
   - statistik produk & artikel dari database
   - 6 artikel terbaru
   - 3 featured article published
   - 5 produk terbaru

2. resources/views/admin/dashboard.blade.php
   - hero/welcome
   - statistik
   - katalog kartu artikel
   - featured articles strip
   - produk terbaru
   - quick actions
   - route akun diperbaiki ke admin.account.edit

3. public/admin/dashboard.css
   - responsive desktop/tablet/mobile
   - card catalog
   - thumbnail, badge status, featured
   - hover dan empty state

4. patches/layout-admin-stack-styles.txt
   WAJIB jika layout Step 1 belum memiliki @stack('styles').

5. patches/sidebar-links.txt
   Opsional untuk menambahkan menu Artikel dan Media Library ke sidebar.

CARA PASANG:
- Salin file dari package ini ke project Laravel.
- Untuk Controller dan Blade, replace file STEP 6.
- Salin dashboard.css ke public/admin/dashboard.css.
- Pastikan layouts/admin.blade.php memanggil @stack('styles') di <head>.
- Pastikan route admin.articles.studio tersedia dari STEP 9/10.
- Pastikan route admin.account.edit berasal dari STEP 1.
- Jika Media Library sudah dipasang, route admin.media.index akan otomatis tampil di quick actions.

CATATAN:
Dashboard ini tidak membuat tabel/migration baru.
Semua data berasal dari Product dan Article yang sudah dibuat pada step sebelumnya.
