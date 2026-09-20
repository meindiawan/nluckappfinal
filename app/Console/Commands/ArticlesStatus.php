<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class ArticlesStatus extends Command
{
    protected $signature = 'nluck:articles {--fix : Tayangkan sekarang artikel berstatus terbit yang jadwal terbitnya masih di masa depan}';

    protected $description = 'Cek artikel: status, jadwal terbit, dan apakah tampil di website';

    public function handle(): int
    {
        $now = now();
        $this->info('Waktu server (aplikasi): '.$now->format('Y-m-d H:i:s').' ('.config('app.timezone').')');

        $articles = Article::orderByDesc('id')->get();

        if ($articles->isEmpty()) {
            $this->warn('Belum ada artikel di database ini.');

            return self::SUCCESS;
        }

        $fixed = 0;
        $rows = [];

        foreach ($articles as $article) {
            $future = $article->published_at && $article->published_at->gt($now);

            if ($this->option('fix') && $article->status === 'published' && $future) {
                $article->update(['published_at' => $now]);
                $article->refresh();
                $future = false;
                $fixed++;
            }

            $rows[] = [
                $article->id,
                mb_strimwidth((string) $article->title, 0, 32, '…'),
                $article->slug,
                $article->status,
                $article->published_at ? $article->published_at->format('Y-m-d H:i:s') : '-',
                ($article->status === 'published' && ! $future) ? 'YA' : 'TIDAK',
            ];
        }

        $this->table(['ID', 'Judul', 'Slug', 'Status', 'Terbit pada', 'Tampil?'], $rows);

        if ($fixed) {
            $this->info("{$fixed} artikel diperbaiki: jadwal terbit diubah ke sekarang.");
        }

        return self::SUCCESS;
    }
}
