<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleLead;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = ArticleLead::query()->with('article')->latest();
        if ($q = trim((string) $request->input('q'))) {
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('whatsapp', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%");
            });
        }
        if ($request->filled('article_id')) $query->where('article_id', $request->integer('article_id'));
        if ($request->filled('status')) $query->where('status', $request->input('status'));
        if ($request->filled('from')) $query->whereDate('created_at', '>=', $request->input('from'));
        if ($request->filled('to')) $query->whereDate('created_at', '<=', $request->input('to'));

        $stats = [
            'total' => ArticleLead::count(),
            'today' => ArticleLead::whereDate('created_at', today())->count(),
            'new' => ArticleLead::where('status', 'new')->count(),
            'this_month' => ArticleLead::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
        ];

        return view('admin.leads.index', [
            'leads' => $query->paginate(20)->withQueryString(),
            'articles' => Article::orderBy('title')->get(['id','title']),
            'stats' => $stats,
        ]);
    }

    public function show(ArticleLead $lead)
    {
        $lead->load('article');
        return view('admin.leads.show', compact('lead'));
    }

    public function status(Request $request, ArticleLead $lead)
    {
        $data = $request->validate(['status' => ['required','in:new,contacted,qualified,closed']]);
        $lead->update($data);
        return back()->with('success', 'Status lead diperbarui.');
    }

    public function destroy(ArticleLead $lead)
    {
        $lead->delete();
        return back()->with('success', 'Lead dihapus.');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = ArticleLead::query()->with('article')->latest();
        if ($request->filled('article_id')) $query->where('article_id', $request->integer('article_id'));
        if ($request->filled('status')) $query->where('status', $request->input('status'));
        if ($request->filled('from')) $query->whereDate('created_at', '>=', $request->input('from'));
        if ($request->filled('to')) $query->whereDate('created_at', '<=', $request->input('to'));

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Tanggal','Nama','WhatsApp','Email','Tanggal Lahir','Kota','Instagram','Artikel','Status','Sumber']);
            $query->chunk(500, function ($leads) use ($out) {
                foreach ($leads as $lead) {
                    fputcsv($out, [$lead->created_at?->format('Y-m-d H:i'), $lead->name, $lead->whatsapp, $lead->email, $lead->birth_date, $lead->city, $lead->instagram, $lead->article?->title, $lead->status, $lead->source_url]);
                }
            });
            fclose($out);
        }, 'nluck-leads-'.now()->format('Y-m-d-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
