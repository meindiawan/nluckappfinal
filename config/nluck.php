<?php

/*
| Pengaturan khusus NLUCK.
| Dibaca lewat config() (bukan env() langsung) supaya tetap bekerja
| walaupun `php artisan config:cache` sudah dijalankan di production.
*/
return [
    'admin' => [
        'username' => env('ADMIN_USERNAME'),
        'password' => env('ADMIN_PASSWORD'),
        'email' => env('ADMIN_EMAIL', 'admin@nluck.id'),
    ],

    'social' => [
        'group_name' => env('WHATSAPP_GROUP_NAME', 'NLUCK Society'),
        'group_link' => env('WHATSAPP_GROUP_LINK', 'https://chat.whatsapp.com/GdjBGEwcX1L6VK7i3SPaLr'),
        'contact_whatsapp' => env('WHATSAPP_CONTACT'),
        'contact_email' => env('WHATSAPP_CONTACT_EMAIL'),
        'instagram_url' => env('WHATSAPP_INSTAGRAM_URL', 'https://www.instagram.com/nluck.scarves'),
        'tiktok_url' => env('WHATSAPP_TIKTOK_URL', 'https://www.tiktok.com/@nluck.scarves'),
    ],
];
