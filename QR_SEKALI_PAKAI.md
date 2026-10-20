# QR Sekali Pakai (revisi klien)

Satu QR = satu produk = satu kali pendaftaran. Begitu pelanggan selesai mengisi data dan diarahkan
ke grup WhatsApp, QR tersebut **hangus**. Scan kedua (siapa pun) hanya melihat pesan "QR ini sudah digunakan".

## Cara pasang (di project yang sudah jalan)
Timpa file dari ZIP ini ke project, lalu:

```powershell
composer install
php artisan migrate          # JANGAN migrate:fresh — itu menghapus data lead yang sudah ada
php artisan optimize:clear
```

Di `.env` isi domain produksi (tanpa slash di akhir):
```
QR_BASE_URL=https://domain-nluck-anda.com
```
Tanpa ini QR berisi alamat server saat admin dibuka (mis. localhost) dan tidak bisa dibuka pelanggan.
Admin akan melihat peringatan kuning bila QR masih berisi alamat lokal.

## Alur admin
Admin → Artikel → tombol **QR · n** pada kartu artikel (n = sisa QR yang belum terpakai).
- **Buat QR baru**: isi jumlah (sesuai jumlah produk), klik Buat QR. Tiap QR punya kode acak 12 karakter.
- **Rebuild**: centang "Hanguskan QR lama yang belum terpakai" lalu Buat QR → QR lama yang belum terpakai hangus,
  QR baru dibuat. QR yang sudah terpakai tidak berubah.
- **Pantau**: statistik Belum dipakai / Terpakai / Dinonaktifkan; tabel menampilkan waktu dipakai dan nama + WA pelanggan.
- **Cetak**: "Cetak lembar QR" (ukuran bisa diatur, kode tercetak di bawah tiap QR) atau "Download ZIP (PNG)"
  (PNG 1200px per QR, siap dikirim ke percetakan). Bisa difilter per batch.
- **Nonaktifkan / Aktifkan ulang** per QR (mis. pelanggan terpakai tapi gagal masuk grup → aktifkan ulang).

## Perilaku
- Halaman artikel tanpa QR (mis. dibuka dari daftar /artikel): konten tetap tampil, form diganti pesan
  "scan QR pada kemasan produk". Ini supaya batas sekali-pakai tidak bisa dilewati.
- QR lama (link artikel tanpa kode) tidak bisa lagi dipakai mendaftar — cetak ulang QR baru.
- Kode hanya hangus saat data tersimpan DAN link grup WA tersedia. Validasi form gagal / link grup kosong tidak menghanguskan.
- Klaim bersifat atomik: dua orang scan QR yang sama bersamaan → hanya satu yang berhasil.
- Mau kembali ke perilaku lama (form terbuka tanpa QR)? `NLUCK_REQUIRE_CODE=false` di `.env`.
- QR dibuat di browser (library lokal di `public/admin-assets/lib`), tidak butuh internet / API pihak ketiga.

## Tes
`php artisan test --filter=ArticleQrOneTimeTest`
