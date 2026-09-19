<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleLead;
use App\Models\ArticleView;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name'=>'Aluna Sand','slug'=>'aluna-sand','sku'=>'ALUNA-SAND','category'=>'Square','description'=>'Scarf bernuansa sand yang lembut dengan tampilan elegan untuk gaya sehari-hari.','price'=>129000,'compare_price'=>149000,'stock'=>18,'status'=>'active','featured'=>true,'image'=>'assets/products/aluna-sand-1.jpg','sort_order'=>1],
            ['name'=>'Amara Cocoa','slug'=>'amara-cocoa','sku'=>'AMARA-COCOA','category'=>'Square','description'=>'Warna cocoa yang hangat, mudah dipadukan untuk tampilan modest yang refined.','price'=>139000,'compare_price'=>159000,'stock'=>14,'status'=>'active','featured'=>true,'image'=>'assets/products/amara-cocoa-1.jpg','sort_order'=>2],
            ['name'=>'Elara Rose','slug'=>'elara-rose','sku'=>'ELARA-ROSE','category'=>'Square','description'=>'Sentuhan rose yang feminin dengan karakter warna yang tetap modern dan tenang.','price'=>135000,'compare_price'=>155000,'stock'=>11,'status'=>'active','featured'=>true,'image'=>'assets/products/elara-rose-1.jpg','sort_order'=>3],
            ['name'=>'Hana Olive','slug'=>'hana-olive','sku'=>'HANA-OLIVE','category'=>'Square','description'=>'Olive yang natural dan versatile untuk koleksi harian NLUCK.','price'=>129000,'compare_price'=>149000,'stock'=>21,'status'=>'active','featured'=>false,'image'=>'assets/products/hana-olive-1.jpg','sort_order'=>4],
            ['name'=>'Naya Taupe','slug'=>'naya-taupe','sku'=>'NAYA-TAUPE','category'=>'Square','description'=>'Taupe netral dengan kesan clean dan effortless.','price'=>129000,'compare_price'=>149000,'stock'=>16,'status'=>'active','featured'=>false,'image'=>'assets/products/naya-taupe-1.jpg','sort_order'=>5],
            ['name'=>'Raina Stone','slug'=>'raina-stone','sku'=>'RAINA-STONE','category'=>'Square','description'=>'Stone tone yang sophisticated untuk gaya minimal dan timeless.','price'=>139000,'compare_price'=>159000,'stock'=>9,'status'=>'active','featured'=>false,'image'=>'assets/products/raina-stone-1.jpg','sort_order'=>6],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(['slug'=>$data['slug']], $data);
        }

        $articles = [
            ['title'=>'Menemukan Elegansi dalam Kesederhanaan','slug'=>'menemukan-elegansi-dalam-kesederhanaan','subtitle'=>'Cerita di balik NLUCK Collection','excerpt'=>'Tentang warna, detail, dan cara sederhana membuat penampilan terasa lebih bermakna.','thumbnail'=>'assets/hero/hero-illustration.jpg','status'=>'published','featured'=>true,'sort_order'=>1],
            ['title'=>'Memilih Warna Scarf untuk Setiap Momen','slug'=>'memilih-warna-scarf-untuk-setiap-momen','subtitle'=>'Panduan singkat NLUCK','excerpt'=>'Kenali karakter warna dan temukan pilihan scarf yang paling sesuai dengan gaya kamu.','thumbnail'=>'assets/hero/about-illustration.jpg','status'=>'published','featured'=>true,'sort_order'=>2],
            ['title'=>'Cerita di Balik Aluna Sand','slug'=>'cerita-di-balik-aluna-sand','subtitle'=>'A warm neutral for every day','excerpt'=>'Aluna Sand hadir dengan nuansa lembut yang mudah menyatu dengan berbagai gaya.','thumbnail'=>'assets/products/aluna-sand-1.jpg','status'=>'published','featured'=>false,'sort_order'=>3],
            ['title'=>'Amara Cocoa: Warm, Calm, Timeless','slug'=>'amara-cocoa-warm-calm-timeless','subtitle'=>'Mengenal karakter warna cocoa','excerpt'=>'Palet cocoa memberi kesan hangat dan dewasa tanpa terasa berlebihan.','thumbnail'=>'assets/products/amara-cocoa-1.jpg','status'=>'published','featured'=>false,'sort_order'=>4],
            ['title'=>'Elara Rose dan Sentuhan Feminin','slug'=>'elara-rose-dan-sentuhan-feminin','subtitle'=>'Soft color, strong character','excerpt'=>'Rose yang lembut untuk tampilan yang personal, modern, dan tetap effortless.','thumbnail'=>'assets/products/elara-rose-1.jpg','status'=>'published','featured'=>false,'sort_order'=>5],
            ['title'=>'NLUCK Society','slug'=>'nluck-society','subtitle'=>'Lebih dekat dengan koleksi dan benefit kami','excerpt'=>'Bergabung dengan NLUCK Society untuk mendapatkan informasi koleksi dan benefit eksklusif.','thumbnail'=>'assets/hero/dua-illustration.jpg','status'=>'draft','featured'=>false,'sort_order'=>6],
        ];

        foreach ($articles as $data) {
            $data['published_at'] = $data['status'] === 'published' ? now()->subDays(max(0, 6 - $data['sort_order'])) : null;
            $data['content_json'] = json_encode([
                'theme'=>'infinia',
                'background'=>'plain',
                'accent'=>'#A98357',
                'layout'=>'cards',
                'rounded'=>true,
                'shadow'=>true,
                'floral'=>true,
                'overlay'=>true,
                'content'=>[
                    'collection_name'=>'NLUCK SCARVES',
                    'hero_title'=>$data['title'],
                    'hero_subtitle'=>$data['subtitle'],
                    'hero_paragraph'=>$data['excerpt'],
                    'hero_badge'=>'COLLECTION STORY',
                    'philosophy_title'=>'Grace Beyond Beauty',
                    'philosophy_paragraph_1'=>'Detail yang sederhana dapat membuat sebuah penampilan terasa lebih personal.',
                    'philosophy_paragraph_2'=>'NLUCK menghadirkan koleksi yang mudah dipakai, lembut dipandang, dan dekat dengan keseharian.'
                ],
            ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

            Article::updateOrCreate(['slug'=>$data['slug']], $data);
        }

        // Seed the original NLUCK image library so Studio and Media Library are useful immediately.
        $mediaFiles = [];
        $assetRoot = public_path('assets');
        if (is_dir($assetRoot)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($assetRoot, \FilesystemIterator::SKIP_DOTS)
            );
            foreach ($iterator as $file) {
                if (! $file->isFile()) {
                    continue;
                }
                $extension = strtolower($file->getExtension());
                if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'svg'], true)) {
                    continue;
                }
                $relative = str_replace('\\', '/', str_replace(public_path() . DIRECTORY_SEPARATOR, '', $file->getPathname()));
                $mediaFiles[] = $relative;
            }
        }

        foreach ($mediaFiles as $relative) {
            $absolutePath = public_path($relative);
            $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
            $mime = match ($extension) {
                'jpg', 'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'webp' => 'image/webp',
                'svg' => 'image/svg+xml',
                default => 'application/octet-stream',
            };

            \App\Models\MediaAsset::updateOrCreate(
                ['path' => $relative],
                [
                    'name' => basename($absolutePath),
                    'disk' => 'public',
                    'mime_type' => $mime,
                    'size' => is_file($absolutePath) ? filesize($absolutePath) : null,
                    'alt_text' => 'NLUCK asset ' . basename($absolutePath),
                ]
            );
        }

        // Configure the NLUCK Society WhatsApp Group used by the customer flow.
        \App\Models\WhatsAppSetting::updateOrCreate(
            ['id' => 1],
            [
                'group_name' => 'NLUCK Society',
                'group_link' => env('WHATSAPP_GROUP_LINK', 'https://chat.whatsapp.com/DEMO_ONLY_CONFIGURE_IN_ENV'),
                'success_title' => 'Terima kasih!',
                'success_message' => 'Data Anda sudah kami terima. Silakan lanjut ke WhatsApp Group.',
                'contact_whatsapp' => env('WHATSAPP_CONTACT', '6281234567890'),
                'contact_email' => 'hello@nluck.id',
            ]
        );

        // Demo analytics: idempotent records so the dashboard is immediately populated.
        $published = Article::where('status','published')->orderBy('sort_order')->get();

        foreach ($published as $articleIndex => $article) {
            for ($i = 0; $i < (18 - ($articleIndex * 2)); $i++) {
                $dayOffset = ($i + $articleIndex) % 7;
                $created = now()->subDays($dayOffset)->setTime(9 + ($i % 9), ($i * 7) % 60);
                ArticleView::updateOrCreate(
                    ['session_key' => 'demo-session-'.$article->id.'-'.$i, 'article_id' => $article->id],
                    [
                        'ip_hash' => hash('sha256', 'demo-'.$article->id.'-'.$i),
                        'user_agent' => 'NLUCK Demo Analytics',
                        'referer' => 'demo-seeder',
                        'created_at' => $created,
                        'updated_at' => $created,
                    ]
                );
            }
        }

        $leadNames = ['Siti Rahma','Dewi Ananda','Nadia Putri','Putri Wulandari','Alya Safitri','Rani Maharani','Nisa Aulia','Fira Amalia'];
        foreach ($leadNames as $i => $name) {
            $article = $published[$i % max(1, $published->count())] ?? null;
            $created = now()->subDays($i % 6)->setTime(10 + ($i % 7), 12 + $i);
            ArticleLead::updateOrCreate(
                ['whatsapp' => '08123456'.str_pad((string)(100 + $i), 3, '0', STR_PAD_LEFT), 'name' => $name],
                [
                    'article_id' => $article?->id,
                    'email' => strtolower(str_replace(' ','.',$name)).'@example.test',
                    'city' => ['Jakarta','Bandung','Semarang','Surabaya'][$i % 4],
                    'consent' => true,
                    'status' => $i < 3 ? 'new' : ($i < 6 ? 'contacted' : 'qualified'),
                    'source_url' => $article ? '/artikel/'.$article->slug : '/artikel',
                    'whatsapp_clicked_at' => $i < 5 ? $created->copy()->addMinutes(8) : null,
                    'created_at' => $created,
                    'updated_at' => $created,
                ]
            );
        }
    }
}
