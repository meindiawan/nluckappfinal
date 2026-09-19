NLUCK Laravel STEP 4 — ARTICLES + NLUCK STUDIO

1. Copy app/Models/Article.php and app/Http/Controllers/Admin/ArticleController.php.
2. Copy the migration into database/migrations.
3. Copy resources/views/admin/articles and add ADMIN_ARTICLE_CSS.txt into the admin stylesheet.
4. Copy routes/articles.php and require it from routes/web.php, OR copy its routes into the existing admin auth group.
5. Copy public/studio/ into Laravel public/studio/. The included admin.html is already patched for Laravel save/load events.
6. Run: php artisan migrate
7. Login to /admin, then open /admin/articles.
8. Create article -> Buka Studio. Studio loads saved design from DB.
9. Press "Simpan & Terbitkan" in Studio. The complete design state is POSTed to Laravel and stored in articles.content_json.
10. The next module (STEP 5) should expose published articles publicly and render the saved NLUCK Studio design instead of localStorage.

IMPORTANT: image assets from the legacy Studio are currently stored in content_json as data URLs. This makes the module fully functional without requiring a second upload API, but STEP 5/production hardening should migrate those assets to Laravel Storage for better performance.
