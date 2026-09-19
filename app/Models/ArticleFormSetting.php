<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleFormSetting extends Model
{
    protected $fillable = [
        'title','description','cta_text','success_title','success_message','consent_text',
        'show_name','show_whatsapp','show_email','show_birth_date','show_city','show_instagram',
        'require_email','require_birth_date','require_city','require_instagram','require_consent',
    ];

    protected $casts = [
        'show_name'=>'boolean','show_whatsapp'=>'boolean','show_email'=>'boolean','show_birth_date'=>'boolean',
        'show_city'=>'boolean','show_instagram'=>'boolean','require_email'=>'boolean','require_birth_date'=>'boolean',
        'require_city'=>'boolean','require_instagram'=>'boolean','require_consent'=>'boolean',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1], [
            'title' => 'Gabung NLUCK Society',
            'description' => 'Isi data singkat di bawah ini untuk mendapatkan informasi dan benefit eksklusif NLUCK Society.',
            'cta_text' => 'DAFTAR SEKARANG',
            'success_title' => 'Data berhasil diterima',
            'success_message' => 'Terima kasih. Data kamu sudah tersimpan. Selanjutnya lanjut ke WhatsApp Group.',
            'consent_text' => 'Saya bersedia menerima informasi produk terbaru dari NLUCK Scarves.',
        ]);
    }
}
