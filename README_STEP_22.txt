STEP 22 — ARTICLE FORM SETTINGS

Tujuan
- Admin mengatur form pelanggan tanpa mengedit kode.
- Field dapat ditampilkan/disembunyikan.
- Field tambahan dapat dibuat wajib/opsional.
- Judul, deskripsi, CTA, consent, dan teks sukses dapat diedit.
- Pengaturan berlaku untuk seluruh artikel publik yang memakai lead form.

INSTALL
1. Copy migration ke database/migrations.
2. Copy app/Models/ArticleFormSetting.php.
3. Copy app/Http/Controllers/Admin/ArticleFormSettingController.php.
4. Copy resources/views/admin/form-settings/edit.blade.php.
5. Copy public/admin/form-settings/settings.css.
6. Copy routes/article-form-settings.php.
7. Tambahkan require base_path('routes/article-form-settings.php'); ke routes/web.php.
8. Tambahkan menu sidebar route admin.form-settings.edit.
9. Pastikan layouts/admin.blade.php memuat @stack('styles').
10. Terapkan patch studio-render-form.patch.txt agar form publik memakai setting.
11. Terapkan patch ArticleLeadController.php.patch.txt agar validasi mengikuti field yang aktif.
12. Jalankan php artisan migrate.

Default
- Nama dan WhatsApp selalu aktif + wajib.
- Email, tanggal lahir, kota, Instagram aktif tetapi opsional.
- Consent aktif + wajib.

Catatan
- Pengaturan bersifat global untuk semua artikel.
- Jika ingin pengaturan berbeda per artikel, dapat dibuat pada step lanjutan dengan tabel article_form_overrides.
