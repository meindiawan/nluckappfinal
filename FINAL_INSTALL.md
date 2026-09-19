# NLUCK Laravel — Final XAMPP Build

This package is intended to be extracted as `C:\xampp\htdocs\nluck`.

## Run on XAMPP

```powershell
cd C:\xampp\htdocs\nluck
composer install
php artisan optimize:clear
php artisan storage:link
php artisan migrate:fresh --seed
php artisan serve
```

Open:
- Public website: http://127.0.0.1:8000/
- Admin login: http://127.0.0.1:8000/admin/login

Default admin:
- Username: `admin`
- Password: `admin`

## Important behavior

- `/admin` is protected by Laravel `auth`.
- The default Laravel `login` route exists and redirects to `/admin/login`, so an unauthenticated visit to `/admin` does not throw `Route [login] not defined`.
- Admin logout redirects to the public NLUCK homepage `/`.
- Dashboard includes content cards, article catalog, product summaries, analytics, customer funnel, activities, and website page shortcuts.
- Article Studio includes design controls, content controls, image upload, media library selection, autosave/save/publish/preview flows.

## Production hosting

Point the domain document root to the project's `public/` directory. Set production `.env` values for MySQL, APP_URL, APP_ENV, APP_DEBUG=false, and storage configuration before going live.
