STEP 9 — NLUCK Studio: autosave + draft/publish + preview

Tujuan:
- Studio tidak lagi menganggap tombol simpan sebagai publish otomatis.
- Perubahan desain/content otomatis dikirim ke Laravel setelah jeda 1,2 detik.
- Tombol Simpan Draft menyimpan ke server tanpa menerbitkan.
- Tombol Terbitkan mengubah status menjadi published dan mengisi published_at.
- Tombol Preview membuka preview dari design yang tersimpan di database.
- Status artikel tetap aman: autosave tidak menurunkan artikel published menjadi draft.

Cara pasang:
1. Ganti public/studio/admin.html dengan file dari paket ini.
2. Ganti resources/views/admin/articles/studio.blade.php.
3. Tambahkan method preview() ke Admin/ArticleController sesuai CONTROLLER_PREVIEW_METHOD.txt.
4. Gunakan controller ArticleController dari paket ini sebagai basis; jika ingin mempertahankan index/create/edit/update/destroy lama, gabungkan method studio/studioData/studioSave/unpublish/preview saja.
5. Tambahkan route dari routes/articles-studio-step9.php ke group middleware auth + prefix admin yang sudah ada.
6. Tambahkan view admin/articles/preview.blade.php.

Catatan:
- Jangan membuat group prefix admin kedua jika routes/articles.php sudah berada di dalam group tersebut.
- Article memakai route key slug pada Step 4, sehingga URL menggunakan slug.
- Preview admin tidak memerlukan status published karena hanya dapat dibuka oleh user admin.
