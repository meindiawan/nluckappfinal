STEP 16 — CUSTOMER LEAD FORM + WHATSAPP GROUP FLOW

Tujuan
- Artikel publik memiliki form lead di bagian NLUCK Society.
- Data pelanggan disimpan ke tabel article_leads.
- Setelah submit sukses, pelanggan otomatis diarahkan ke link undangan WhatsApp Group yang diatur admin.
- Link grup tidak di-hard-code di artikel.

File
- database/migrations/2026_09_09_000004_create_whatsapp_settings_table.php
- database/migrations/2026_09_09_000005_create_article_leads_table.php
- app/Models/WhatsAppSetting.php
- app/Models/ArticleLead.php
- app/Http/Controllers/Admin/WhatsAppSettingController.php
- app/Http/Controllers/ArticleLeadController.php
- resources/views/admin/whatsapp/edit.blade.php
- resources/views/articles/studio-render.blade.php
- public/admin/whatsapp/settings.css
- routes/whatsapp.php
- routes/article-leads.php

Cara pasang
1. Copy file-file package ke project Laravel sesuai folder.
2. Di routes/web.php tambahkan:
   require __DIR__.'/whatsapp.php';
   require __DIR__.'/article-leads.php';
3. Jika routes/* sudah di-load melalui RouteServiceProvider/bootstrap, cukup pastikan kedua file route tersebut di-include sesuai struktur project.
4. Jalankan:
   php artisan migrate
5. Login admin dan buka:
   /admin/whatsapp
6. Isi link undangan WhatsApp Group, contoh:
   https://chat.whatsapp.com/xxxxxxxxxxxxxxxx
7. Buka artikel published. Pelanggan mengisi form lalu submit.
8. Laravel menyimpan lead, kemudian redirect ke WhatsApp Group.

Catatan penting
- WhatsApp Group menggunakan link undangan chat.whatsapp.com. Link ini tidak mendukung pengiriman teks otomatis seperti wa.me nomor pribadi; flow ini memang mengarahkan pelanggan masuk ke grup.
- Untuk keamanan, form menggunakan CSRF, validasi server-side, dan hanya menerima artikel yang published.
- Nomor WhatsApp pelanggan disimpan setelah karakter non-nomor/non-plus dibersihkan.
- Jika link grup belum diatur, pelanggan tidak diarahkan keluar dan mendapat pesan di halaman artikel.

Jika project sudah memiliki routes/web.php yang menggabungkan file route lain, gabungkan dua route baru tersebut tanpa menduplikasi nama route.

Tambahan admin
- /admin/leads menampilkan lead yang masuk dan menyediakan pencarian.
- Tambahkan routes/leads.php ke web routes.
- Tambahkan menu Customer Leads dan WhatsApp Group pada sidebar admin menggunakan patches/admin-sidebar.txt.
