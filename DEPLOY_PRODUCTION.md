# NLUCK — Deployment Checklist (Production)

## 1. Hosting
Use a Laravel-capable hosting package with PHP 8.2+ and MySQL/MariaDB. Set the domain document root to `public/`. On shared hosting where the document root is fixed to the project root (e.g. Hostinger `public_html`), the root `.htaccess` in this repo routes every request into `public/` and keeps `.env`, `vendor/`, `app/` etc. unreachable from the web.

## 2. Environment
Copy `.env.example` to `.env` and set:
- `APP_URL=https://your-domain.com`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_*` according to the hosting database
- `ADMIN_USERNAME` and `ADMIN_PASSWORD` (minimum 12 characters)
- `WHATSAPP_GROUP_LINK` if you want it prefilled; otherwise set it from Admin > WhatsApp & Sosial Media

Never upload `.env` to a public repository or share it.

## 3. Commands
From the Laravel project root:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan migrate --force --seed
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If Node is available and frontend imports are later added:

```bash
npm ci
npm run build
```

## 4. First login
Open `/admin/login`, use the credentials from `.env`, then immediately verify:
- Account username/password can be changed
- WhatsApp Group URL is correct
- Contact WhatsApp/email/social links are correct
- Products and articles can be created
- NLUCK Studio can save a draft and publish
- Public article form redirects to the configured WhatsApp Group

## 5. Do not do this on production
- Do not run `php artisan migrate:fresh`.
- Do not set `APP_DEBUG=true`.
- Do not use `ADMIN_PASSWORD=admin` or another weak password.
- Do not replace the root `.htaccess` with the default Laravel one when the document root is the project root; it would expose `.env` and other files.
- Do not run `DemoContentSeeder` unless you intentionally want demo data.

## 6. Update after `git push` (Hostinger, SSH)
```bash
php artisan config:clear
php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder --force   # create/reset admin from ADMIN_USERNAME + ADMIN_PASSWORD in .env
php artisan storage:link
php artisan optimize:clear
```
After deploy, `https://your-domain.com/.env` must return 404.
