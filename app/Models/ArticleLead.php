<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleLead extends Model
{
    protected $fillable = [
        'article_id', 'name', 'whatsapp', 'email', 'birth_date', 'city', 'instagram',
        'consent', 'source_url', 'status', 'ip_address', 'whatsapp_clicked_at',
    ];

    protected $casts = [
        'consent' => 'boolean',
        'birth_date' => 'date',
        'whatsapp_clicked_at' => 'datetime',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
