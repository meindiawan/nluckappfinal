STEP 17 — Customer Lead Management

Tujuan:
Membuat lead dari form artikel dapat dikelola admin.

Isi:
- Dashboard statistik lead.
- Pencarian nama/WhatsApp/email/kota.
- Filter artikel, status, tanggal.
- Detail lead.
- Status: new, contacted, qualified, closed.
- Hapus lead.
- Export CSV dengan filter yang sedang aktif.

INSTALASI:
1. Salin file ke project Laravel.
2. Jalankan php artisan migrate.
3. Tambahkan require base_path('routes/leads-admin.php'); ke routes/web.php (atau gabungkan route-nya).
4. Pastikan layout admin sudah memiliki @stack('styles').
5. Tambahkan menu sidebar ke route('admin.leads.index').

CATATAN:
File migration ini menambahkan kolom status ke tabel article_leads dari STEP 16. Jika kolom status sudah dibuat di project Anda, jangan menjalankan migration ini; gabungkan perubahan seperlunya.
