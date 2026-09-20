<?php

namespace App\Providers;

use App\Models\WhatsAppSetting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Di production (APP_URL https) pastikan semua URL yang dibuat Laravel memakai https,
        // supaya tidak ada mixed content yang diblokir browser (mis. iframe NLUCK Studio).
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        // Make the WhatsApp group / contact / social settings available to every
        // public-facing page (footer, floating chat button, product CTAs) without
        // every controller having to fetch it manually.
        View::composer(
            ['layouts.catalog', 'layouts.articles', 'partials.footer', 'products.index', 'products.show', 'welcome', 'pages.show'],
            function ($view) {
                if (! array_key_exists('whatsappSetting', $view->getData())) {
                    $view->with('whatsappSetting', WhatsAppSetting::current());
                }
            }
        );
    }
}
