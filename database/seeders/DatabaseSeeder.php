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
            'group_name' => config('nluck.social.group_name'),
            'group_link' => config('nluck.social.group_link'),
            'success_title' => 'Terima kasih!',
            'success_message' => 'Data Anda sudah kami terima. Silakan lanjut ke WhatsApp Group.',
            'contact_whatsapp' => config('nluck.social.contact_whatsapp'),
            'contact_email' => config('nluck.social.contact_email'),
            'instagram_url' => config('nluck.social.instagram_url'),
            'tiktok_url' => config('nluck.social.tiktok_url'),
        ]);
    }
}
