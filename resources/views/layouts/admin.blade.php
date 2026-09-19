<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — NLUCK</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#f6f3ed;--card:#fffdfa;--ink:#25211c;--muted:#7b746b;--line:#e8e0d5;--accent:#a37f5d;--dark:#211d18;--shadow:0 18px 50px rgba(43,35,27,.07)}
        *{box-sizing:border-box}html{font-family:"DM Sans",system-ui,sans-serif;color:var(--ink)}body{margin:0;background:var(--bg)}a{color:inherit;text-decoration:none}button,input,select,textarea{font:inherit}
        .shell{min-height:100vh;display:grid;grid-template-columns:258px 1fr}
        .sidebar{background:#201c17;color:#d9d0c4;padding:26px 18px 20px;display:flex;flex-direction:column;min-height:100vh;position:sticky;top:0;height:100vh}
        .brand{display:flex;align-items:center;gap:10px;font:600 29px/1 "Playfair Display",Georgia,serif;color:#fff;padding:4px 14px 34px;letter-spacing:-.02em}.brand span{font-weight:500;color:#d2b898}.brand-mark{height:34px;width:auto;display:block;flex:none}
        .nav{display:grid;gap:4px}.nav a{display:flex;align-items:center;gap:12px;padding:12px 13px;border-radius:12px;font-size:13px;color:#cfc6bb;transition:.18s}
        .nav a .ico{width:20px;text-align:center;opacity:.8}.nav a:hover{background:#fff0f008;color:#fff}.nav a.active{background:#fff;color:#211d18;font-weight:700;box-shadow:0 8px 22px rgba(0,0,0,.12)}
        .sideFoot{margin-top:auto;border-top:1px solid #ffffff16;padding-top:18px}.logout{width:100%;border:1px solid #ffffff1f;background:transparent;color:#eee7dc;border-radius:12px;padding:11px;cursor:pointer}.logout:hover{background:#ffffff0b}
        .main{padding:34px 38px 46px;min-width:0}.top{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:30px}.top h1{font:500 35px/1.05 "Playfair Display",Georgia,serif;margin:0;letter-spacing:-.025em}.top .muted{margin-top:5px;font-size:14px}.userChip{border:1px solid var(--line);background:#fffdf9;border-radius:999px;padding:9px 14px;font-size:13px;white-space:nowrap}.card{background:var(--card);border:1px solid var(--line);border-radius:22px;padding:24px;box-shadow:var(--shadow)}
        .alert{padding:12px 14px;border-radius:12px;margin-bottom:18px;font-size:13px}.alert.ok{background:#eaf3eb;color:#38533c;border:1px solid #cfe1d1}.alert.error{background:#faece8;color:#7a3d31;border:1px solid #edd0c8}
        .field{display:grid;gap:7px;margin-bottom:16px}.field label{font-size:12px;font-weight:700}.field input{width:100%;border:1px solid var(--line);background:#fff;border-radius:12px;padding:12px 13px;outline:none}.field input:focus{border-color:var(--accent);box-shadow:0 0 0 3px #a1876c18}.errorText{font-size:12px;color:#a3543f}.btn{border:0;background:var(--dark);color:#fff;border-radius:999px;padding:11px 17px;cursor:pointer}.btn:hover{opacity:.92}.formCard{max-width:700px}.hint{font-size:12px;color:var(--muted);margin-top:-8px;margin-bottom:18px}
        @media(max-width:980px){.shell{grid-template-columns:82px 1fr}.sidebar{padding:22px 10px}.brand{justify-content:center;padding:5px 0 30px}.brand-text{display:none}.nav a{justify-content:center;padding:12px}.nav a span:not(.ico){display:none}.nav a .ico{font-size:17px}.logout{font-size:0}.logout:after{content:"↪";font-size:18px}.main{padding:28px 24px}}
        @media(max-width:650px){.shell{display:block}.sidebar{position:static;height:auto;min-height:0;padding:12px;display:block}.brand{font-size:24px;padding:7px 10px 14px;text-align:left}.nav{display:flex;overflow:auto}.nav a{white-space:nowrap}.nav a span:not(.ico){display:inline}.nav a .ico{font-size:14px}.sideFoot{display:none}.main{padding:22px 16px}.top{align-items:flex-start;flex-direction:column}}
    </style>
    <link rel="stylesheet" href="{{ asset('admin-assets/admin.css') }}">
    @stack('styles')
</head>
<body>
<div class="shell">
    <button class="admin-mobile-toggle" type="button" aria-label="Buka menu" aria-expanded="false">☰</button>
    <div class="admin-nav-backdrop" hidden></div>
    <aside class="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/logo/nluck-mark.png') }}" alt="NLUCK" class="brand-mark"><span class="brand-text">N<span>LUCK</span></span></a>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}"><span class="ico">▦</span><span>Dashboard</span></a>
            <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles*') ? 'active' : '' }}"><span class="ico">▤</span><span>Artikel</span></a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}"><span class="ico">◇</span><span>Produk</span></a>
            <a href="{{ route('admin.promo-banners.index') }}" class="{{ request()->routeIs('admin.promo-banners*') ? 'active' : '' }}"><span class="ico">▥</span><span>Promo Carousel</span></a>
            <a href="{{ route('admin.media.index') }}" class="{{ request()->routeIs('admin.media*') ? 'active' : '' }}"><span class="ico">▧</span><span>Media Library</span></a>
            <a href="{{ route('admin.leads.index') }}" class="{{ request()->routeIs('admin.leads*') ? 'active' : '' }}"><span class="ico">♙</span><span>Customer Leads</span></a>
            <a href="{{ route('admin.analytics') }}" class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}"><span class="ico">⌁</span><span>Analytics</span></a>
            <a href="{{ route('admin.whatsapp.edit') }}" class="{{ request()->routeIs('admin.whatsapp*') ? 'active' : '' }}"><span class="ico">◉</span><span>WhatsApp & Sosial</span></a>
            <a href="{{ route('admin.form-settings.edit') }}" class="{{ request()->routeIs('admin.form-settings*') ? 'active' : '' }}"><span class="ico">□</span><span>Form Artikel</span></a>
            <a href="{{ route('admin.site-content.edit','filosofi') }}" class="{{ request()->routeIs('admin.site-content.edit') && request()->route('key')==='filosofi' ? 'active' : '' }}"><span class="ico">✦</span><span>Filosofi & Doa</span></a>
            <a href="{{ route('admin.account.edit') }}" class="{{ request()->routeIs('admin.account.*') ? 'active' : '' }}"><span class="ico">⚙</span><span>Pengaturan Akun</span></a>
        </nav>
        <div class="sideFoot">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="logout" type="submit">Keluar</button>
            </form>
        </div>
    </aside>
    <main class="main">
        <div class="top">
            <div>
                <h1>@yield('heading', 'Admin')</h1>
                <div class="muted">Panel pengelolaan website NLUCK</div>
            </div>
            <div class="userChip">● {{ auth()->user()->username }}</div>
        </div>
        @if(session('status'))<div class="alert ok">{{ session('status') }}</div>@endif
        @yield('content')
    </main>
</div>

<style id="nluck-admin-responsive">
.admin-mobile-toggle,.admin-nav-backdrop{display:none}
@media(max-width:650px){
  .admin-mobile-toggle{display:grid;place-items:center;position:fixed;top:12px;right:12px;z-index:1002;width:42px;height:42px;border:1px solid #e1d9cf;border-radius:13px;background:#fffdfa;color:#25211d;box-shadow:0 10px 25px rgba(43,35,27,.10);cursor:pointer}
  .admin-nav-backdrop{position:fixed;inset:0;z-index:1000;background:rgba(32,28,23,.38);backdrop-filter:blur(2px)}
  .admin-nav-backdrop:not([hidden]){display:block}
  .shell{display:block!important}
  .sidebar{position:fixed!important;left:0;top:0;bottom:0;width:min(290px,84vw)!important;height:100vh!important;min-height:100vh!important;z-index:1001;transform:translateX(-105%);transition:transform .28s cubic-bezier(.2,.7,.2,1);box-shadow:18px 0 50px rgba(0,0,0,.18)}
  .sidebar.is-open{transform:translateX(0)}
  .main{padding:72px 14px 30px!important}
  .top{margin-bottom:20px!important;padding-right:52px}
  .top h1{font-size:30px!important}
  .top .userChip{font-size:11px}
  body.admin-menu-open{overflow:hidden}
}
</style>
<script>
(function(){
 const toggle=document.querySelector('.admin-mobile-toggle'),sidebar=document.querySelector('.sidebar'),backdrop=document.querySelector('.admin-nav-backdrop');
 if(!toggle||!sidebar)return;
 function close(){sidebar.classList.remove('is-open');toggle.setAttribute('aria-expanded','false');document.body.classList.remove('admin-menu-open');if(backdrop)backdrop.hidden=true}
 toggle.addEventListener('click',()=>{const open=sidebar.classList.toggle('is-open');toggle.setAttribute('aria-expanded',open?'true':'false');document.body.classList.toggle('admin-menu-open',open);if(backdrop)backdrop.hidden=!open});
 backdrop?.addEventListener('click',close);sidebar.querySelectorAll('a').forEach(a=>a.addEventListener('click',close));
})();
</script>
</body>
</html>
