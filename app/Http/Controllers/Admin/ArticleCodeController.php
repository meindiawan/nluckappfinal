<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Kelola QR sekali pakai per artikel: buat (rebuild), pantau status terpakai, cetak, nonaktifkan.
 */
class ArticleCodeController extends Controller
{
    public function index(Request $request, Article $article)
    {
        // Mode QR biasa (NLUCK_REQUIRE_CODE=false): satu QR per artikel, bisa dipakai berulang seperti semula.
        if (! config('nluck.require_code')) {
            $base = rtrim((string) config('nluck.qr_base_url'), '/');
            $path = route('articles.show', $article, false);
            $target = $base !== '' ? $base . $path : url($path);

            return view('admin.articles.qr-simple', compact('article', 'target'));
        }

        $status = $this->status($request);
        $batch = $request->filled('batch') ? $request->integer('batch') : null;

        $filtered = $this->filtered($article, $status, $batch);

        $counts = ArticleCode::where('article_id', $article->id)
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN used_at IS NOT NULL THEN 1 ELSE 0 END) as used')
            ->selectRaw('SUM(CASE WHEN used_at IS NULL AND revoked_at IS NOT NULL THEN 1 ELSE 0 END) as revoked')
            ->first();
        $stats = [
            'total' => (int) $counts->total,
            'used' => (int) $counts->used,
            'revoked' => (int) $counts->revoked,
        ];
        $stats['unused'] = $stats['total'] - $stats['used'] - $stats['revoked'];

        $codes = (clone $filtered)->with('lead')->orderByDesc('batch')->orderBy('id')->paginate(50)->withQueryString();

        // Semua kode pada filter aktif (untuk "Download ZIP"), bukan hanya halaman yang tampil.
        $exportItems = (clone $filtered)->orderBy('id')->limit(2000)->get()->map(fn (ArticleCode $c) => [
            'code' => $c->code,
            'url' => $c->publicUrl(),
        ])->values();

        $batches = ArticleCode::where('article_id', $article->id)->select('batch')->distinct()->orderByDesc('batch')->pluck('batch');

        return view('admin.articles.qr', [
            'article' => $article,
            'codes' => $codes,
            'stats' => $stats,
            'status' => $status,
            'batch' => $batch,
            'batches' => $batches,
            'exportItems' => $exportItems,
            'sampleUrl' => (new ArticleCode(['code' => 'CONTOH'])) ->setRelation('article', $article)->publicUrl(),
        ]);
    }

    /** Buat QR baru. Dengan "revoke_unused" = rebuild: QR lama yang belum terpakai langsung dinonaktifkan. */
    public function generate(Request $request, Article $article): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:500'],
            'revoke_unused' => ['nullable', 'boolean'],
        ], [
            'quantity.required' => 'Isi jumlah QR yang ingin dibuat.',
            'quantity.max' => 'Maksimal 500 QR sekali buat.',
            'quantity.min' => 'Jumlah QR minimal 1.',
        ]);

        $revoked = 0;
        $batchNo = (int) ArticleCode::where('article_id', $article->id)->max('batch') + 1;

        DB::transaction(function () use ($article, $data, $request, $batchNo, &$revoked) {
            if ($request->boolean('revoke_unused')) {
                $revoked = ArticleCode::where('article_id', $article->id)->unused()->update(['revoked_at' => now()]);
            }

            $now = now();
            $rows = [];
            $seen = [];
            for ($i = 0; $i < (int) $data['quantity']; $i++) {
                do {
                    $code = ArticleCode::generateCode();
                } while (isset($seen[$code]));
                $seen[$code] = true;
                $rows[] = ['article_id' => $article->id, 'code' => $code, 'batch' => $batchNo, 'created_at' => $now, 'updated_at' => $now];
            }
            foreach (array_chunk($rows, 100) as $chunk) {
                ArticleCode::insert($chunk);
            }
        });

        $msg = "{$data['quantity']} QR baru dibuat (batch #{$batchNo}).";
        if ($revoked) {
            $msg .= " {$revoked} QR lama yang belum terpakai dinonaktifkan.";
        }

        return redirect()->route('admin.articles.qr', ['article' => $article, 'batch' => $batchNo, 'status' => 'unused'])->with('success', $msg);
    }

    public function print(Request $request, Article $article)
    {
        $status = $this->status($request, 'unused');
        $batch = $request->filled('batch') ? $request->integer('batch') : null;
        $size = min(8, max(2, (float) $request->input('size', 3.5)));

        $items = $this->filtered($article, $status, $batch)->orderBy('id')->limit(2000)->get()->map(fn (ArticleCode $c) => [
            'code' => $c->code,
            'url' => $c->publicUrl(),
        ])->values();

        return view('admin.articles.qr-print', compact('article', 'items', 'size', 'status', 'batch'));
    }

    /** Hanguskan semua QR yang belum terpakai pada artikel ini. */
    public function revokeUnused(Article $article): RedirectResponse
    {
        $n = ArticleCode::where('article_id', $article->id)->unused()->update(['revoked_at' => now()]);

        return back()->with('success', "{$n} QR yang belum terpakai dinonaktifkan.");
    }

    public function revoke(Article $article, ArticleCode $code): RedirectResponse
    {
        abort_unless((int) $code->article_id === (int) $article->id, 404);

        if ($code->used_at) {
            return back()->with('error', 'QR ini sudah terpakai, tidak perlu dinonaktifkan.');
        }

        $code->update(['revoked_at' => now()]);

        return back()->with('success', "QR {$code->code} dinonaktifkan.");
    }

    /** Aktifkan ulang (mis. QR salah nonaktif, atau pelanggan gagal masuk grup padahal QR sudah terpakai). */
    public function restore(Article $article, ArticleCode $code): RedirectResponse
    {
        abort_unless((int) $code->article_id === (int) $article->id, 404);

        $code->forceFill(['used_at' => null, 'revoked_at' => null, 'lead_id' => null])->save();

        return back()->with('success', "QR {$code->code} diaktifkan kembali (bisa dipakai sekali lagi).");
    }

    private function status(Request $request, string $default = 'all'): string
    {
        $status = (string) $request->input('status', $default);

        return in_array($status, ['all', 'unused', 'used', 'revoked'], true) ? $status : $default;
    }

    private function filtered(Article $article, string $status, ?int $batch)
    {
        return ArticleCode::query()
            ->where('article_id', $article->id)
            ->when($batch, fn ($q) => $q->where('batch', $batch))
            ->when($status === 'unused', fn ($q) => $q->unused())
            ->when($status === 'used', fn ($q) => $q->whereNotNull('used_at'))
            ->when($status === 'revoked', fn ($q) => $q->whereNull('used_at')->whereNotNull('revoked_at'));
    }
}
