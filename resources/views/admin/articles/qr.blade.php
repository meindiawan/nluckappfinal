@extends('layouts.admin')
@section('title','QR Artikel — '.$article->title)
@section('heading','QR Sekali Pakai')
@push('styles')
<style>
.qr-page{max-width:1080px}
.qr-top{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap;margin-bottom:18px}
.qr-top small{font-size:10px;letter-spacing:.15em;color:#9a7655;font-weight:800}
.qr-top h2{font:500 28px/1.1 Georgia,serif;margin:6px 0 4px}
.qr-top p{font-size:12px;color:#81786f;line-height:1.6;max-width:640px;margin:0}
.qr-stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-bottom:18px}
.qr-stat{background:#fffdfa;border:1px solid #e4dcd2;border-radius:16px;padding:14px 16px}
.qr-stat b{display:block;font-size:26px;line-height:1.1}
.qr-stat span{font-size:11px;color:#81786f;font-weight:700}
.qr-stat.unused b{color:#28643a}.qr-stat.used b{color:#8a5a1f}.qr-stat.revoked b{color:#8b8279}
.qr-panel{background:#fffdfa;border:1px solid #e4dcd2;border-radius:18px;padding:18px 20px;margin-bottom:18px}
.qr-panel h3{margin:0 0 4px;font-size:14px}
.qr-panel .hint{font-size:11.5px;color:#81786f;line-height:1.6;margin:0 0 12px}
.qr-gen{display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap}
.qr-gen label{font-size:11px;font-weight:800;display:grid;gap:5px}
.qr-gen input[type=number]{width:120px;border:1px solid #e1d9cf;border-radius:10px;padding:10px 12px;background:#fff}
.qr-gen .chk{display:flex;align-items:center;gap:7px;font-weight:600;font-size:12px;padding-bottom:10px;max-width:360px;line-height:1.4}
.qr-actions{display:flex;gap:8px;flex-wrap:wrap}
.qr-btn{display:inline-flex;align-items:center;justify-content:center;border-radius:10px;padding:10px 13px;background:#25211d;color:#fff;font-size:11.5px;font-weight:800;text-decoration:none;border:1px solid #25211d;cursor:pointer}
.qr-btn.alt{background:#fff;border-color:#e1d9cf;color:#403a34}.qr-btn.danger{background:#fff4f1;border-color:#edd2cb;color:#a34535}.qr-btn.sm{padding:6px 9px;font-size:10.5px;border-radius:8px}
.qr-btn:disabled{opacity:.6;cursor:wait}
.qr-filter{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:12px}
.qr-filter select{border:1px solid #e1d9cf;border-radius:10px;padding:9px 11px;background:#fff;font-size:12px}
.qr-table-wrap{background:#fffdfa;border:1px solid #e4dcd2;border-radius:18px;overflow:auto}
.qr-table{width:100%;border-collapse:collapse;font-size:12px;min-width:760px}
.qr-table th{text-align:left;font-size:10px;letter-spacing:.08em;color:#9a7655;padding:11px 14px;border-bottom:1px solid #eee5dc;white-space:nowrap}
.qr-table td{padding:10px 14px;border-bottom:1px solid #f2ebe3;vertical-align:middle}
.qr-table tr:last-child td{border-bottom:0}
.qr-table canvas{width:56px;height:56px;border:1px solid #eee5dc;border-radius:6px;display:block;background:#fff}
.qr-code{font:700 13px/1.2 ui-monospace,Consolas,monospace;letter-spacing:.06em}
.pill{display:inline-block;padding:4px 9px;border-radius:999px;font-size:10.5px;font-weight:800}
.pill.unused{background:#edf8ef;color:#28643a}.pill.used{background:#fdf1de;color:#8a5a1f}.pill.revoked{background:#efebe6;color:#7a7168}
.qr-row-actions{display:flex;gap:6px;flex-wrap:wrap}
.qr-row-actions form{margin:0}
.qr-warn{background:#fff7e6;border:1px solid #f0dcae;color:#7a5410;padding:12px 14px;border-radius:12px;margin-bottom:18px;font-size:12px;line-height:1.6}
.qr-url{padding:8px 11px;background:#f5efe7;border-radius:9px;font-size:10.5px;word-break:break-all;color:#6e645b;margin-top:8px}
.qr-empty{padding:36px 20px;text-align:center;color:#81786f;font-size:13px}
@media(max-width:760px){.qr-stats{grid-template-columns:repeat(2,minmax(0,1fr))}}
</style>
@endpush
@section('content')
<div class="qr-page">
 @if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
 @if(session('error'))<div class="alert error">{{ session('error') }}</div>@endif
 @if($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif

 <div id="qr-local-warning" class="qr-warn" hidden>
  <strong>Perhatian:</strong> QR saat ini berisi alamat lokal (<code>{{ $sampleUrl }}</code>) sehingga tidak bisa dibuka pelanggan.
  Sebelum mencetak, isi <code>QR_BASE_URL=https://domain-anda</code> di file <code>.env</code> (atau buka admin lewat domain produksi), lalu muat ulang halaman ini.
 </div>

 <div class="qr-top">
  <div>
   <small>ARTICLE QR / BARCODE</small>
   <h2>{{ $article->title }}</h2>
   <p>Setiap QR bersifat <strong>unik dan hanya berlaku satu kali</strong>: begitu pelanggan selesai mengisi data dan diarahkan ke grup WhatsApp, QR tersebut hangus dan tidak bisa dipakai lagi. Cetak satu QR untuk satu produk.</p>
   <div class="qr-url">Contoh isi QR: {{ $sampleUrl }}</div>
  </div>
  <div class="qr-actions">
   <a class="qr-btn alt" href="{{ route('admin.articles.index') }}">← Daftar Artikel</a>
   <a class="qr-btn alt" href="{{ route('admin.articles.studio',$article) }}">Studio</a>
  </div>
 </div>

 <div class="qr-stats">
  <div class="qr-stat"><b>{{ $stats['total'] }}</b><span>Total QR dibuat</span></div>
  <div class="qr-stat unused"><b>{{ $stats['unused'] }}</b><span>Belum dipakai</span></div>
  <div class="qr-stat used"><b>{{ $stats['used'] }}</b><span>Sudah dipakai (hangus)</span></div>
  <div class="qr-stat revoked"><b>{{ $stats['revoked'] }}</b><span>Dinonaktifkan</span></div>
 </div>

 <div class="qr-panel">
  <h3>Buat QR baru</h3>
  <p class="hint">Masukkan jumlah sesuai produk yang akan ditempel QR. Untuk <em>rebuild</em>, centang opsi di bawah agar QR lama yang belum terpakai langsung hangus (mis. QR lama hilang/bocor) — QR yang sudah terpakai tidak terpengaruh.</p>
  <form class="qr-gen" method="POST" action="{{ route('admin.articles.qr.generate',$article) }}">
   @csrf
   <label>Jumlah QR<input type="number" name="quantity" min="1" max="500" value="{{ old('quantity',50) }}" required></label>
   <label class="chk"><input type="checkbox" name="revoke_unused" value="1"> Hanguskan QR lama yang belum terpakai (rebuild)</label>
   <button class="qr-btn" type="submit">＋ Buat QR</button>
  </form>
 </div>

 <div class="qr-panel">
  <h3>Cetak & unduh</h3>
  <p class="hint">Berlaku untuk filter yang sedang dipilih di bawah ({{ $codes->total() }} QR). Lembar cetak memuat kode di bawah tiap QR agar produk mudah dilacak.</p>
  <div class="qr-actions">
   <a class="qr-btn" target="_blank" href="{{ route('admin.articles.qr.print', array_filter(['article'=>$article,'status'=>$status==='all'?'unused':$status,'batch'=>$batch])) }}">🖨 Cetak lembar QR</a>
   <button class="qr-btn alt" type="button" id="qr-zip">↓ Download ZIP (PNG)</button>
   @if($stats['unused'] > 0)
   <form method="POST" action="{{ route('admin.articles.qr.revoke-unused',$article) }}" onsubmit="return confirm('Hanguskan semua QR yang belum terpakai pada artikel ini?')">@csrf<button class="qr-btn danger" type="submit">Hanguskan semua yang belum terpakai</button></form>
   @endif
  </div>
 </div>

 <form class="qr-filter" method="GET" action="{{ route('admin.articles.qr',$article) }}">
  <select name="status" aria-label="Status" onchange="this.form.submit()">
   <option value="all" @selected($status==='all')>Semua status</option>
   <option value="unused" @selected($status==='unused')>Belum dipakai</option>
   <option value="used" @selected($status==='used')>Sudah dipakai</option>
   <option value="revoked" @selected($status==='revoked')>Dinonaktifkan</option>
  </select>
  <select name="batch" aria-label="Batch" onchange="this.form.submit()">
   <option value="">Semua batch</option>
   @foreach($batches as $b)<option value="{{ $b }}" @selected($batch===(int)$b)>Batch #{{ $b }}</option>@endforeach
  </select>
  @if($status!=='all'||$batch)<a class="qr-btn alt sm" href="{{ route('admin.articles.qr',$article) }}">Reset</a>@endif
 </form>

 <div class="qr-table-wrap">
  @if($codes->count())
  <table class="qr-table">
   <thead><tr><th>QR</th><th>KODE</th><th>BATCH</th><th>STATUS</th><th>DIPAKAI PADA</th><th>PELANGGAN</th><th>AKSI</th></tr></thead>
   <tbody>
   @foreach($codes as $c)
    <tr>
     <td><canvas data-qr="{{ $c->publicUrl() }}" data-size="120" aria-label="QR {{ $c->code }}"></canvas></td>
     <td><span class="qr-code">{{ $c->code }}</span></td>
     <td>#{{ $c->batch }}</td>
     <td><span class="pill {{ $c->status }}">{{ ['unused'=>'Belum dipakai','used'=>'Terpakai (hangus)','revoked'=>'Dinonaktifkan'][$c->status] }}</span></td>
     <td>{{ $c->used_at ? $c->used_at->timezone(config('app.timezone'))->format('d M Y H:i') : '—' }}</td>
     <td>@if($c->lead){{ $c->lead->name }}<br><small>{{ $c->lead->whatsapp }}</small>@elseif($c->used_at)<small>(data pelanggan dihapus)</small>@else — @endif</td>
     <td>
      <div class="qr-row-actions">
       <button type="button" class="qr-btn alt sm" data-download-png data-url="{{ $c->publicUrl() }}" data-code="{{ $c->code }}" data-prefix="{{ $article->slug }}">PNG</button>
       @if($c->status==='unused')
        <form method="POST" action="{{ route('admin.articles.qr.revoke',[$article,$c]) }}" onsubmit="return confirm('Nonaktifkan QR {{ $c->code }}?')">@csrf<button class="qr-btn danger sm" type="submit">Nonaktifkan</button></form>
       @else
        <form method="POST" action="{{ route('admin.articles.qr.restore',[$article,$c]) }}" onsubmit="return confirm('Aktifkan kembali QR {{ $c->code }}? QR ini bisa dipakai sekali lagi.')">@csrf<button class="qr-btn alt sm" type="submit">Aktifkan ulang</button></form>
       @endif
      </div>
     </td>
    </tr>
   @endforeach
   </tbody>
  </table>
  @else
   <div class="qr-empty">{{ $stats['total'] ? 'Tidak ada QR pada filter ini.' : 'Belum ada QR untuk artikel ini. Buat QR pertama di atas.' }}</div>
  @endif
 </div>
 <div class="pagination">{{ $codes->links() }}</div>
</div>
<script>window.NLUCK_QR = @json(['prefix'=>$article->slug,'sampleUrl'=>$sampleUrl,'items'=>$exportItems]);</script>
<script src="{{ asset('admin-assets/lib/qrcode-generator.js') }}"></script>
<script src="{{ asset('admin-assets/lib/jszip.min.js') }}"></script>
<script src="{{ asset('admin-assets/qr-admin.js') }}"></script>
@endsection
