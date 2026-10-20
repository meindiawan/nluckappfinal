<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Satu baris = satu QR fisik yang ditempel ke satu produk.
 * Hanya bisa dipakai SEKALI: setelah pelanggan mengisi form dan diarahkan ke grup WA, QR hangus.
 */
class ArticleCode extends Model
{
    public const STATUS_UNUSED = 'unused';
    public const STATUS_USED = 'used';
    public const STATUS_REVOKED = 'revoked';

    // Tanpa karakter yang mudah tertukar (0/O, 1/I/L).
    private const ALPHABET = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';

    protected $fillable = ['article_id', 'code', 'batch', 'used_at', 'lead_id', 'revoked_at'];

    protected $casts = ['used_at' => 'datetime', 'revoked_at' => 'datetime'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(ArticleLead::class, 'lead_id');
    }

    public function getStatusAttribute(): string
    {
        if ($this->used_at) return self::STATUS_USED;
        if ($this->revoked_at) return self::STATUS_REVOKED;
        return self::STATUS_UNUSED;
    }

    public function isUsable(): bool
    {
        return $this->status === self::STATUS_UNUSED;
    }

    public function scopeUnused($q)
    {
        return $q->whereNull('used_at')->whereNull('revoked_at');
    }

    public static function normalize(?string $code): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', (string) $code));
    }

    public static function generateCode(): string
    {
        do {
            $code = '';
            for ($i = 0; $i < 12; $i++) {
                $code .= self::ALPHABET[random_int(0, strlen(self::ALPHABET) - 1)];
            }
        } while (static::where('code', $code)->exists());

        return $code;
    }

    /**
     * Menentukan status QR untuk sebuah halaman artikel.
     * Return [state, ArticleCode|null]; state: open | none | invalid | valid | used | revoked
     */
    public static function resolveFor(Article $article, ?string $raw): array
    {
        if (! config('nluck.require_code')) {
            return ['open', null];
        }

        $normalized = self::normalize($raw);
        if ($normalized === '') {
            return ['none', null];
        }

        $code = static::where('article_id', $article->id)->where('code', $normalized)->first();
        if (! $code) {
            return ['invalid', null];
        }

        return [$code->isUsable() ? 'valid' : $code->status, $code];
    }

    /** URL yang dimasukkan ke dalam QR. */
    public function publicUrl(): string
    {
        $base = rtrim((string) config('nluck.qr_base_url'), '/');
        $path = route('articles.show', $this->article, false) . '?k=' . $this->code;

        return $base !== '' ? $base . $path : url($path);
    }
}
