NLUCK Laravel — STEP 20
WhatsApp Click Tracking + Conversion Funnel

TUJUAN
Setelah pelanggan mengisi form, sistem tidak langsung redirect ke WhatsApp Group.
Sistem melewati endpoint tracking terlebih dahulu, mencatat waktu klik WhatsApp,
kemudian melakukan redirect ke link grup.

ALUR
Artikel -> Form -> Lead tersimpan -> Tracking click -> WhatsApp Group

FILE UTAMA
- app/Http/Controllers/ArticleWhatsAppController.php
- app/Models/ArticleLead.php
- database/migrations/2026_09_09_000008_add_whatsapp_tracking_to_article_leads.php
- routes/article-whatsapp-tracking.php

INTEGRASI
1. Jalankan migration.
2. Pastikan routes/article-whatsapp-tracking.php dimuat di routes/web.php.
3. Terapkan patches/ArticleLeadController.php.patch.txt ke controller Step 16.
4. Terapkan patches/AnalyticsController.php.patch.txt ke analytics Step 18.

KEAMANAN
Endpoint memastikan lead memang milik artikel yang diminta sebelum mencatat klik.
IP address tidak dipakai untuk tracking klik.

CATATAN
Klik WhatsApp hanya tercatat ketika pelanggan benar-benar melewati endpoint tracking.
Jika link grup kosong, pelanggan dikembalikan ke artikel dengan pesan informatif.
