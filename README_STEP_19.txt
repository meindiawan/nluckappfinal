STEP 19 — Business Dashboard

Tujuan: menyatukan Dashboard, Analytics, dan Leads menjadi satu halaman ringkas.

FILES:
- BusinessDashboardController.php
- admin/business-dashboard.blade.php
- public/admin/dashboard/business-dashboard.css
- routes/business-dashboard.php

INSTALL:
1. Copy controller/view/CSS/routes.
2. Load routes/business-dashboard.php dari routes/web.php atau gabungkan route-nya.
3. Pastikan Article memiliki relationships leads() dan views() dari STEP 18.
4. Pastikan route names admin.analytics, admin.leads.index, admin.articles.studio, admin.articles.index, admin.articles.create, admin.products.create, admin.media.index tersedia dari step sebelumnya.
5. Ganti dashboard route lama agar menunjuk BusinessDashboardController@index, atau gunakan route ini sebagai pengganti route dashboard lama.
6. Pastikan layouts/admin.blade.php memiliki @stack('styles') di <head>.

CATATAN:
- Funnel 'Diproses' memakai lead status != new sebagai indikator operasional, bukan bukti bahwa user benar-benar membuka WhatsApp.
- Untuk mengukur klik WhatsApp secara akurat, langkah berikutnya dapat menambahkan event tracking khusus tombol WhatsApp.
