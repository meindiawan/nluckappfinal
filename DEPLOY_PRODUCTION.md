# NLUCK — Deployment Checklist (Production)

## 1. Hosting
Use a Laravel-capable hosting package with PHP 8.2+ and MySQL/MariaDB. Set the domain document root to `public/`.

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
- Do not expose the Laravel project root as the web document root; use `public/`.
- Do not run `DemoContentSeeder` unless you intentionally want demo data.
