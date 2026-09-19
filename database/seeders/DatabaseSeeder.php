<?php

namespace Database\Seeders;

use App\Models\ArticleFormSetting;
use App\Models\SiteContent;
use App\Models\WhatsAppSetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);

        // Create safe production defaults without inserting demo products,
        // demo articles, fake leads, or fake analytics.
        ArticleFormSetting::current();
        SiteContent::current('filosofi');
        SiteContent::current('doa');

        WhatsAppSetting::updateOrCreate(['id' => 1], [
            'group_name' => env('WHATSAPP_GROUP_NAME', 'NLUCK Society'),
            'group_link' => env('WHATSAPP_GROUP_LINK', 'https://chat.whatsapp.com/GdjBGEwcX1L6VK7i3SPaLr'),
            'success_title' => 'Terima kasih!',
            'success_message' => 'Data Anda sudah kami terima. Silakan lanjut ke WhatsApp Group.',
            'contact_whatsapp' => env('WHATSAPP_CONTACT'),
            'contact_email' => env('WHATSAPP_CONTACT_EMAIL'),
            'instagram_url' => env('WHATSAPP_INSTAGRAM_URL', 'https://www.instagram.com/nluck.scarves'),
            'tiktok_url' => env('WHATSAPP_TIKTOK_URL', 'https://www.tiktok.com/@nluck.scarves'),
        ]);
    }
}
