STEP 21 — Customer Form Success + WhatsApp Handoff

Tujuan
- Setelah pelanggan submit form, tampilkan halaman sukses profesional.
- Jangan langsung redirect ke WhatsApp dari POST form.
- Tombol WhatsApp melewati route tracking STEP 20 agar whatsapp_clicked_at tercatat.
- Auto redirect 3 detik melalui route tracking.
- Jika link group belum diatur admin, tampilkan pesan yang aman dan tombol kembali.

INSTALL
1. Copy app/Http/Controllers/ArticleLeadSuccessController.php ke project.
2. Copy resources/views/articles/lead-success.blade.php.
3. Copy routes/article-lead-success.php.
4. Tambahkan di routes/web.php:
   require base_path('routes/article-lead-success.php');
   Pastikan STEP 20 juga sudah diregistrasikan.
5. Terapkan patch di patches/ArticleLeadController.php.patch.txt pada ArticleLeadController::store.
6. Pastikan route STEP 20 bernama articles.whatsapp.click dan menerima {slug} + {lead}.

HASIL
POST /artikel/{slug}/daftar
 -> simpan lead
 -> session nluck_lead_id
 -> GET /artikel/{slug}/berhasil
 -> tombol/auto redirect
 -> /artikel/{slug}/whatsapp/{lead}
 -> catat whatsapp_clicked_at
 -> WhatsApp Group

CATATAN
- Session digunakan agar halaman sukses tidak dapat dipakai untuk mengambil lead sembarang hanya dengan ID URL.
- Auto redirect tetap melewati endpoint tracking.
- Tidak mengubah desain Studio; halaman sukses hanya muncul setelah submit form.
