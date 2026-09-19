<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin — NLUCK</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <style>
        :root{--bg:#f6f1e9;--ink:#29241e;--muted:#7b7369;--line:#e2d9cc;--accent:#a1876c;--dark:#211d17;--danger:#a3543f}
        *{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:22px;background:radial-gradient(circle at 20% 10%,#fff 0 8%,transparent 30%),linear-gradient(135deg,#ede3d5,#fbfaf7 58%);font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;color:var(--ink)}button,input{font:inherit}
        .box{width:min(440px,100%);background:#fffdf9;border:1px solid var(--line);border-radius:28px;padding:34px;box-shadow:0 25px 70px #3d30231a}.brand{display:block;margin:0 auto 22px}.brand img{display:block;height:64px;width:auto;margin:0 auto}h1{font:500 31px Georgia,serif;margin:0 0 8px}.sub{color:var(--muted);font-size:13px;line-height:1.6;margin-bottom:24px}.field{display:grid;gap:7px;margin-bottom:15px}.field label{font-size:12px;font-weight:700}.field input{border:1px solid var(--line);background:#fff;border-radius:13px;padding:13px 14px;outline:none}.field input:focus{border-color:var(--accent);box-shadow:0 0 0 3px #a1876c18}.remember{display:flex;align-items:center;gap:8px;font-size:12px;color:var(--muted);margin:3px 0 20px}.btn{width:100%;border:0;border-radius:999px;padding:13px 16px;background:var(--dark);color:white;cursor:pointer}.btn:hover{opacity:.93}.error{color:var(--danger);font-size:12px;margin-top:4px}.alert{padding:11px 13px;border-radius:11px;margin-bottom:16px;background:#eaf3eb;color:#38533c;border:1px solid #cfe1d1;font-size:12px}.foot{text-align:center;color:var(--muted);font-size:11px;margin-top:18px}
    </style>
</head>
<body>
<div class="box">
    <a class="brand" href="{{ route('catalog') }}"><img src="{{ asset('assets/logo/nluck-logo.png') }}" alt="NLUCK Scarves"></a>
    <h1>Admin Login</h1>
    <div class="sub">Masuk untuk mengelola produk, artikel, konten, dan pengaturan website.</div>

    @if(session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.store') }}">
        @csrf

        <div class="field">
            <label for="username">Username</label>
            <input id="username" name="username" value="{{ old('username') }}" autocomplete="username" autofocus required>
            @error('username')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" autocomplete="current-password" required>
            @error('password')<div class="error">{{ $message }}</div>@enderror
        </div>

        <label class="remember">
            <input type="checkbox" name="remember" value="1">
            Tetap masuk di perangkat ini
        </label>

        <button class="btn" type="submit">Masuk ke Admin</button>
    </form>

    <div class="foot">Akses khusus administrator NLUCK</div>
</div>
</body>
</html>
