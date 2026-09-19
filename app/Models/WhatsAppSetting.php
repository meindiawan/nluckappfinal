<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppSetting extends Model
{
    protected $table = 'whatsapp_settings';

    protected $fillable = [
        'group_name', 'group_link', 'success_title', 'success_message',
        'contact_whatsapp', 'contact_email', 'instagram_url', 'tiktok_url', 'facebook_url',
    ];

    public static function current(): self
    {
        $setting = static::query()->first();

        if (! $setting) {
            return static::query()->create([
                'group_name' => 'NLUCK Society',
                'group_link' => (string) env('WHATSAPP_GROUP_LINK', ''),
                'success_title' => 'Terima kasih!',
                'success_message' => 'Data Anda sudah kami terima. Silakan lanjut ke WhatsApp Group.',
            ]);
        }

        return $setting;
    }

    /**
     * Direct wa.me chat link built from the contact_whatsapp number (if set).
     */
    public function getContactWhatsappLinkAttribute(): ?string
    {
        return $this->waLink('Halo NLUCK, saya ingin bertanya tentang produk kalian.');
    }

    /**
     * Build a wa.me link to the configured contact number with a custom prefilled message.
     */
    public function waLink(string $message): ?string
    {
        if (blank($this->contact_whatsapp)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $this->contact_whatsapp);

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        return 'https://wa.me/' . $digits . '?text=' . rawurlencode($message);
    }

    /**
     * Whether there is at least one social link configured, for footer rendering.
     */
    public function getHasSocialLinksAttribute(): bool
    {
        return filled($this->instagram_url) || filled($this->tiktok_url) || filled($this->facebook_url);
    }
}
