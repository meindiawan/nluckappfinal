<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
| Footer hanya menampilkan ikon sosmed jika link-nya terisi di tabel
| whatsapp_settings. Di production baru, baris itu bisa kosong (seeder belum
| jalan), sehingga ikon tidak muncul. Migration ini mengisi link bawaan SEKALI
| saja, hanya jika semua link sosmed masih kosong. Setelah itu admin bebas
| mengubah/mengosongkan lewat Admin > WhatsApp & Sosial Media.
*/
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('whatsapp_settings')) {
            return;
        }

        $social = (array) config('nluck.social');
        $row = DB::table('whatsapp_settings')->orderBy('id')->first();

        if (! $row) {
            DB::table('whatsapp_settings')->insert([
                'group_name' => $social['group_name'] ?? 'NLUCK Society',
                'group_link' => $social['group_link'] ?? '',
                'success_title' => 'Terima kasih!',
                'success_message' => 'Data Anda sudah kami terima. Silakan lanjut ke WhatsApp Group.',
                'instagram_url' => $social['instagram_url'] ?? null,
                'tiktok_url' => $social['tiktok_url'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return;
        }

        $update = [];

        if (blank($row->instagram_url ?? null) && blank($row->tiktok_url ?? null) && blank($row->facebook_url ?? null)) {
            $update['instagram_url'] = $social['instagram_url'] ?? null;
            $update['tiktok_url'] = $social['tiktok_url'] ?? null;
        }

        if (blank($row->group_link ?? null) && filled($social['group_link'] ?? null)) {
            $update['group_link'] = $social['group_link'];
        }

        if ($update) {
            $update['updated_at'] = now();
            DB::table('whatsapp_settings')->where('id', $row->id)->update($update);
        }
    }

    public function down(): void
    {
        // Data bawaan; tidak ada yang perlu dibatalkan.
    }
};
