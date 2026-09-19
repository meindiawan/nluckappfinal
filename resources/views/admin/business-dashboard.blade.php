@extends('layouts.admin')

@section('title', 'Dashboard NLUCK')
@section('heading', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('admin-assets/dashboard.css') }}">
<style>
.dashboard-page{max-width:1380px}
.dashboard-hero{display:flex;justify-content:space-between;gap:24px;align-items:flex-end;margin-bottom:18px}
.dashboard-hero h2{margin:6px 0 5px;font:500 clamp(30px,3vw,43px)/1.05 Georgia,serif;letter-spacing:-.03em}
.dashboard-hero p{margin:0;color:#777068;font-size:13px;max-width:690px;line-height:1.6}
.dashboard-actions{display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end}
.dashboard-actions a{display:inline-flex;align-items:center;padding:10px 14px;border:1px solid #e1d9cf;border-radius:999px;background:#fffdfa;font-size:11px;font-weight:700}
.dashboard-actions a.primary{background:#25211d;color:#fff;border-color:#25211d}
.dashboard-filter{display:flex;align-items:center;gap:7px;margin:0 0 17px;width:max-content;padding:5px;border:1px solid #e4dcd2;border-radius:13px;background:#fffdfa}
.dashboard-filter input{border:0;background:transparent;outline:0;padding:8px 9px;color:#5f574f;font-size:11px}
.dashboard-filter button{border:0;border-radius:9px;background:#25211d;color:#fff;padding:9px 14px;font-size:11px;font-weight:700;cursor:pointer}
.dashboard-stat-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:16px}
.dashboard-stat{position:relative;background:#fffdfa;border:1px solid #e4dcd2;border-radius:18px;padding:18px;box-shadow:0 8px 26px rgba(43,35,27,.035)}
.dashboard-stat .label{font-size:10px;color:#887f76;text-transform:uppercase;letter-spacing:.08em;font-weight:700}
.dashboard-stat strong{display:block;margin:8px 0 4px;font:500 30px/1 Georgia,serif}
.dashboard-stat small{font-size:9px;color:#9a9188}
.dashboard-stat .arrow{position:absolute;right:16px;top:17px;color:#a27e5b;font-size:15px}
.dashboard-main-grid{display:grid;grid-template-columns:minmax(0,1.55fr) minmax(320px,.75fr);gap:16px;margin-bottom:16px}
.dashboard-panel{background:#fffdfa;border:1px solid #e4dcd2;border-radius:20px;padding:20px;box-shadow:0 8px 28px rgba(43,35,27,.035)}
.dashboard-panel.wide{min-width:0}
.dashboard-panel-head{display:flex;justify-content:space-between;gap:15px;align-items:flex-start;margin-bottom:16px}
.dashboard-panel-head h3{margin:0 0 4px;font:500 21px/1.1 Georgia,serif}
.dashboard-panel-head p{margin:0;color:#8a8178;font-size:10px;line-height:1.5}
.dashboard-panel-head a{font-size:10px;color:#786653;font-weight:800;white-space:nowrap}
.dashboard-chart{height:245px;border:1px solid #eee7df;border-radius:15px;background:#fff;overflow:hidden;padding:10px 10px 0}
.dashboard-chart svg{width:100%;height:100%;display:block}
.dashboard-legend{display:flex;gap:18px;margin-top:10px;color:#847b72;font-size:10px}
.dashboard-legend span{display:inline-flex;align-items:center;gap:6px}.dashboard-legend i{width:17px;height:3px;border-radius:5px;background:#9a7655}.dashboard-legend b{width:17px;height:3px;border-radius:5px;background:#b9c6ba;display:inline-block}
.dashboard-activity{border-top:1px solid #eee7df}
.dashboard-activity-row{display:flex;gap:10px;padding:12px 0;border-bottom:1px solid #eee7df}
.dashboard-activity-row:last-child{border-bottom:0}
.dashboard-activity-dot{width:8px;height:8px;border-radius:50%;background:#a27e5b;margin-top:5px;flex:0 0 auto}
.dashboard-activity-row strong{display:block;font-size:10px;line-height:1.4}.dashboard-activity-row small{display:block;color:#958c83;font-size:9px;margin-top:3px}
.dashboard-wide{margin-bottom:16px}
.dashboard-article-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:13px}
.dashboard-article-card{display:block;border:1px solid #e6ded4;border-radius:16px;background:#fff;overflow:hidden;transition:.18s}
.dashboard-article-card:hover{transform:translateY(-3px);box-shadow:0 14px 28px rgba(43,35,27,.07)}
.dashboard-article-cover{height:160px;background:#eee7dd;overflow:hidden;position:relative}
.dashboard-article-cover img{width:100%;height:100%;object-fit:cover;display:block}
.dashboard-article-cover .fallback{height:100%;display:grid;place-items:center;background:linear-gradient(135deg,#f1e9df,#e8dfd4)}.dashboard-article-cover .fallback img{width:56%;max-width:150px;opacity:.82;display:block}
.dashboard-article-badge{position:absolute;left:10px;top:10px;padding:5px 8px;border-radius:999px;background:#fffdf9e8;font-size:8px;font-weight:800;letter-spacing:.06em}
.dashboard-article-body{padding:14px}.dashboard-article-body small{font-size:9px;color:#9a9087}.dashboard-article-body h4{margin:6px 0 6px;font:600 17px/1.15 Georgia,serif}.dashboard-article-body p{margin:0;color:#81786f;font-size:10px;line-height:1.55;height:32px;overflow:hidden}.dashboard-status{display:inline-flex;margin-top:11px;padding:5px 8px;border-radius:999px;font-size:8px;font-weight:800}.dashboard-status.published{background:#e8f2e9;color:#38613f}.dashboard-status.draft{background:#f0efec;color:#6e6a64}
.dashboard-lower-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
.dashboard-page-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}.dashboard-page-card{border:1px solid #e8e0d7;border-radius:14px;padding:14px;background:#fff}.dashboard-page-card h4{margin:0 0 5px;font:600 14px Georgia,serif}.dashboard-page-card p{margin:0 0 11px;color:#8b8279;font-size:9px;line-height:1.5}.dashboard-page-card a{font-size:9px;font-weight:800;color:#7c6958}
.dashboard-product-list{display:grid;gap:8px}.dashboard-product{display:flex;gap:10px;align-items:center;border:1px solid #e8e0d7;border-radius:13px;padding:8px;background:#fff}.dashboard-product:hover{background:#fcfaf7}.dashboard-product-image{width:52px;height:52px;border-radius:10px;overflow:hidden;background:#eee7dd;flex:0 0 auto}.dashboard-product-image img{width:100%;height:100%;object-fit:cover}.dashboard-product-info{min-width:0}.dashboard-product-info strong{display:block;font-size:11px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.dashboard-product-info small{display:block;color:#8b8279;font-size:9px;margin-top:4px}
.dashboard-funnel{display:grid;grid-template-columns:1fr auto 1fr auto 1fr;align-items:center;gap:10px}.dashboard-funnel-step{border:1px solid #e6ded4;border-radius:14px;padding:16px;background:#fff;text-align:center}.dashboard-funnel-step small{display:block;color:#9a9087;font-size:8px;letter-spacing:.1em;font-weight:800}.dashboard-funnel-step strong{display:block;margin-top:6px;font:500 24px Georgia,serif}.dashboard-funnel-arrow{color:#a17d5a;font-size:20px}.dashboard-meta-line{display:flex;gap:12px;flex-wrap:wrap;margin-top:12px;padding-top:12px;border-top:1px solid #eee7df;color:#857c73;font-size:9px}.dashboard-meta-line b{color:#3e3934}
.dashboard-quick{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}.dashboard-quick a{border:1px solid #e6ded4;border-radius:14px;padding:14px;background:#fff}.dashboard-quick a:hover{background:#fcfaf7}.dashboard-quick strong{display:block;font-size:11px}.dashboard-quick small{display:block;color:#91877e;font-size:9px;line-height:1.45;margin-top:4px}
.dashboard-system{display:flex;gap:20px;flex-wrap:wrap;color:#8b8279;font-size:9px;padding:4px 2px}.dashboard-system b{color:#3b352f}
@media(max-width:1120px){.dashboard-stat-grid{grid-template-columns:repeat(3,1fr)}.dashboard-main-grid{grid-template-columns:1fr}.dashboard-article-grid{grid-template-columns:repeat(2,1fr)}.dashboard-page-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:760px){.dashboard-hero{align-items:flex-start;flex-direction:column}.dashboard-actions{justify-content:flex-start}.dashboard-stat-grid{grid-template-columns:repeat(2,1fr)}.dashboard-article-grid,.dashboard-lower-grid{grid-template-columns:1fr}.dashboard-page-grid{grid-template-columns:1fr}.dashboard-quick{grid-template-columns:1fr 1fr}.dashboard-filter{width:100%;justify-content:space-between}.dashboard-filter input{min-width:0;width:42%}}
@media(max-width:500px){.dashboard-stat-grid{grid-template-columns:1fr 1fr;gap:8px}.dashboard-stat{padding:14px}.dashboard-stat strong{font-size:24px}.dashboard-panel{padding:15px}.dashboard-quick{grid-template-columns:1fr}.dashboard-funnel{grid-template-columns:1fr}.dashboard-funnel-arrow{transform:rotate(90deg);justify-self:center}}
</style>

<style>
/* NLUCK dashboard interaction layer — visual enhancement only */
.dashboard-page{--dash-accent:#9a7655}
.dashboard-page .dashboard-stat,.dashboard-page .dashboard-panel,.dashboard-page .dashboard-article-card,.dashboard-page .dashboard-page-card,.dashboard-page .dashboard-product,.dashboard-page .dashboard-quick a{will-change:transform;transition:transform .22s ease,box-shadow .22s ease,border-color .22s ease,background .22s ease}
.dashboard-page .dashboard-stat{cursor:default;overflow:hidden}
.dashboard-page .dashboard-stat::after{content:"";position:absolute;inset:auto -30px -55px auto;width:120px;height:120px;border-radius:50%;background:radial-gradient(circle,rgba(154,118,85,.12),transparent 68%);pointer-events:none}
.dashboard-page .dashboard-stat:hover{transform:translateY(-5px);box-shadow:0 18px 38px rgba(43,35,27,.09);border-color:#d8cbbd}
.dashboard-page .dashboard-stat .arrow{transition:transform .22s ease}
.dashboard-page .dashboard-stat:hover .arrow{transform:translateX(5px)}
.dashboard-page .dashboard-article-card:hover{transform:translateY(-6px) scale(1.008);box-shadow:0 20px 42px rgba(43,35,27,.11)}
.dashboard-page .dashboard-article-cover img{transition:transform .55s ease,filter .55s ease}
.dashboard-page .dashboard-article-card:hover .dashboard-article-cover img{transform:scale(1.06);filter:saturate(1.05)}
.dashboard-page .dashboard-page-card:hover,.dashboard-page .dashboard-product:hover,.dashboard-page .dashboard-quick a:hover{transform:translateY(-3px);border-color:#d7c8b9;box-shadow:0 10px 24px rgba(43,35,27,.06)}
.dashboard-page .dashboard-product-image img{transition:transform .4s ease}.dashboard-page .dashboard-product:hover .dashboard-product-image img{transform:scale(1.08)}
.dashboard-page .dashboard-funnel-step{transition:transform .25s ease,box-shadow .25s ease,border-color .25s ease}.dashboard-page .dashboard-funnel-step:hover{transform:translateY(-4px);box-shadow:0 12px 25px rgba(43,35,27,.07);border-color:#d7c8b9}
.dashboard-page .dashboard-filter{box-shadow:0 5px 18px rgba(43,35,27,.025);transition:box-shadow .2s ease,border-color .2s ease}.dashboard-page .dashboard-filter:focus-within{border-color:#cbb9a7;box-shadow:0 8px 24px rgba(43,35,27,.07)}
.dashboard-page .dash-live{display:inline-flex;align-items:center;gap:7px;margin-left:8px;padding:5px 9px;border:1px solid #e6ded4;border-radius:999px;background:#fffdfa;color:#75695f;font-size:9px;font-weight:800;letter-spacing:.06em}
.dashboard-page .dash-live i{width:7px;height:7px;border-radius:50%;background:#6e9a73;box-shadow:0 0 0 0 rgba(110,154,115,.45);animation:dashPulse 1.8s infinite}
.dashboard-page .dash-toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:0 0 16px;padding:10px 13px;border:1px solid #e4dcd2;border-radius:14px;background:#fffdfa}
.dashboard-page .dash-search{flex:1;min-width:180px;border:0;outline:0;background:transparent;font-size:11px;color:#4f4740}
.dashboard-page .dash-search::placeholder{color:#aaa198}
.dashboard-page .dash-result{font-size:9px;color:#958c83;white-space:nowrap}
.dashboard-page .dash-reveal{opacity:0;transform:translateY(12px)}
.dashboard-page .dash-reveal.is-visible{opacity:1;transform:none;transition:opacity .5s ease,transform .5s ease}
.dashboard-page .dashboard-chart{position:relative}.dashboard-page .dash-chart-tip{position:absolute;display:none;pointer-events:none;padding:7px 9px;border:1px solid #e4dcd2;border-radius:9px;background:#fffdfa;box-shadow:0 8px 20px rgba(43,35,27,.1);font-size:9px;color:#5c534b;z-index:5}
@keyframes dashPulse{70%{box-shadow:0 0 0 7px rgba(110,154,115,0)}100%{box-shadow:0 0 0 0 rgba(110,154,115,0)}}
@media(max-width:600px){.dashboard-page .dash-toolbar{align-items:flex-start;flex-direction:column}.dashboard-page .dash-search{width:100%}.dashboard-page .dash-result{width:100%}}
@media(prefers-reduced-motion:reduce){.dashboard-page *,.dashboard-page *::before,.dashboard-page *::after{animation-duration:.01ms!important;animation-iteration-count:1!important;scroll-behavior:auto!important;transition-duration:.01ms!important}}
</style>

@endpush

@section('content')
<div class="dashboard-page">
    <section class="dashboard-hero">
        <div>
            <div class="eyebrow">NLUCK BUSINESS OVERVIEW <span class="dash-live"><i></i> LIVE</span></div>
            <h2>Semua yang penting, dalam satu tempat.</h2>
            <p>Kelola artikel, produk, pelanggan, performa, dan seluruh halaman website NLUCK dari dashboard ini. Data demo sudah tersedia supaya tampilan langsung terasa hidup.</p>
        </div>
        <div class="dashboard-actions">
            <a class="primary" href="{{ route('admin.articles.create') }}">＋ Tulis artikel</a>
            <a href="{{ route('admin.products.create') }}">＋ Tambah produk</a>
            <a href="{{ route('catalog') }}" target="_blank">Lihat website ↗</a>
        </div>
    </section>

    <form class="dashboard-filter" method="GET" action="{{ route('admin.dashboard') }}">
        <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" aria-label="Dari tanggal">
        <span>—</span>
        <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" aria-label="Sampai tanggal">
        <button type="submit">Terapkan</button>
    </form>

    <section class="dashboard-stat-grid">
        <div class="dashboard-stat"><span class="label">Artikel</span><strong>{{ number_format($articleStats['total']) }}</strong><small>{{ $articleStats['published'] }} terbit · {{ $articleStats['draft'] }} draft</small><span class="arrow">→</span></div>
        <div class="dashboard-stat"><span class="label">Produk aktif</span><strong>{{ number_format($productStats['active']) }}</strong><small>{{ $productStats['total'] }} produk tersimpan</small><span class="arrow">→</span></div>
        <div class="dashboard-stat"><span class="label">Article views</span><strong>{{ number_format($totalViews) }}</strong><small>pada periode terpilih</small></div>
        <div class="dashboard-stat"><span class="label">Customer leads</span><strong>{{ number_format($totalLeads) }}</strong><small>{{ number_format($conversion, 2) }}% conversion</small></div>
        <div class="dashboard-stat"><span class="label">WhatsApp</span><strong>{{ number_format($whatsapp) }}</strong><small>lead yang lanjut ke grup</small></div>
    </section>

    <div class="dashboard-main-grid">
        <section class="dashboard-panel wide">
            <div class="dashboard-panel-head">
                <div><h3>Performa NLUCK</h3><p>Views dan leads harian dari {{ $from->format('d M Y') }} sampai {{ $to->format('d M Y') }}.</p></div>
                <a href="{{ route('admin.analytics') }}">Analytics lengkap →</a>
            </div>
            <div class="dashboard-chart">
                <svg viewBox="0 0 100 100" preserveAspectRatio="none" aria-label="Grafik views dan leads">
                    <line x1="8" y1="14" x2="92" y2="14" stroke="#eee8e0" stroke-width=".5"/>
                    <line x1="8" y1="40" x2="92" y2="40" stroke="#eee8e0" stroke-width=".5"/>
                    <line x1="8" y1="66" x2="92" y2="66" stroke="#eee8e0" stroke-width=".5"/>
                    <line x1="8" y1="92" x2="92" y2="92" stroke="#eee8e0" stroke-width=".5"/>
                    <polyline fill="none" stroke="#9a7655" stroke-width="1.1" points="{{ implode(' ', $chartPoints) }}"/>
                    <polyline fill="none" stroke="#b9c6ba" stroke-width=".9" points="{{ implode(' ', $chartLeadsPoints) }}"/>
                    @foreach($daily as $index => $day)
                        @php
                            $x = count($daily) <= 1 ? 50 : 8 + ($index * 84 / (count($daily) - 1));
                            $viewY = 92 - (((int) $day['views'] / $maxChart) * 78);
                        @endphp
                        <circle cx="{{ $x }}" cy="{{ $viewY }}" r="1.2" fill="#fff" stroke="#9a7655" stroke-width=".7"/>
                        <text x="{{ $x }}" y="98" text-anchor="middle" font-size="3" fill="#9b938b" transform="rotate(0 {{ $x }} 98)">{{ $day['label'] }}</text>
                    @endforeach
                </svg>
            </div>
            <div class="dashboard-legend"><span><i></i> Views</span><span><b></b> Leads</span><span>Max skala: {{ number_format($maxChart) }}</span></div>
        </section>

        <section class="dashboard-panel">
            <div class="dashboard-panel-head">
                <div><h3>Aktivitas terbaru</h3><p>Perubahan konten dan customer terbaru.</p></div>
                <a href="{{ route('admin.leads.index') }}">Semua leads →</a>
            </div>
            <div class="dashboard-activity">
                @forelse($activities as $activity)
                    <div class="dashboard-activity-row">
                        <span class="dashboard-activity-dot"></span>
                        <div><strong>{{ $activity['title'] }}</strong><small>{{ $activity['meta'] }}</small></div>
                    </div>
                @empty
                    <div class="empty">Belum ada aktivitas.</div>
                @endforelse
            </div>
        </section>
    </div>

    <div class="dash-toolbar" role="search">
        <input class="dash-search" type="search" placeholder="Cari artikel di dashboard..." aria-label="Cari artikel">
        <span class="dash-result" data-dash-result>Menampilkan semua artikel</span>
    </div>

    <section class="dashboard-panel dashboard-wide">
        <div class="dashboard-panel-head">
            <div><h3>Artikel yang sudah dibuat</h3><p>Artikel langsung muncul sebagai katalog di dashboard. Klik kartu untuk membuka NLUCK Studio.</p></div>
            <a href="{{ route('admin.articles.index') }}">Kelola semua artikel →</a>
        </div>
        <div class="dashboard-article-grid">
            @forelse($latestArticles as $article)
                <a class="dashboard-article-card dash-reveal" data-article-card data-search-text="{{ strtolower(($article->title ?: 'Tanpa judul')..($article->excerpt ?: $article->subtitle ?: '')) }}" href="{{ route('admin.articles.studio', $article) }}">
                    <div class="dashboard-article-cover">
                        @if($article->thumbnail_url)
                            <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" loading="lazy">
                        @else
                            <div class="fallback"><img src="{{ asset('studio/assets/nluck-wordmark.png') }}" alt="NLUCK"></div>
                        @endif
                        @if($article->featured)<span class="dashboard-article-badge">★ FEATURED</span>@endif
                    </div>
                    <div class="dashboard-article-body">
                        <small>{{ $article->status === 'published' ? 'Terbit' : 'Draft' }} · {{ $article->updated_at?->format('d M Y') }}</small>
                        <h4>{{ $article->title ?: 'Tanpa judul' }}</h4>
                        <p>{{ $article->excerpt ?: $article->subtitle ?: 'Buka Studio untuk melanjutkan desain artikel.' }}</p>
                        <span class="dashboard-status {{ $article->status === 'published' ? 'published' : 'draft' }}">{{ $article->status === 'published' ? 'TERBIT' : 'DRAFT' }}</span>
                    </div>
                </a>
            @empty
                <div class="empty-card"><strong>Belum ada artikel</strong><span>Buat artikel pertama dan kartu akan muncul di sini.</span><a class="btn primary" href="{{ route('admin.articles.create') }}">Buat artikel</a></div>
            @endforelse
        </div>
    </section>

    <div class="dashboard-lower-grid">
        <section class="dashboard-panel">
            <div class="dashboard-panel-head"><div><h3>Halaman website</h3><p>Beranda, Tentang Kami, Filosofi, Doa, Koleksi, dan Artikel.</p></div></div>
            <div class="dashboard-page-grid">
                @foreach($pages as $page)
                    <div class="dashboard-page-card">
                        <h4>{{ $page['name'] }}</h4>
                        <p>{{ $page['description'] }}</p>
                        <a href="{{ route($page['route']) }}" target="_blank">Buka halaman ↗</a>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="dashboard-panel">
            <div class="dashboard-panel-head"><div><h3>Koleksi produk</h3><p>Produk aktif yang tampil di katalog.</p></div><a href="{{ route('admin.products.index') }}">Kelola →</a></div>
            <div class="dashboard-product-list">
                @forelse($latestProducts as $product)
                    <a class="dashboard-product" href="{{ route('admin.products.edit', $product) }}">
                        <div class="dashboard-product-image">
                            @if($product->image_url)<img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">@endif
                        </div>
                        <div class="dashboard-product-info"><strong>{{ $product->name }}</strong><small>Rp {{ number_format($product->price, 0, ',', '.') }} · stok {{ $product->stock }}</small></div>
                    </a>
                @empty
                    <div class="empty">Belum ada produk.</div>
                @endforelse
            </div>
        </section>
    </div>

    <section class="dashboard-panel" style="margin-bottom:16px">
        <div class="dashboard-panel-head"><div><h3>Funnel pelanggan</h3><p>Dari membaca artikel sampai lanjut ke WhatsApp.</p></div></div>
        <div class="dashboard-funnel">
            <div class="dashboard-funnel-step"><small>VIEWS</small><strong>{{ number_format($totalViews) }}</strong></div>
            <span class="dashboard-funnel-arrow">→</span>
            <div class="dashboard-funnel-step"><small>LEADS</small><strong>{{ number_format($totalLeads) }}</strong></div>
            <span class="dashboard-funnel-arrow">→</span>
            <div class="dashboard-funnel-step"><small>WHATSAPP</small><strong>{{ number_format($whatsapp) }}</strong></div>
        </div>
        <div class="dashboard-meta-line"><span>Conversion <b>{{ number_format($conversion, 2) }}%</b></span><span>{{ $articleStats['featured'] }} artikel featured</span><span>{{ $productStats['low_stock'] }} produk stok rendah</span></div>
    </section>

    <section class="dashboard-panel" style="margin-bottom:12px">
        <div class="dashboard-panel-head"><div><h3>Akses cepat</h3><p>Semua area penting bisa dibuka dari sini.</p></div></div>
        <div class="dashboard-quick">
            <a href="{{ route('admin.articles.create') }}"><strong>＋ Tulis artikel</strong><small>Buat artikel baru lalu lanjutkan ke Studio.</small></a>
            <a href="{{ route('admin.products.create') }}"><strong>＋ Tambah produk</strong><small>Masukkan produk baru ke katalog.</small></a>
            <a href="{{ route('admin.media.index') }}"><strong>Media Library</strong><small>Kelola foto dan aset yang dipakai Studio.</small></a>
            <a href="{{ route('admin.account.edit') }}"><strong>Pengaturan akun</strong><small>Ubah username dan password admin.</small></a>
        </div>
    </section>

    <div class="dashboard-system">
        <span><b>{{ $articleStats['published'] }}</b> artikel terbit</span>
        <span><b>{{ $productStats['active'] }}</b> produk aktif</span>
        <span><b>{{ $articleStats['featured'] }}</b> artikel featured</span>
        <span><b>{{ $productStats['low_stock'] }}</b> stok rendah</span>
        <span>NLUCK Studio aktif</span>
    </div>
</div>

@push('scripts')
<script>
(function(){
  const root=document.querySelector('.dashboard-page'); if(!root) return;
  const cards=[...root.querySelectorAll('[data-article-card]')];
  const search=root.querySelector('.dash-search'); const result=root.querySelector('[data-dash-result]');
  if(search){ search.addEventListener('input',function(){
    const q=this.value.trim().toLowerCase(); let shown=0;
    cards.forEach(card=>{ const ok=!q || (card.dataset.searchText||'').includes(q); card.hidden=!ok; if(ok) shown++; });
    if(result) result.textContent=q ? (shown+' artikel cocok') : 'Menampilkan semua artikel';
  }); }
  const reveal=[...root.querySelectorAll('.dash-reveal')];
  if('IntersectionObserver' in window){ const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('is-visible');io.unobserve(e.target)}}),{threshold:.08}); reveal.forEach((el,i)=>{el.style.transitionDelay=Math.min(i*55,330)+'ms';io.observe(el)}); } else reveal.forEach(el=>el.classList.add('is-visible'));
  // Count-up for dashboard KPI numbers without changing their values.
  root.querySelectorAll('.dashboard-stat strong').forEach(el=>{
    const raw=el.textContent.replace(/[^0-9]/g,''); const target=parseInt(raw||'0',10); if(!Number.isFinite(target)||target===0)return;
    let start=0, t0=null; const duration=700;
    const step=t=>{if(t0===null)t0=t; const p=Math.min((t-t0)/duration,1); const eased=1-Math.pow(1-p,3); el.textContent=Math.round(start+(target-start)*eased).toLocaleString('id-ID'); if(p<1)requestAnimationFrame(step)};
    el.textContent='0'; requestAnimationFrame(step);
  });
  // Add a subtle keyboard shortcut: / focuses dashboard search.
  document.addEventListener('keydown',e=>{if(e.key==='/' && !/input|textarea|select/i.test(document.activeElement.tagName)){e.preventDefault();search?.focus();}});
})();
</script>
@endpush

@endsection
