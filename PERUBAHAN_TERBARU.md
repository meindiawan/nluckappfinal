# Perubahan yang ditambahkan

## 1. Carousel promo di paling atas halaman utama
- Menu admin baru: **Promo Carousel** (sidebar & dashboard "Akses cepat").
- Admin bisa tambah/edit/hapus banner: gambar, judul, sub-judul, teks & link tombol, urutan tampil, aktif/nonaktif.
- Di halaman utama (`/`), bagian paling atas otomatis jadi carousel yang bergeser sendiri (autoplay 5.5 detik) + tombol panah & titik navigasi, kalau banner lebih dari satu.
- **Kalau belum ada banner promo yang aktif, tampilan hero lama (yang sudah bagus) tetap muncul seperti biasa** — jadi tidak ada yang hilang.
- File baru: migration `create_promo_banners_table`, model `PromoBanner`, controller `Admin\PromoBannerController`, view `admin/promo-banners/*`.

## 2. Logo diganti dengan logo NLUCK Scarves (dari foto box kamu)
- Logo diambil & dibersihkan dari foto yang kamu kirim, dipasang di:
  - Header website (pengganti tulisan "Nluck")
  - Footer website
  - Halaman login admin
  - Sidebar admin
- Favicon (ikon tab browser) juga dibuat dari logo yang sama — `favicon.ico`, `favicon-32.png`, `apple-touch-icon.png`.

## 3. Login admin
- Username & password login sekarang diatur lewat file `.env` (bukan ditulis langsung di kode, demi keamanan).
- `.env.example` sudah saya set default: `ADMIN_USERNAME=admin`, `ADMIN_PASSWORD=nluck890`.
- **Catatan keamanan:** "nluck890" cukup pendek/simpel untuk akun admin. Boleh dipakai, tapi kalau website ini publik saya sarankan pakai password yang lebih panjang (12+ karakter, campur huruf/angka). Kalau mau, tinggal ganti nilainya di `.env` kapan saja.

# Cara menerapkan di server/XAMPP kamu

1. Salin project ini ke lokasi lama kamu (timpa file yang berubah), lalu jalankan:
   ```
   composer install
   php artisan optimize:clear
   php artisan storage:link
   ```
2. Pastikan file `.env` kamu (bukan `.env.example`) berisi:
   ```
   ADMIN_USERNAME=admin
   ADMIN_PASSWORD=nluck890
   ```
3. Jalankan migration untuk tabel banner baru (aman, tidak menghapus data lain):
   ```
   php artisan migrate
   ```
4. Terapkan username/password admin yang baru:
   ```
   php artisan db:seed --class=AdminUserSeeder
   ```
5. Buka `/admin/login`, login dengan `admin` / `nluck890`, lalu masuk ke menu **Promo Carousel** untuk mulai isi gambar & teks promo.

Semua bagian lain (produk, artikel, dsb.) tidak diubah/dikurangi.
