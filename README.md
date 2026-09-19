# NLUCK — Production Ready

Laravel 12 application for the NLUCK public catalog, articles, NLUCK Studio, admin dashboard, media library, leads, analytics, products and WhatsApp customer flow.

## Hosting requirements
- PHP 8.2+ with `pdo_mysql`, `fileinfo`, `mbstring`, `openssl`, `json`, `ctype`, `curl`, `tokenizer`, `xml`
- MySQL 8.0+ / MariaDB 10.6+
- Composer 2.x
- Node.js 20+ only if building frontend assets on the server

## Production setup
1. Upload the project outside the public web root when your host allows it.
2. Point the domain document root to the project's `public/` directory.
3. Copy `.env.example` to `.env` and fill in database, domain, and admin credentials.
4. Generate the app key:
   `php artisan key:generate --force`
5. Install dependencies:
   `composer install --no-dev --optimize-autoloader`
6. Run migrations and the safe production seeder:
   `php artisan migrate --force --seed`
7. Create the public storage link:
   `php artisan storage:link`
8. Clear and cache production configuration:
   `php artisan optimize:clear`
   `php artisan config:cache`
   `php artisan route:cache`
   `php artisan view:cache`

## Important
- Do NOT run `migrate:fresh` on production.
- Do NOT use the old demo password. `ADMIN_USERNAME` and `ADMIN_PASSWORD` are required for seeding and the password must be at least 12 characters.
- `DemoContentSeeder` is intentionally NOT called by `DatabaseSeeder`. It is only for local/demo environments.
- Configure the real WhatsApp Group URL from Admin > WhatsApp & Sosial Media after deployment.
- `APP_DEBUG` must remain `false` in production.
- Keep `.env`, `vendor/`, `storage/app/private/`, and other server-only files out of the public document root.

## Optional local demo data
If you want the original demo catalog/articles/analytics locally:
`php artisan db:seed --class=DemoContentSeeder`

## Frontend build
If the server supports Node:
`npm ci && npm run build`

The current application primarily serves its own public/admin CSS and Studio assets, so a frontend build is not required unless future changes add Vite imports.
