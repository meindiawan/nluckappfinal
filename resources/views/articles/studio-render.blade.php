<!DOCTYPE html>
<html lang="id" data-theme="infinia">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $article->title }} — NLUCK</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Poppins:wght@300;400;500;600&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('studio/themes.css') }}">
<link rel="stylesheet" href="{{ asset('studio/layouts.css') }}">
<style>
  :root{
    --placeholder-bg: repeating-linear-gradient(45deg, #EFE6D8, #EFE6D8 10px, #E6DACA 10px, #E6DACA 20px);
  }
  *{box-sizing:border-box;}
  html{ -webkit-text-size-adjust:100%; }
  html,body{ overflow-x:hidden; max-width:100%; }
  img,svg{ max-width:100%; }
  body{
    margin:0;
    background:var(--bg);
    color:var(--ink);
    font-family:'Poppins', sans-serif;
    font-size:15px;
    line-height:1.7;
  }
  h1,h2,h3,.serif{ font-family:'Cormorant Garamond', serif; }
  .arabic{ font-family:'Amiri', serif; direction:rtl; }
  .wrap{ max-width:1080px; margin:0 auto; padding:0 32px; }
  .eyebrow{ letter-spacing:.14em; font-size:11px; color:var(--accent); font-weight:600; }

  /* ---------- generic asset placeholder ---------- */
  .asset-slot{
    position:relative;
    background:var(--placeholder-bg);
    border:1.5px dashed #C9B790;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#8A7A5C;
    text-align:center;
    font-size:12px;
    line-height:1.5;
    overflow:hidden;
  }
  .asset-slot img{ width:100%; height:100%; object-fit:cover; display:block; }
  .asset-slot .asset-label{
    position:relative; z-index:1; padding:10px;
    background:rgba(255,255,255,.55); border-radius:6px;
    max-width:90%;
  }
  .asset-slot .asset-label b{ display:block; font-family:'Poppins',sans-serif; font-size:12px; color:#5B4A2E; }
  .asset-slot .asset-label span{ display:block; margin-top:2px; font-size:10.5px; color:#8A7A5C; }
  [contenteditable="true"]{ outline: 1px dashed transparent; }
  [contenteditable="true"]:hover{ outline: 1px dashed #C9B790; }

  /* ---------- header ---------- */
  header{ padding:22px 0; }
  .header-row{ display:flex; align-items:center; justify-content:space-between; }
  .logo{ display:flex; align-items:center; justify-content:center; gap:0; }
  .logo .fixed-wordmark{
    display:block;
    width:132px;
    height:auto;
    max-width:100%;
    object-fit:contain;
    flex:0 0 auto;
  }
  /* Brand lock: the NLUCK wordmark is a fixed asset and is never restyled by themes/layouts. */
  .logo .fixed-wordmark{ filter:none !important; }
  .collection-tag{ font-size:11px; letter-spacing:.14em; color:var(--accent); font-weight:600; }

  /* ---------- hero ---------- */
  .hero{ position:relative; border-radius:4px; overflow:hidden; min-height:340px; height:auto; margin-bottom:36px;}
  .hero .asset-slot{ position:absolute; inset:0; border-radius:4px; }
  .hero-copy{ position:relative; z-index:2; max-width:430px; padding:clamp(22px,5vw,38px) clamp(18px,4vw,34px); background:rgba(255,255,255,.62); backdrop-filter:blur(3px); border-radius:6px; margin:20px; }
  .hero-copy .script{ font-family:'Cormorant Garamond',serif; font-style:italic; font-size:clamp(15px,4vw,19px); color:var(--dark); }
  .hero-copy h1{ font-size:clamp(26px,6vw,34px); font-weight:500; color:var(--dark); margin:6px 0 2px; }
  .hero-copy h1 .heart{ color:var(--accent); font-size:26px; }
  .hero-copy .lede{ font-size:clamp(13px,3.6vw,15px); color:var(--dark); font-weight:400; margin:0 0 14px; }
  .hero-copy p.body{ font-size:13px; color:var(--ink); max-width:340px; margin:0 0 18px; }
  .hero-copy .tagline{ font-family:'Cormorant Garamond',serif; font-style:italic; font-size:15px; color:var(--dark); border-top:1px solid var(--accent); padding-top:10px; display:inline-block; }

  /* ---------- panel ---------- */
  .panel{ background:var(--panel); border:1px solid var(--line); border-radius:6px; padding:34px; margin-bottom:26px; }

  .about-grid{ display:grid; grid-template-columns:220px 1fr 160px; gap:28px; align-items:center; min-width:0; }
  .about-grid > *{ min-width:0; }
  .about-grid .asset-slot{ aspect-ratio:1/1; border-radius:4px; }
  .about-grid h2{ font-size:clamp(20px,4.2vw,26px); color:var(--dark); font-weight:500; margin:2px 0 0; overflow-wrap:break-word; }
  .about-grid .filosofi{ font-family:'Cormorant Garamond',serif; font-style:italic; font-size:16px; color:var(--accent); margin:0 0 12px; }
  .about-grid p{ font-size:13px; margin:0 0 10px; color:var(--ink); overflow-wrap:break-word; }
  .about-grid .deco{ height:170px; }

  /* Dekorasi bunga (SVG kode) — warna ikut var(--accent) tema aktif */
  .deco-floral{ display:flex; align-items:center; justify-content:center; }
  .deco-floral svg{ width:100%; height:100%; color:var(--accent); }
  #nluck-flower, #nluck-leaf{ color:inherit; }
  .doa-deco .deco-floral{ height:100%; }

  /* ---------- doa section ---------- */
  .section-title{ text-align:center; margin:36px 0 22px; display:flex; align-items:center; gap:14px; justify-content:center; }
  .section-title span{ font-size:11px; letter-spacing:.16em; font-weight:600; color:var(--dark); }
  .section-title .dash{ height:1px; width:60px; background:var(--accent); }

  .doa-item{ display:grid; grid-template-columns:150px 1fr 130px; border:1px solid var(--line); border-radius:6px; overflow:hidden; margin-bottom:14px; background:var(--panel); min-width:0; }
  .doa-item > *{ min-width:0; }
  .doa-num-block{ background:var(--dark); color:#F3E7DD; padding:18px 16px; display:flex; flex-direction:column; gap:10px; }
  .doa-num-block .num{ font-family:'Cormorant Garamond',serif; font-size:22px; color:#D7B98A; }
  .doa-num-block .icon-slot{ width:26px; height:26px; border-radius:50%; }
  .doa-num-block .label{ font-size:11px; letter-spacing:.03em; font-weight:600; line-height:1.35; }
  .doa-body{ padding:18px 20px; }
  .doa-body .arabic{ font-size:clamp(17px,4vw,20px); color:var(--dark); margin:0 0 10px; line-height:1.9; overflow-wrap:break-word; }
  .doa-body .translation{ font-size:12.5px; color:var(--ink-soft); font-style:italic; margin:0; }
  .doa-deco{ padding:14px; }
  .doa-deco .asset-slot{ height:100%; border-radius:4px; }

  /* ---------- pesan ---------- */
  .pesan-grid{ display:grid; grid-template-columns:1fr 340px; gap:30px; align-items:center; min-width:0; }
  .pesan-grid > *{ min-width:0; }
  .pesan-grid h2{ font-size:clamp(19px,4vw,24px); color:var(--dark); font-weight:500; margin:0 0 10px; overflow-wrap:break-word; }
  .pesan-grid p{ font-size:13px; margin:0 0 12px; overflow-wrap:break-word; }
  .pesan-photo{ position:relative; height:220px; border-radius:4px; overflow:hidden; }
  .pesan-photo .asset-slot{ position:absolute; inset:0; }
  .note-card{ position:absolute; right:14px; bottom:14px; width:180px; background:#FBF8F3; border-radius:2px; padding:14px 14px; font-family:'Cormorant Garamond',serif; font-style:italic; font-size:11.5px; color:var(--dark); box-shadow:0 6px 18px rgba(0,0,0,.12); z-index:2; }

  /* ---------- society / form ---------- */
  .society-grid{ display:grid; grid-template-columns:260px 1fr 240px; gap:26px; min-width:0; }
  .society-grid > *{ min-width:0; }
  .society-grid h2{ font-size:clamp(18px,3.8vw,22px); color:var(--dark); font-weight:500; margin:0 0 10px; overflow-wrap:break-word; }
  .society-grid p.desc{ font-size:12.5px; color:var(--ink-soft); margin:0 0 16px; }
  .benefit{ display:flex; gap:10px; align-items:center; font-size:12.5px; margin-bottom:10px; }
  .benefit .icon-slot{ width:20px; height:20px; border-radius:50%; flex:none; }
  .field{ margin-bottom:10px; }
  .field label{ display:flex; align-items:center; gap:8px; border:1px solid var(--line); border-radius:4px; padding:10px 12px; font-size:12.5px; color:var(--ink-soft); background:#fff; }
  .field .dot{ width:6px; height:6px; border-radius:50%; background:var(--accent); flex:none; }
  .checkbox-row{ display:flex; gap:8px; align-items:flex-start; font-size:11.5px; color:var(--ink-soft); margin:12px 0 16px; }
  .btn-primary{ display:block; width:100%; text-align:center; background:var(--dark); color:#F3E7DD; padding:13px; border-radius:4px; font-size:12.5px; letter-spacing:.08em; font-weight:600; text-decoration:none; }
  .welcome-card{ position:relative; border:1px solid var(--accent); border-radius:4px; padding:24px 18px; text-align:center; }
  .welcome-card .frame-slot{ position:absolute; inset:6px; border:1px solid rgba(169,129,79,.35); border-radius:2px; pointer-events:none; }
  .welcome-card .eyebrow2{ font-family:'Cormorant Garamond',serif; font-size:13px; color:var(--dark); letter-spacing:.05em; }
  .welcome-card .pct{ font-family:'Cormorant Garamond',serif; font-size:34px; color:var(--dark); margin:10px 0 2px; }
  .welcome-card .pct-label{ font-size:11px; letter-spacing:.1em; color:var(--accent); font-weight:600; }
  .welcome-card .fine{ font-size:11px; color:var(--ink-soft); margin-top:12px; }

  footer{ background:var(--dark); color:#EBD9C8; text-align:center; padding:22px; margin-top:10px; font-size:12px; }
  footer .tagline{ font-family:'Cormorant Garamond',serif; font-style:italic; font-size:12.5px; color:#C9A46A; margin-top:2px; }

  @media (max-width: 860px){
    .about-grid, .pesan-grid, .society-grid{ grid-template-columns:1fr; }
    .doa-item{ grid-template-columns:1fr; }
    .doa-deco, .about-grid .deco{ display:none; }
    .about-grid .asset-slot{ max-width:280px; margin:0 auto; }
    .society-grid{ gap:20px; }
  }
  @media (max-width: 640px){
    .wrap{ padding:0 18px; }
    .header-row{ flex-wrap:wrap; gap:8px; }
    .hero{ min-height:260px; }
    .hero-copy{ max-width:none; margin:14px; }
    .panel{ padding:22px; }
    .pesan-photo{ height:auto; min-height:220px; aspect-ratio:4/3; }
    .note-card{ position:static; width:auto; margin-top:12px; }
    .welcome-card .pct{ font-size:clamp(24px,7vw,34px); }
  }
  @media (max-width: 480px){
    .wrap{ padding:0 14px; }
    .panel{ padding:18px; }
    .doa-num-block{ padding:14px 14px; }
    .welcome-card{ padding:20px 14px; }
    .field label{ font-size:11.5px; padding:9px 10px; }
    .btn-primary{ padding:12px; font-size:12px; }
  }
  @media (max-width: 360px){
    .wrap{ padding:0 12px; }
    .hero-copy{ margin:10px; }
  }

  /* ---------- KANVAS BEBAS (free canvas) ---------- */
  .free-canvas-panel{ padding:clamp(16px,4vw,34px); }
  .free-canvas-panel .section-title{ margin-top:0; }
  .free-canvas{ position:relative; width:100%; max-width:640px; margin:0 auto; border-radius:8px; overflow:hidden; background:#fff; box-shadow:0 10px 30px rgba(0,0,0,.07); }
  .fc-el{ position:absolute; box-sizing:border-box; }
  .fc-el.fc-image{ overflow:hidden; background:var(--placeholder-bg); }
  .fc-el.fc-image img{ width:100%; height:100%; object-fit:cover; display:block; }
  .fc-el.fc-text{ display:flex; padding:4px; overflow:hidden; word-break:break-word; white-space:pre-wrap; line-height:1.3; }
  @media(max-width:480px){ .free-canvas{ max-width:100%; } }

  /* ---------- MODE HALAMAN: Ikuti Template vs Kanvas Kosong ---------- */
  .wrap{ display:flex; flex-direction:column; }
  .wrap > *{ min-width:0; max-width:100%; }
  .wrap > header{ order:1; }
  .wrap > .hero{ order:2; }
  #aboutSection{ order:3; margin-bottom:0; }
  #doaTitle{ order:4; }
  .wrap > .doa-list{ order:5; }
  #pesanSection{ order:6; }
  #freeCanvasPanel{ order:7; }
  #societySection{ order:8; }
  [data-studio-mode="blank"] .hero,
  [data-studio-mode="blank"] #aboutSection,
  [data-studio-mode="blank"] #doaTitle,
  [data-studio-mode="blank"] .doa-list,
  [data-studio-mode="blank"] #pesanSection{ display:none !important; }
  [data-studio-mode="blank"] #freeCanvasPanel{ order:2; }
  [data-studio-mode="blank"] #societySection{ order:3; margin-top:26px; }
  [data-studio-mode="blank"][data-studio-society="false"] #societySection{ display:none !important; }
  [data-studio-mode="blank"] .free-canvas-panel{ padding:0; background:transparent; box-shadow:none; border-radius:0; }
  [data-studio-mode="blank"] .free-canvas-panel .section-title{ display:none; }
  [data-studio-mode="blank"] .free-canvas{ max-width:none; box-shadow:none; border-radius:4px; }
</style>
</head>
<body>

<!-- ============================================================
     DEKORASI BUNGA — dibangun dari kode SVG (bukan file gambar),
     jadi TIDAK PERLU diupload sama sekali. Warnanya otomatis
     ikut tema aktif (pakai var(--accent) / currentColor), dan
     bentuknya bisa diubah langsung di sini kalau perlu.
     ============================================================ -->
<svg style="display:none" aria-hidden="true">
  <defs>
    <g id="nluck-flower">
      <g opacity="0.5" fill="currentColor">
        <ellipse cx="0" cy="-9" rx="4" ry="9"/>
        <ellipse cx="0" cy="-9" rx="4" ry="9" transform="rotate(60)"/>
        <ellipse cx="0" cy="-9" rx="4" ry="9" transform="rotate(120)"/>
        <ellipse cx="0" cy="-9" rx="4" ry="9" transform="rotate(180)"/>
        <ellipse cx="0" cy="-9" rx="4" ry="9" transform="rotate(240)"/>
        <ellipse cx="0" cy="-9" rx="4" ry="9" transform="rotate(300)"/>
      </g>
      <circle r="2.6" opacity="0.85" fill="currentColor"/>
    </g>
    <path id="nluck-leaf" d="M0,0 C8,-14 26,-14 34,0 C26,14 8,14 0,0 Z" fill="none" stroke="currentColor" stroke-width="1" opacity="0.6"/>

    <symbol id="deco-floral-spray" viewBox="0 0 220 320">
      <path d="M120 8 C 98 68, 132 108, 100 168 C 78 208, 106 250, 94 312" fill="none" stroke="currentColor" stroke-width="1.1" opacity="0.55"/>
      <use href="#nluck-leaf" transform="translate(118,58) rotate(-20) scale(0.95)"/>
      <use href="#nluck-leaf" transform="translate(94,96) rotate(205) scale(0.75)"/>
      <use href="#nluck-leaf" transform="translate(112,152) rotate(-35) scale(0.85)"/>
      <use href="#nluck-leaf" transform="translate(84,192) rotate(195) scale(0.65)"/>
      <use href="#nluck-flower" transform="translate(126,36) scale(1.15)"/>
      <use href="#nluck-flower" transform="translate(76,128) scale(0.9)"/>
      <use href="#nluck-flower" transform="translate(98,232) scale(1)"/>
      <use href="#nluck-flower" transform="translate(88,282) scale(0.7)"/>
    </symbol>

    <symbol id="deco-floral-sprig" viewBox="0 0 140 200">
      <path d="M70 8 C 58 48, 82 78, 64 118 C 54 148, 76 172, 68 196" fill="none" stroke="currentColor" stroke-width="1" opacity="0.55"/>
      <use href="#nluck-leaf" transform="translate(68,42) rotate(-15) scale(0.6)"/>
      <use href="#nluck-leaf" transform="translate(56,92) rotate(205) scale(0.5)"/>
      <use href="#nluck-flower" transform="translate(74,22) scale(0.85)"/>
      <use href="#nluck-flower" transform="translate(48,108) scale(0.65)"/>
    </symbol>
  </defs>
</svg>

<!-- ============================================================
     BACKDROP TEMA — 1 artwork besar per tema (opsional), diganti
     lewat data-asset="theme_background_art". Kosongkan/hapus div
     ini kalau tema tidak pakai artwork latar (cukup warna polos).
     ============================================================ -->
<div class="theme-backdrop">
  <div class="asset-slot" data-asset="theme_background_art">
    <span class="asset-label"><b>theme_background_art</b><span>artwork latar tema (opsional), full-bleed, 1920×1080 px</span></span>
  </div>
</div>

<!-- ============================================================
     TOOLBAR PREVIEW TEMA — hanya untuk demo di file ini.
     Di admin panel, ganti jadi dropdown "Pilih Tema" yang set
     atribut data-theme pada <html>.
     ============================================================ -->
<div class="theme-demo-bar" style="top:14px;">
  <span class="demo-bar-label">Tema</span>
  <button onclick="setTheme('infinia', this)" class="active">Infinia</button>
  <button onclick="setTheme('azure-mist', this)">Azure Mist</button>
  <button onclick="setTheme('marble-serenity', this)">Marble Serenity</button>
  <button onclick="setTheme('arctic-serenity', this)">Arctic Serenity</button>
</div>
<div class="theme-demo-bar" style="top:56px;">
  <span class="demo-bar-label">Layout Doa</span>
  <button onclick="setLayout('rows', this)" class="active">Rows</button>
  <button onclick="setLayout('cards', this)">Cards</button>
  <button onclick="setLayout('manuscript', this)">Manuscript</button>
</div>
<script>
function safeAssetUrl(value){
  if(!value) return '';
  try {
    const u=new URL(String(value), window.location.href);
    if(['localhost','127.0.0.1','0.0.0.0'].includes(u.hostname) && u.pathname.startsWith('/storage/')) return u.pathname+u.search+u.hash;
    return u.href;
  } catch(_) { return String(value); }
}
  function setTheme(name, btn){
    document.documentElement.setAttribute('data-theme', name);
    btn.parentElement.querySelectorAll('button').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
  }
  function setLayout(name, btn){
    document.querySelector('.doa-list').setAttribute('data-layout', name);
    btn.parentElement.querySelectorAll('button').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
  }
</script>

<div class="wrap">

  <!-- =================== HEADER =================== -->
  <header>
    <div class="header-row">
      <div class="logo" aria-label="NLUCK Scarves">
        <!-- FIXED NLUCK wordmark — do not replace, recolor, or restyle -->
        <img class="fixed-wordmark" data-asset="logo_mark" src="{{ asset('studio/assets/nluck-wordmark.png') }}" alt="NLUCK Scarves">
      </div>
      <!-- VARIABLE per-article text -->
      <div class="collection-tag" data-field="collection_badge_text" contenteditable="true">LIMITED SIGNATURE COLLECTION</div>
    </div>
  </header>

  <!-- =================== HERO =================== -->
  <section class="hero">
    <!-- VARIABLE per-article image -->
    <div class="asset-slot" data-asset="hero_banner_photo">
      <span class="asset-label"><b>hero_banner_photo</b><span>1600 × 700 px — foto box + syal + sertifikat</span></span>
    </div>
    <div class="hero-copy">
      <div class="script" data-field="hero_greeting" contenteditable="true">Assalamu'alaikum,</div>
      <h1><span data-field="hero_title" contenteditable="true">Terima kasih</span> <span class="heart">♡</span></h1>
      <div class="lede" data-field="hero_subtitle" contenteditable="true">telah memilih NLUCK Scarves.</div>
      <p class="body" data-field="hero_paragraph" contenteditable="true">Anda sekarang menjadi bagian dari Limited Signature Collection yang diproduksi secara eksklusif dan hanya dimiliki oleh sedikit orang.</p>
      <div class="tagline" data-field="brand_tagline" contenteditable="true">Grace Beyond Beauty.</div>
    </div>
  </section>

  <!-- =================== TENTANG ARTIKEL =================== -->
  <section class="panel" id="aboutSection">
    <div class="eyebrow" style="margin-bottom:14px;">✦ TENTANG ARTIKEL ANDA</div>
    <div class="about-grid">
      <!-- VARIABLE per-article image -->
      <div class="asset-slot" data-asset="fabric_texture_photo">
        <span class="asset-label"><b>fabric_texture_photo</b><span>600 × 600 px — close-up motif kain</span></span>
      </div>
      <div>
        <h2 data-field="collection_name" contenteditable="true">Infinia Signature</h2>
        <div class="filosofi" data-field="collection_subtitle" contenteditable="true">Filosofi</div>
        <p data-field="philosophy_paragraph_1" contenteditable="true">"Infinia" melambangkan perjalanan hidup yang terus bertumbuh tanpa batas. Garis-garis yang saling terhubung melambangkan iman, ilmu, dan amal baik yang selalu menyertai setiap langkah seorang muslimah.</p>
        <p data-field="philosophy_paragraph_2" contenteditable="true">Semoga hijab ini menjadi pengingat untuk terus berjalan dalam kebaikan, dengan hati yang teguh dan penuh keberkahan.</p>
      </div>
      <!-- Dekorasi bunga: SVG kode, bukan aset upload — otomatis ikut warna tema -->
      <div class="deco deco-floral" aria-hidden="true"><svg viewBox="0 0 220 320"><use href="#deco-floral-spray"/></svg></div>
    </div>
  </section>

  <!-- =================== DOA SPESIAL =================== -->
  <div class="section-title" id="doaTitle"><div class="dash"></div><span>DOA SPESIAL UNTUKMU</span><div class="dash"></div></div>

  <!-- data-layout mengatur TAMPILAN blok doa di bawah: "rows" | "cards" | "manuscript" -->
  <div class="doa-list" data-layout="rows">

  <!-- Setiap .doa-item bisa diulang / dipilih tim dari daftar doa. Ganti data-doa-id sesuai konten. -->
  <div class="doa-item" data-doa-id="1">
    <div class="doa-num-block">
      <div class="num">01</div>
      <!-- FIXED icon asset (pilih dari set ikon doa) -->
      <div class="asset-slot icon-slot" data-asset="icon_doa_sprout"></div>
      <div class="label" data-field="doa_1_title" contenteditable="true">DOA KETENANGAN DALAM PERJALANAN</div>
    </div>
    <div class="doa-body">
      <p class="arabic" data-field="doa_1_arabic" contenteditable="true">رَبِّ اشْرَحْ لِي صَدْرِي وَيَسِّرْ لِي أَمْرِي وَاحْلُلْ عُقْدَةً مِنْ لِسَانِي يَفْقَهُوا قَوْلِي</p>
      <p class="translation" data-field="doa_1_translation" contenteditable="true">"Ya Tuhanku, lapangkanlah untukku dadaku, mudahkanlah untukku urusanku, dan lepaskanlah kekakuan dari lidahku, supaya mereka mengerti perkataanku." (QS. Thaha: 25–28)</p>
    </div>
    <div class="doa-deco"><div class="deco-floral" aria-hidden="true"><svg viewBox="0 0 140 200"><use href="#deco-floral-sprig"/></svg></div></div>
  </div>

  <div class="doa-item" data-doa-id="2">
    <div class="doa-num-block">
      <div class="num">02</div>
      <div class="asset-slot icon-slot" data-asset="icon_doa_leaf"></div>
      <div class="label" data-field="doa_2_title" contenteditable="true">DOA KELANCARAN URUSAN</div>
    </div>
    <div class="doa-body">
      <p class="arabic" data-field="doa_2_arabic" contenteditable="true">اللَّهُمَّ لَا سَهْلَ إِلَّا مَا جَعَلْتَ سَهْلًا وَأَنْتَ تَجْعَلُ الْحَزْنَ إِذَا شِئْتَ سَهْلًا</p>
      <p class="translation" data-field="doa_2_translation" contenteditable="true">"Ya Allah, tidak ada kemudahan kecuali yang Engkau jadikan mudah, dan Engkaulah yang menjadikan kesedihan (kesulitan), jika Engkau kehendaki pasti menjadi mudah."</p>
    </div>
    <div class="doa-deco"><div class="deco-floral" aria-hidden="true"><svg viewBox="0 0 140 200"><use href="#deco-floral-sprig"/></svg></div></div>
  </div>


  <div class="doa-item" data-doa-id="3">
    <div class="doa-num-block">
      <div class="num">03</div>
      <div class="asset-slot icon-slot" data-asset="icon_doa_sparkle"></div>
      <div class="label" data-field="doa_3_title" contenteditable="true">DOA KEKUATAN DAN KETEGUHAN</div>
    </div>
    <div class="doa-body">
      <p class="arabic" data-field="doa_3_arabic" contenteditable="true">يَا مُقَلِّبَ الْقُلُوبِ ثَبِّتْ قَلْبِي عَلَى دِينِكَ</p>
      <p class="translation" data-field="doa_3_translation" contenteditable="true">"Wahai Dzat yang membolak-balikkan hati, tetapkanlah hatiku pada agama-Mu." (HR. Tirmidzi)</p>
    </div>
    <div class="doa-deco"><div class="deco-floral" aria-hidden="true"><svg viewBox="0 0 140 200"><use href="#deco-floral-sprig"/></svg></div></div>
  </div>

  <div class="doa-item" data-doa-id="4">
    <div class="doa-num-block">
      <div class="num">04</div>
      <div class="asset-slot icon-slot" data-asset="icon_doa_flower"></div>
      <div class="label" data-field="doa_4_title" contenteditable="true">DOA KEBERKAHAN ILMU DAN AMAL</div>
    </div>
    <div class="doa-body">
      <p class="arabic" data-field="doa_4_arabic" contenteditable="true">رَبِّ زِدْنِي عِلْمًا وَارْزُقْنِي فَهْمًا وَاجْعَلْنِي مِنَ الصَّالِحِينَ</p>
      <p class="translation" data-field="doa_4_translation" contenteditable="true">"Ya Tuhanku, tambahkanlah kepadaku ilmu dan berilah aku pemahaman, dan jadikanlah aku termasuk orang-orang yang saleh." (QS. Taha: 114)</p>
    </div>
    <div class="doa-deco"><div class="deco-floral" aria-hidden="true"><svg viewBox="0 0 140 200"><use href="#deco-floral-sprig"/></svg></div></div>
  </div>

  <div class="doa-item" data-doa-id="5">
    <div class="doa-num-block">
      <div class="num">05</div>
      <div class="asset-slot icon-slot" data-asset="icon_doa_moon"></div>
      <div class="label" data-field="doa_5_title" contenteditable="true">DOA PERLINDUNGAN DAN KEBAIKAN</div>
    </div>
    <div class="doa-body">
      <p class="arabic" data-field="doa_5_arabic" contenteditable="true">رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الْآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ</p>
      <p class="translation" data-field="doa_5_translation" contenteditable="true">"Ya Tuhan kami, berikanlah kepada kami kebaikan di dunia dan kebaikan di akhirat dan lindungilah kami dari azab neraka." (QS. Al-Baqarah: 201)</p>
    </div>
    <div class="doa-deco"><div class="deco-floral" aria-hidden="true"><svg viewBox="0 0 140 200"><use href="#deco-floral-sprig"/></svg></div></div>
  </div>

  </div><!-- /.doa-list -->

  <!-- =================== PESAN UNTUKMU =================== -->
  <section class="panel" id="pesanSection" style="margin-top:26px;">
    <div class="pesan-grid">
      <div>
        <h2 data-field="pesan_title" contenteditable="true">Pesan Untukmu</h2>
        <p data-field="pesan_paragraph_1" contenteditable="true">Teruslah melangkah dengan yakin, karena setiap kebaikan yang dilakukan dengan ikhlas akan selalu bernilai di sisi Allah.</p>
        <p data-field="pesan_paragraph_2" contenteditable="true">Semoga hijab ini selalu menjadi teman dalam setiap perjalananmu untuk menjadi pribadi yang lebih baik, berilmu, dan penuh keberkahan.</p>
      </div>
      <div class="pesan-photo">
        <!-- VARIABLE per-article image -->
        <div class="asset-slot" data-asset="pesan_photo">
          <span class="asset-label"><b>pesan_photo</b><span>800 × 600 px — foto vas/lifestyle</span></span>
        </div>
        <div class="note-card" data-field="closing_note_text" contenteditable="true">Terima kasih telah menjadi bagian dari perjalanan NLUCK Scarves. Sampai bertemu di koleksi berikutnya.<br>Grace Beyond Beauty ♡</div>
      </div>
    </div>
  </section>

  <!-- =================== KANVAS BEBAS =================== -->
  <section class="panel free-canvas-panel" id="freeCanvasPanel" style="display:none">
    <div class="section-title"><div class="dash"></div><span>KREASI BEBAS</span><div class="dash"></div></div>
    <div class="free-canvas" id="freeCanvas" data-free-canvas></div>
  </section>

  <!-- =================== NLUCK SOCIETY =================== -->
  <section class="panel" id="societySection">
    <div class="society-grid">
      <div>
        <h2 data-field="society_title" contenteditable="true">Jadilah Bagian dari NLUCK Society</h2>
        <p class="desc" data-field="society_description" contenteditable="true">Isi data di samping untuk menjadi member dan dapatkan berbagai keuntungan eksklusif hanya untuk Anda.</p>

        <!-- FIXED brand benefits list -->
        <div class="benefit"><div class="asset-slot icon-slot" data-asset="icon_benefit_access"></div><span data-field="benefit_1" contenteditable="true">Early Access Limited Collection</span></div>
        <div class="benefit"><div class="asset-slot icon-slot" data-asset="icon_benefit_discount"></div><span data-field="benefit_2" contenteditable="true">Diskon Spesial Member</span></div>
        <div class="benefit"><div class="asset-slot icon-slot" data-asset="icon_benefit_voucher"></div><span data-field="benefit_3" contenteditable="true">Voucher Ulang Tahun</span></div>
        <div class="benefit"><div class="asset-slot icon-slot" data-asset="icon_benefit_point"></div><span data-field="benefit_4" contenteditable="true">Poin Reward</span></div>
        <div class="benefit"><div class="asset-slot icon-slot" data-asset="icon_benefit_gift"></div><span data-field="benefit_5" contenteditable="true">Special Gift & Private Event</span></div>
      </div>

      <div>
        <!-- Form lead pelanggan -->
        <div class="lead-form-heading">
          <div class="eyebrow2">{{ $formSetting->title }}</div>
          @if($formSetting->description)<p class="lead-form-description">{{ $formSetting->description }}</p>@endif
        </div>
        @if($errors->any())<div class="lead-error">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('articles.leads.store', $article->slug) }}" class="nluck-lead-form">
          @csrf
          @if($formSetting->show_name)<div class="field"><label for="lead-name"><span class="dot"></span>Nama Lengkap</label><input id="lead-name" name="name" type="text" value="{{ old('name') }}" @required(true) autocomplete="name"></div>@endif
          @if($formSetting->show_whatsapp)<div class="field"><label for="lead-whatsapp"><span class="dot"></span>No. WhatsApp</label><input id="lead-whatsapp" name="whatsapp" type="tel" value="{{ old('whatsapp') }}" @required(true) autocomplete="tel" placeholder="08xxxxxxxxxx"></div>@endif
          @if($formSetting->show_email)<div class="field"><label for="lead-email"><span class="dot"></span>Email</label><input id="lead-email" name="email" type="email" value="{{ old('email') }}" @required($formSetting->require_email) autocomplete="email"></div>@endif
          @if($formSetting->show_birth_date)<div class="field"><label for="lead-birth"><span class="dot"></span>Tanggal Lahir</label><input id="lead-birth" name="birth_date" type="date" value="{{ old('birth_date') }}" @required($formSetting->require_birth_date)></div>@endif
          @if($formSetting->show_city)<div class="field"><label for="lead-city"><span class="dot"></span>Kota</label><input id="lead-city" name="city" type="text" value="{{ old('city') }}" @required($formSetting->require_city) autocomplete="address-level2"></div>@endif
          @if($formSetting->show_instagram)<div class="field"><label for="lead-instagram"><span class="dot"></span>Instagram</label><input id="lead-instagram" name="instagram" type="text" value="{{ old('instagram') }}" @required($formSetting->require_instagram) placeholder="@username"></div>@endif
          @if($formSetting->require_consent)<div class="checkbox-row"><input id="lead-consent" name="consent" value="1" type="checkbox" required><label for="lead-consent">{{ $formSetting->consent_text }}</label></div>@endif
          <button type="submit" class="btn-primary">{{ $formSetting->cta_text }}</button>
        </form>
      </div>

      <div class="welcome-card">
        <div class="frame-slot"></div>
        <div class="eyebrow2" data-field="welcome_eyebrow" contenteditable="true">Welcome to<br>NLUCK Society</div>
        <p style="font-size:11px;color:var(--ink-soft);margin:8px 0 0;" data-field="welcome_intro" contenteditable="true">Dapatkan diskon spesial untuk pembelian berikutnya.</p>
        <div class="pct" data-field="promo_value" contenteditable="true">10% OFF</div>
        <div class="pct-label" data-field="promo_label" contenteditable="true">UNTUK MEMBER BARU</div>
        <div class="fine" data-field="promo_terms" contenteditable="true">Berlaku untuk semua produk NLUCK Scarves.</div>
      </div>
    </div>
  </section>

</div>

<footer>
  <div>NLUCK SCARVES ♡</div>
  <div class="tagline" data-field="footer_tagline" contenteditable="true">Grace Beyond Beauty</div>
</footer>



<style id="nluck-ultra-interactive">
/* Interactive public article layer — additive only. */
html{scroll-behavior:smooth}
body{overflow-x:hidden}
.article-progress{position:fixed;top:0;left:0;width:100%;height:4px;z-index:10000;background:rgba(0,0,0,.05);pointer-events:none}
.article-progress i{display:block;width:0;height:100%;background:linear-gradient(90deg,var(--accent),#d7b98a,var(--accent));box-shadow:0 0 12px rgba(120,130,91,.35);transition:width .08s linear}
.interactive-reading-bar{position:fixed;right:20px;bottom:22px;z-index:90;display:flex;align-items:center;gap:7px;padding:8px 10px;border:1px solid rgba(0,0,0,.10);border-radius:999px;background:rgba(255,255,255,.78);backdrop-filter:blur(16px);box-shadow:0 14px 36px rgba(0,0,0,.10);font-size:10px;letter-spacing:.06em;opacity:0;transform:translateY(10px);transition:.3s;pointer-events:none}
.interactive-reading-bar.show{opacity:1;transform:none}
.interactive-reading-bar b{font-size:11px;color:var(--accent)}
.article-sticky-actions{position:fixed;left:20px;bottom:22px;z-index:90;display:flex;gap:7px;opacity:0;transform:translateY(10px);transition:.3s;pointer-events:none}
.article-sticky-actions.show{opacity:1;transform:none;pointer-events:auto}
.article-sticky-actions button{width:40px;height:40px;border:1px solid rgba(0,0,0,.10);border-radius:50%;background:rgba(255,255,255,.82);backdrop-filter:blur(12px);cursor:pointer;box-shadow:0 10px 25px rgba(0,0,0,.08);transition:.2s;font-size:15px;color:inherit}
.article-sticky-actions button:hover{transform:translateY(-3px) scale(1.04);box-shadow:0 15px 30px rgba(0,0,0,.12)}
.hero,.panel,.doa-item,.welcome-card,.benefit,.note-card{will-change:transform}
.hero{transition:transform .15s ease-out,box-shadow .3s ease}
.hero:hover{box-shadow:0 24px 70px rgba(40,53,31,.12)}
.doa-item{cursor:pointer;transition:transform .28s ease,box-shadow .28s ease,border-color .28s ease}
.doa-item.is-active{border-color:var(--accent);box-shadow:0 16px 40px rgba(40,53,31,.10);transform:translateY(-3px)}
.doa-item .doa-body{transition:max-height .35s ease,opacity .3s ease}
.ripple{position:absolute;border-radius:50%;transform:scale(0);animation:nluckRipple .55s linear;background:rgba(255,255,255,.35);pointer-events:none}
@keyframes nluckRipple{to{transform:scale(4);opacity:0}}
@media(max-width:700px){.interactive-reading-bar{right:12px;bottom:14px}.article-sticky-actions{left:12px;bottom:14px}.article-sticky-actions button{width:38px;height:38px}.article-progress{height:3px}}
@media(prefers-reduced-motion:reduce){*,*::before,*::after{scroll-behavior:auto!important;animation-duration:.001ms!important;transition-duration:.001ms!important}}
</style>
<style id="lead-form-style">
.nluck-lead-form{display:grid;gap:10px}.nluck-lead-form .field{margin:0}.nluck-lead-form .field label{display:flex;align-items:center;gap:7px;margin-bottom:5px}.nluck-lead-form input{width:100%;box-sizing:border-box;border:1px solid rgba(0,0,0,.16);background:rgba(255,255,255,.72);border-radius:8px;padding:10px 11px;font:inherit;color:inherit;outline:none}.nluck-lead-form input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(0,0,0,.04)}.nluck-lead-form .checkbox-row{display:flex;align-items:flex-start;gap:8px;margin:8px 0}.nluck-lead-form .checkbox-row input{width:auto;margin-top:3px}.nluck-lead-form .checkbox-row label{font-size:11px;line-height:1.45}.nluck-lead-form .btn-primary{width:100%;border:0;cursor:pointer;text-align:center}.lead-error{padding:11px 13px;border:1px solid rgba(160,70,50,.25);background:rgba(250,232,226,.8);border-radius:10px;font-size:12px;margin-bottom:12px}.lead-form-description{font-size:12px;opacity:.75;margin:5px 0 12px}.lead-success{padding:11px 13px;border:1px solid rgba(40,120,60,.25);background:rgba(220,245,225,.7);border-radius:10px;font-size:12px;margin-bottom:12px}.nluck-lead-form input::placeholder{color:inherit;opacity:.45}
.nluck-lead-form .field{transition:transform .2s ease}.nluck-lead-form .field:focus-within{transform:translateY(-1px)}.nluck-lead-form input{transition:border-color .2s,box-shadow .2s,background .2s}.nluck-lead-form input:focus{background:#fff}.nluck-lead-form .btn-primary{position:relative;overflow:hidden;transition:transform .2s,box-shadow .2s,opacity .2s}.nluck-lead-form .btn-primary:hover{transform:translateY(-2px);box-shadow:0 10px 24px rgba(0,0,0,.12)}.nluck-lead-form .btn-primary.is-loading{opacity:.72;cursor:wait}.nluck-lead-form .btn-primary.is-loading:after{content:"";display:inline-block;width:13px;height:13px;margin-left:8px;border:2px solid currentColor;border-right-color:transparent;border-radius:50%;vertical-align:-2px;animation:nluckSpin .7s linear infinite}@keyframes nluckSpin{to{transform:rotate(360deg)}}</style>
<style id="studio-icon-customization">
/* Ikon benefit/doa dapat dikontrol dari NLUCK Studio. Custom asset tetap diprioritaskan. */
[data-studio-benefit-icon="none"] .benefit .icon-slot:not(.has-custom),
[data-studio-doa-icon="none"] .doa-num-block .icon-slot:not(.has-custom){display:none!important}
[data-studio-benefit-icon="circle"] .benefit .icon-slot:not(.has-custom),
[data-studio-doa-icon="circle"] .doa-num-block .icon-slot:not(.has-custom){border-radius:50%;background:rgba(212,190,145,.24);border:1px solid rgba(173,145,91,.38);display:grid;place-items:center;color:var(--accent);font-size:12px}
[data-studio-benefit-icon="check"] .benefit .icon-slot:not(.has-custom),
[data-studio-doa-icon="check"] .doa-num-block .icon-slot:not(.has-custom),
[data-studio-benefit-icon="star"] .benefit .icon-slot:not(.has-custom),
[data-studio-doa-icon="star"] .doa-num-block .icon-slot:not(.has-custom),
[data-studio-benefit-icon="heart"] .benefit .icon-slot:not(.has-custom),
[data-studio-doa-icon="heart"] .doa-num-block .icon-slot:not(.has-custom),
[data-studio-benefit-icon="diamond"] .benefit .icon-slot:not(.has-custom),
[data-studio-doa-icon="diamond"] .doa-num-block .icon-slot:not(.has-custom),
[data-studio-benefit-icon="leaf"] .benefit .icon-slot:not(.has-custom),
[data-studio-doa-icon="leaf"] .doa-num-block .icon-slot:not(.has-custom){display:grid;place-items:center;background:transparent;border:0;border-radius:0;color:var(--accent);font-size:15px;line-height:1}
[data-studio-benefit-icon="check"] .benefit .icon-slot:not(.has-custom)::before, [data-studio-doa-icon="check"] .doa-num-block .icon-slot:not(.has-custom)::before{content:'✓'}
[data-studio-benefit-icon="star"] .benefit .icon-slot:not(.has-custom)::before, [data-studio-doa-icon="star"] .doa-num-block .icon-slot:not(.has-custom)::before{content:'☆'}
[data-studio-benefit-icon="heart"] .benefit .icon-slot:not(.has-custom)::before, [data-studio-doa-icon="heart"] .doa-num-block .icon-slot:not(.has-custom)::before{content:'♡'}
[data-studio-benefit-icon="diamond"] .benefit .icon-slot:not(.has-custom)::before, [data-studio-doa-icon="diamond"] .doa-num-block .icon-slot:not(.has-custom)::before{content:'◇'}
[data-studio-benefit-icon="leaf"] .benefit .icon-slot:not(.has-custom)::before, [data-studio-doa-icon="leaf"] .doa-num-block .icon-slot:not(.has-custom)::before{content:'❧'}
[data-studio-benefit-icon] .benefit .icon-slot.has-custom, [data-studio-doa-icon] .doa-num-block .icon-slot.has-custom{display:block;background:transparent;border:0;border-radius:0}
.benefit .icon-slot img, .doa-num-block .icon-slot img{width:100%;height:100%;object-fit:contain;display:block}
</style>
<style id="studio-dynamic">
body{transition:background .25s,color .25s}
.studio-overlay-off .hero-copy{background:transparent!important}
[data-studio-rounded="false"] .panel,[data-studio-rounded="false"] .doa-item{border-radius:0!important}
[data-studio-shadow="false"] .doa-list[data-layout="cards"] .doa-item{box-shadow:none!important}
[data-studio-floral="false"] .deco-floral{display:none!important}
[data-studio-overlay="false"] .hero-copy{background:transparent!important}
</style>
<script>
window.NLUCK_PUBLIC_DESIGN = @json($design);
(function(){
 const bgs={plain:'#f6f3ed',glow:'radial-gradient(circle at 20% 20%,#e7dfc8,transparent 50%),#f5f2ea',mesh:'linear-gradient(135deg,#f3eee5 25%,transparent 25%),linear-gradient(315deg,#eee7d8 25%,transparent 25%),#f8f5ee',aurora:'radial-gradient(circle at 20% 30%,#dbe9df,transparent 38%),radial-gradient(circle at 80% 20%,#d9e3ee,transparent 40%),#f6f4ef',marble:'linear-gradient(120deg,transparent 38%,#ded7ca 39%,transparent 41%),linear-gradient(35deg,#f8f6f1 25%,#ebe6dc 26%,#f8f6f1 60%)',watercolor:'radial-gradient(circle at 15% 60%,#eadfd7,transparent 35%),radial-gradient(circle at 80% 35%,#e0e9df,transparent 38%),#f7f4ef',silk:'linear-gradient(115deg,#f7f2e8 0%,#e5dccb 46%,#faf8f3 52%,#eee5d5 100%)',linen:'repeating-linear-gradient(0deg,#f1ece3 0,#f1ece3 2px,#eee8de 3px,#f1ece3 5px)',botanical:'radial-gradient(circle at 85% 15%,#dce6d6,transparent 28%),#f5f2ea',arabesque:'repeating-radial-gradient(ellipse at 0 0,#efe8dc 0 5px,#f7f4ee 6px 14px)',sand:'radial-gradient(circle at 65% 45%,#ead7bb,transparent 38%),#f6efe4',moon:'radial-gradient(circle at 75% 20%,#d9dce2,transparent 28%),#eef0ee'};
 function apply(d){
   d=d||{}; if(d.theme)document.documentElement.dataset.theme=d.theme;
   if(d.layout){let el=document.querySelector('.doa-list');if(el)el.dataset.layout=d.layout}
   if(d.background&&bgs[d.background]){document.body.style.backgroundImage=bgs[d.background];document.body.style.backgroundSize='cover';document.body.style.backgroundAttachment='fixed';}
   if(d.accent)document.documentElement.style.setProperty('--accent',d.accent);
   if(d.titleFont){document.querySelectorAll('h1,h2,h3,.serif,.hero-copy .script,.hero-copy .tagline,.about-grid .filosofi,.doa-num-block .num').forEach(x=>x.style.fontFamily="'"+d.titleFont+"', serif")}
   if(d.bodyFont){document.body.style.fontFamily="'"+d.bodyFont+"', sans-serif"}
   if(d.titleSize){document.querySelectorAll('.hero-copy h1').forEach(x=>x.style.fontSize=d.titleSize+'px')}
   if(d.bodySize){document.querySelectorAll('.hero-copy .lede,.hero-copy p.body,.about-grid p,.pesan-grid p,.society-grid p,.field label,.benefit').forEach(x=>x.style.fontSize=d.bodySize+'px')}
   if(d.lineHeight){document.body.style.lineHeight=d.lineHeight}
   if(d.letter!==undefined)document.body.style.letterSpacing=d.letter+'em';
   if(d.align){document.querySelectorAll('.hero-copy,.about-grid,.pesan-grid,.society-grid').forEach(x=>x.style.textAlign=d.align)}
   document.documentElement.dataset.studioRounded=d.rounded===false?'false':'true';document.documentElement.dataset.studioShadow=d.shadow===false?'false':'true';document.documentElement.dataset.studioFloral=d.floral===false?'false':'true';document.documentElement.dataset.studioOverlay=d.overlay===false?'false':'true';document.documentElement.dataset.studioBenefitIcon=d.benefitIconStyle||'circle';document.documentElement.dataset.studioDoaIcon=d.doaIconStyle||'circle';
   document.documentElement.dataset.studioMode=d.mode==='blank'?'blank':'template';document.documentElement.dataset.studioSociety=d.showSociety===false?'false':'true';
   if(d.content){Object.entries(d.content).forEach(([k,v])=>document.querySelectorAll('[data-field="'+CSS.escape(k)+'"]').forEach(el=>el.innerHTML=v))}
   if(Array.isArray(d.assets)){d.assets.forEach(a=>{if(!a||!a.target||!a.url)return;let slots=document.querySelectorAll('[data-asset="'+CSS.escape(a.target)+'"]');if(a.target==='theme_background_art'){document.body.style.backgroundImage='url("'+safeAssetUrl(a.url)+'")';document.body.style.backgroundSize='cover';document.body.style.backgroundAttachment='fixed';}slots.forEach(slot=>{let img=slot.querySelector('img');if(!img){img=document.createElement('img');slot.appendChild(img)}img.src=safeAssetUrl(a.url);slot.classList.add('has-custom');let label=slot.querySelector('.asset-label');if(label)label.style.display='none';slot.style.backgroundImage='none'})})}
   if(d.canvas!==undefined) renderCanvas(d.canvas);
 }
 function collect(){let o={};document.querySelectorAll('[data-field]').forEach(el=>{let k=el.dataset.field;o[k]=el.innerHTML});return o}

 /* ---------- KANVAS BEBAS: render statis (halaman publik = read-only) ---------- */
 function renderCanvas(c){
   const panel=document.getElementById('freeCanvasPanel'), box=document.getElementById('freeCanvas');
   if(!panel||!box) return;
   const state=(c&&typeof c==='object')?c:{};
   const els=Array.isArray(state.elements)?state.elements:[];
   const isBlankMode = document.documentElement.dataset.studioMode==='blank';
   /* Sinkron dengan Studio: Kanvas Bebas hanya tampil di halaman publik saat
      mode Kanvas Kosong dipilih DAN sudah ada elemen di dalamnya. */
   panel.style.display = (isBlankMode && els.length) ? '' : 'none';
   if(!els.length) return;
   box.style.background = state.transparent ? 'transparent' : (state.background || '#fff');
   box.style.aspectRatio = '1080 / ' + (state.heightPx || 700);
   box.innerHTML = '';
   els.slice().sort((a,b)=>(a.z||1)-(b.z||1)).forEach(el=>{
     const node=document.createElement('div');
     node.className='fc-el fc-'+el.type;
     node.style.left=el.x+'%'; node.style.top=el.y+'%'; node.style.width=el.w+'%'; node.style.height=el.h+'%';
     node.style.zIndex=el.z||1; node.style.opacity=(el.opacity!=null?el.opacity:100)/100;
     if(el.type==='image'){
       if(el.src){ const img=document.createElement('img'); img.src=el.src; node.appendChild(img) }
     } else if(el.type==='box' || el.type==='circle'){
       node.style.background=el.bg||'#78825b';
       node.style.borderRadius = el.type==='circle' ? '50%' : (el.radius||0)+'px';
     } else if(el.type==='text'){
       node.textContent=el.text||'';
       node.style.fontFamily="'"+(el.fontFamily||'Poppins')+"', sans-serif";
       node.style.fontSize=(el.fontSize||16)+'px';
       node.style.color=el.color||'#28351f';
       node.style.textAlign=el.align||'left';
       node.style.fontWeight=el.bold?'700':'400';
       node.style.alignItems = el.align==='center' ? 'center' : (el.align==='right' ? 'flex-end' : 'flex-start');
     }
     box.appendChild(node);
   });
 }
 window.addEventListener('message',e=>{if(!e.data)return;if(e.data.type==='NLUCK_DESIGN')apply(e.data.design);if(e.data.type==='NLUCK_FOCUS'){let el=document.querySelector('[contenteditable="true"]');if(el){el.focus();let r=document.createRange();r.selectNodeContents(el);r.collapse(false);let s=getSelection();s.removeAllRanges();s.addRange(r)}}if(e.data.type==='NLUCK_ASSET'&&e.data.asset){let a=e.data.asset, slots=document.querySelectorAll('[data-asset="'+CSS.escape(a.target)+'"]');if(a.target==='theme_background_art'){document.body.style.backgroundImage='url('+a.url+')';document.body.style.backgroundSize='cover';document.body.style.backgroundAttachment='fixed';}
    if(a.target==='logo_mark') return;
    slots.forEach(slot=>{let img=slot.querySelector('img');if(!img){img=document.createElement('img');slot.appendChild(img)}img.src=a.url;slot.classList.add('has-custom');let label=slot.querySelector('.asset-label');if(label)label.style.display='none';slot.style.backgroundImage='none'})}});
 document.addEventListener('input',e=>{if(e.target.matches('[contenteditable="true"]'))parent.postMessage({type:'NLUCK_CONTENT_CHANGED',content:collect()},'*')});
 const _params=new URLSearchParams(location.search);
 const _articleId=_params.get('id');
 const _isStudio=_params.get('studio')==='1';
 const _storageKey=_articleId?('nluckArticle_'+_articleId):'nluckStudio';
 if(window.NLUCK_PUBLIC_DESIGN){
   document.querySelectorAll('.theme-demo-bar').forEach(x=>x.style.display='none');
   apply(window.NLUCK_PUBLIC_DESIGN);
   document.querySelectorAll('[contenteditable="true"]').forEach(el=>el.removeAttribute('contenteditable'));
 } else if(_isStudio||_articleId){
   document.querySelectorAll('.theme-demo-bar').forEach(x=>x.style.display='none');
   let saved;try{saved=JSON.parse(localStorage.getItem(_storageKey)||'{}')}catch(e){}
   if(saved&&Object.keys(saved).length)apply(saved);
   if(!_isStudio)document.querySelectorAll('[contenteditable="true"]').forEach(el=>el.removeAttribute('contenteditable'));
 }
})();
</script>


<script id="nluck-lead-interaction">
(function(){
  const form=document.querySelector('.nluck-lead-form');
  if(!form)return;
  const phone=form.querySelector('input[name="whatsapp"]');
  if(phone){
    phone.addEventListener('input',function(){
      this.value=this.value.replace(/[^\d+().\-\s]/g,'').slice(0,30);
    });
  }
  form.addEventListener('submit',function(){
    const button=form.querySelector('button[type="submit"]');
    if(!button)return;
    button.classList.add('is-loading');
    button.disabled=true;
    const original=button.textContent;
    button.dataset.originalText=original;
    button.textContent='MEMPROSES...';
  });
})();
</script>


<script id="nluck-ultra-interactive-js">
(function(){
  const reduce=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const progress=document.createElement('div'); progress.className='article-progress'; progress.innerHTML='<i></i>'; document.body.appendChild(progress);
  const bar=document.createElement('div'); bar.className='interactive-reading-bar'; bar.innerHTML='<span>TERBACA</span><b>0%</b>'; document.body.appendChild(bar);
  const actions=document.createElement('div'); actions.className='article-sticky-actions';
  actions.innerHTML='<button type="button" data-action="top" aria-label="Ke atas">↑</button><button type="button" data-action="share" aria-label="Bagikan artikel">↗</button>';
  document.body.appendChild(actions);
  const pct=bar.querySelector('b'), line=progress.querySelector('i');
  function update(){
    const max=Math.max(1,document.documentElement.scrollHeight-innerHeight), value=Math.min(100,Math.round(scrollY/max*100));
    line.style.width=value+'%'; pct.textContent=value+'%';
    bar.classList.toggle('show',scrollY>260); actions.classList.toggle('show',scrollY>260);
    const hero=document.querySelector('.hero'); if(hero&&!reduce&&scrollY<700) hero.style.transform='translateY('+(scrollY*.035)+'px)';
  }
  addEventListener('scroll',update,{passive:true}); addEventListener('resize',update); update();
  actions.addEventListener('click',async e=>{
    const btn=e.target.closest('button'); if(!btn)return;
    if(btn.dataset.action==='top') scrollTo({top:0,behavior:'smooth'});
    if(btn.dataset.action==='share'){
      const data={title:document.title,url:location.href};
      try{ if(navigator.share) await navigator.share(data); else if(navigator.clipboard){await navigator.clipboard.writeText(location.href);btn.textContent='✓';setTimeout(()=>btn.textContent='↗',1200)} }catch(_){ }
    }
  });
  // Doa cards become interactive accordions; first card stays open.
  document.querySelectorAll('.doa-item').forEach((item,i)=>{
    item.addEventListener('click',function(e){
      if(e.target.closest('a,input,button'))return;
      this.classList.toggle('is-active');
    });
    if(i===0)item.classList.add('is-active');
  });
  // Button ripple feedback, without changing button behavior.
  document.addEventListener('click',e=>{
    const el=e.target.closest('.btn-primary,.nluck-wa-button,.btn,.wa-cta'); if(!el)return;
    if(getComputedStyle(el).position==='static')el.style.position='relative'; el.style.overflow='hidden';
    const r=document.createElement('span'); r.className='ripple'; const rect=el.getBoundingClientRect(); const size=Math.max(rect.width,rect.height);
    r.style.width=r.style.height=size+'px'; r.style.left=(e.clientX-rect.left-size/2)+'px'; r.style.top=(e.clientY-rect.top-size/2)+'px'; el.appendChild(r); setTimeout(()=>r.remove(),600);
  });
  // Highlight active form field and gently reveal the form when it enters the viewport.
  const form=document.querySelector('.nluck-lead-form');
  if(form&&!reduce&&'IntersectionObserver' in window){
    form.style.opacity='0';form.style.transform='translateY(18px)';
    const io=new IntersectionObserver(es=>es.forEach(x=>{if(x.isIntersecting){form.style.transition='opacity .6s ease,transform .6s ease';form.style.opacity='1';form.style.transform='none';io.disconnect()}}),{threshold:.12});io.observe(form);
  }
})();
</script>

</body>
</html>
