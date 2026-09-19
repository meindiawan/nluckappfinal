<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $fillable = ['key', 'eyebrow', 'title', 'lead', 'body_json', 'quote', 'image'];

    protected $casts = ['body_json' => 'array'];

    public static function current(string $key): self
    {
        $defaults = [
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

        abort_unless(isset($defaults[$key]), 404);
        $d = $defaults[$key];
        return static::query()->firstOrCreate(['key' => $key], [
            'eyebrow' => $d['eyebrow'], 'title' => $d['title'], 'lead' => $d['lead'],
            'body_json' => $d['body'], 'quote' => $d['quote'], 'image' => $d['image'],
        ]);
    }

    public function getBodyAttribute(): array
    {
        return is_array($this->body_json) ? $this->body_json : [];
    }
}
