<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Cetak QR — {{ $article->title }}</title>
<style>
@page{size:A4;margin:10mm}
*{box-sizing:border-box}
body{margin:0;font-family:system-ui,-apple-system,Segoe UI,sans-serif;color:#222;background:#f4f1ec}
.bar{position:sticky;top:0;z-index:5;display:flex;gap:12px;align-items:center;flex-wrap:wrap;padding:12px 16px;background:#25211d;color:#fff;font-size:13px}
.bar a,.bar button{background:#fff;color:#25211d;border:0;border-radius:8px;padding:8px 12px;font-weight:700;font-size:12px;cursor:pointer;text-decoration:none}
.bar form{display:flex;gap:8px;align-items:center;margin:0}
.bar input{width:70px;padding:6px;border-radius:6px;border:0}
.sheet{display:flex;flex-wrap:wrap;gap:0;padding:12px;justify-content:flex-start}
.cell{width:calc({{ $size }}cm + 8mm);padding:4mm;border:1px dashed #bbb;margin:-0.5px;background:#fff;text-align:center;break-inside:avoid;page-break-inside:avoid}
.cell canvas{width:{{ $size }}cm;height:{{ $size }}cm;display:block;margin:0 auto}
.cell .code{margin-top:2mm;font:700 8pt/1.2 ui-monospace,Consolas,monospace;letter-spacing:.08em}
.cell .brand{font:600 6.5pt/1.2 system-ui,sans-serif;color:#777;margin-top:1mm}
.empty{padding:60px 20px;text-align:center;color:#555}
@media print{body{background:#fff}.bar{display:none}.sheet{padding:0}.cell{border-color:#ccc}}
</style>
</head>
<body>
<div class="bar">
 <strong>{{ $article->title }}</strong>
 <span>{{ $items->count() }} QR · {{ ['unused'=>'belum dipakai','used'=>'sudah dipakai','revoked'=>'dinonaktifkan','all'=>'semua status'][$status] }}@if($batch) · batch #{{ $batch }}@endif</span>
 <form method="GET">
  @if($status)<input type="hidden" name="status" value="{{ $status }}">@endif
  @if($batch)<input type="hidden" name="batch" value="{{ $batch }}">@endif
  <label>Ukuran QR (cm) <input type="number" name="size" step="0.5" min="2" max="8" value="{{ $size }}"></label>
  <button type="submit">Terapkan</button>
 </form>
 <button type="button" onclick="window.print()">🖨 Cetak</button>
 <a href="{{ route('admin.articles.qr',$article) }}">← Kembali</a>
</div>
@if($items->isEmpty())
 <div class="empty">Tidak ada QR untuk dicetak pada filter ini.</div>
@else
<div class="sheet">
 @foreach($items as $it)
  <div class="cell"><canvas data-qr="{{ $it['url'] }}" data-size="900"></canvas><div class="code">{{ $it['code'] }}</div><div class="brand">NLUCK</div></div>
 @endforeach
</div>
@endif
<script src="{{ asset('admin-assets/lib/qrcode-generator.js') }}"></script>
<script src="{{ asset('admin-assets/qr-admin.js') }}"></script>
</body>
</html>
