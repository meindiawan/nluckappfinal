<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\SiteContent;

class PageController extends Controller
{
    public function show(string $page)
    {
        $pages = [
            'tentang-kami' => [
                'eyebrow' => 'TENTANG NLUCK',
                'title' => 'Tentang Kami',
                'lead' => 'NLUCK lahir dari keyakinan bahwa modest wear dapat terasa sederhana, personal, dan tetap berkelas.',
                'body' => [
                    'NLUCK adalah ruang untuk menemukan kerudung yang menyertai keseharian—dari pagi yang tenang, agenda kerja, pertemuan keluarga, hingga momen istimewa.',
                    'Kami memilih palet warna yang mudah dipadukan, material yang nyaman, dan detail yang tidak berlebihan. Setiap koleksi dirancang agar terasa dekat dengan pemakainya: ringan dilihat, mudah digunakan, dan punya karakter.',
                    'Bagi NLUCK, keindahan bukan tentang menjadi paling ramai. Keindahan adalah ketika sesuatu terasa tepat, nyaman, dan mampu membuat pemakainya percaya diri.',
                ],
                'quote' => 'Elegan dalam setiap langkah.',
                'image' => 'assets/hero/about-illustration.jpg',
            ],
            'filosofi' => [
                'eyebrow' => 'FILOSOFI',
                'title' => 'Grace Beyond Beauty',
                'lead' => 'Kami percaya gaya yang paling berkesan adalah gaya yang terasa jujur terhadap diri sendiri.',
                'body' => [
                    'Kesederhanaan — kami mengurangi hal yang tidak perlu agar warna, tekstur, dan bentuk dapat berbicara dengan tenang.',
                    'Kenyamanan — sebuah scarf bukan hanya terlihat indah. Ia harus mudah dibentuk, nyaman dipakai, dan mendukung aktivitas sehari-hari.',
                    'Ketulusan — setiap koleksi membawa niat untuk menjadi bagian kecil dari perjalanan pemakainya, bukan sekadar menjadi benda yang dikenakan.',
                    'Kehangatan — NLUCK ingin terasa seperti teman yang dekat: lembut, tidak menggurui, dan selalu memberi ruang untuk menjadi diri sendiri.',
                ],
                'quote' => 'Simple, thoughtful, meaningful.',
                'image' => 'assets/hero/hero-illustration.jpg',
            ],
            'doa' => [
                'eyebrow' => 'DOA NLUCK',
                'title' => 'Semoga setiap langkah membawa kebaikan.',
                'lead' => 'Di balik setiap koleksi, kami menyimpan doa sederhana untuk setiap perempuan yang memakainya.',
                'body' => [
                    'Semoga apa yang kamu kenakan menjadi pengingat untuk berjalan dengan tenang, menjaga hati, dan membawa kebaikan di mana pun berada.',
                    'Semoga hari-harimu dipenuhi kemudahan, rezeki yang baik, orang-orang yang tulus, serta keberanian untuk terus bertumbuh.',
                    'Dan semoga NLUCK dapat menjadi bagian kecil dari perjalanan itu—bukan hanya sebagai kerudung, tetapi sebagai teman dalam setiap langkah.',
                ],
                'quote' => 'Bismillah untuk setiap langkah, semoga selalu dalam kebaikan.',
                'image' => 'assets/hero/dua-illustration.jpg',
            ],
        ];

        abort_unless(isset($pages[$page]), 404);

        if (in_array($page, ['filosofi', 'doa'], true)) {
            $saved = SiteContent::current($page);
            $content = [
                'eyebrow' => $saved->eyebrow,
                'title' => $saved->title,
                'lead' => $saved->lead,
                'body' => $saved->body,
                'quote' => $saved->quote,
                'image' => $saved->image ?: $pages[$page]['image'],
            ];
        } else {
            $content = $pages[$page];
        }
        $products = Product::where('status', 'active')->orderByDesc('featured')->orderBy('sort_order')->limit(4)->get();
        $articles = Article::where('status', 'published')->orderByDesc('featured')->orderBy('sort_order')->latest('published_at')->limit(3)->get();

        return view('pages.show', compact('content', 'page', 'products', 'articles'));
    }
}
