@extends('layouts.articles')

@section('title', 'Terima kasih — ' . $article->title)

@section('content')
<div class="nluck-success-page">
  <div class="nluck-success-card">
    <div class="nluck-success-mark">✓</div>
    <div class="nluck-success-eyebrow">DATA BERHASIL DITERIMA</div>
    <h1>Terima kasih, {{ $lead->name }}.</h1>
    <p class="nluck-success-lead">
      Data kamu sudah tersimpan. Selanjutnya, bergabung ke WhatsApp Group untuk mendapatkan informasi dan benefit eksklusif NLUCK Society.
    </p>

    @if($setting->group_link)
      <a id="nluck-wa-button"
         class="nluck-wa-button"
         href="{{ route('articles.whatsapp.click', [$article->slug, $lead]) }}">
        LANJUT KE WHATSAPP GROUP
      </a>
      <p class="nluck-success-note">Kamu akan diarahkan otomatis dalam <strong id="nluck-countdown">3</strong> detik.</p>
    @else
      <div class="nluck-success-warning">
        Data sudah tersimpan. Link WhatsApp Group belum diatur oleh admin.
      </div>
      <a class="nluck-back-button" href="{{ route('articles.show', $article->slug) }}">KEMBALI KE ARTIKEL</a>
    @endif
  </div>
</div>

@if($setting->group_link)
<script>
(function () {
  const button = document.getElementById('nluck-wa-button');
  const countdown = document.getElementById('nluck-countdown');
  if (!button || !countdown) return;

  let seconds = 3;
  const timer = setInterval(function () {
    seconds -= 1;
    countdown.textContent = seconds;
    if (seconds <= 0) {
      clearInterval(timer);
      window.location.href = button.href;
    }
  }, 1000);
})();
</script>
@endif

<style>
.nluck-success-page{min-height:70vh;display:grid;place-items:center;padding:56px 20px;box-sizing:border-box}
.nluck-success-card{width:min(620px,100%);text-align:center;padding:48px 34px;border:1px solid rgba(0,0,0,.10);border-radius:24px;background:rgba(255,255,255,.82);box-shadow:0 20px 60px rgba(0,0,0,.08);backdrop-filter:blur(12px)}
.nluck-success-mark{width:64px;height:64px;margin:0 auto 20px;border-radius:50%;display:grid;place-items:center;font-size:30px;background:var(--accent,#87976f);color:#fff}
.nluck-success-eyebrow{font-size:11px;letter-spacing:.18em;font-weight:700;opacity:.62}
.nluck-success-card h1{margin:12px 0 10px;font-size:clamp(28px,5vw,46px);line-height:1.08}
.nluck-success-lead{max-width:500px;margin:0 auto 26px;line-height:1.7;opacity:.75}
.nluck-wa-button,.nluck-back-button{display:inline-flex;align-items:center;justify-content:center;min-height:50px;padding:0 24px;border-radius:999px;text-decoration:none;font-weight:700;letter-spacing:.04em;transition:transform .2s ease,box-shadow .2s ease}
.nluck-wa-button{background:#202a21;color:#fff;box-shadow:0 10px 24px rgba(0,0,0,.14)}
.nluck-back-button{border:1px solid rgba(0,0,0,.15);color:inherit}
.nluck-wa-button:hover,.nluck-back-button:hover{transform:translateY(-2px)}
.nluck-success-note{font-size:12px;opacity:.58;margin-top:14px}.nluck-success-warning{padding:14px;border-radius:12px;background:#fff4df;color:#765b24;font-size:13px}.nluck-back-button{margin-top:18px}
@media(max-width:560px){.nluck-success-card{padding:36px 20px;border-radius:18px}.nluck-success-page{padding:32px 14px}}
</style>
@endsection
