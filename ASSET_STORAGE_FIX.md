# NLUCK Asset Storage Fix

Perbaikan mempertahankan fitur yang sudah ada dan membuat asset lebih portable.

- Upload tetap ke `storage/app/public/media`.
- URL asset lokal sekarang relatif (`/storage/...`), tidak bergantung pada `localhost`/`127.0.0.1`.
- Studio iframe dan API menggunakan URL relatif/same-origin.
- URL asset lama dari `localhost`/`127.0.0.1` dinormalisasi agar tetap tampil.
- Thumbnail artikel lokal menggunakan URL relatif.
- `.env` lokal memakai `FILESYSTEM_DISK=public`.

Setelah instalasi:
```bash
php artisan optimize:clear
php artisan storage:link
```

Production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com
FILESYSTEM_DISK=public
```
Lalu:
```bash
php artisan optimize:clear
php artisan storage:link
```
