<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview — {{ $article->title }}</title>
    <link rel="stylesheet" href="{{ asset('studio/layouts.css') }}">
    <link rel="stylesheet" href="{{ asset('studio/themes.css') }}">
    <style>
        .preview-bar{position:sticky;top:0;z-index:9999;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:12px 18px;background:#111827;color:#fff;font:600 14px/1.4 system-ui,sans-serif;box-shadow:0 4px 18px rgba(0,0,0,.16)}
        .preview-bar a{color:#fff;text-decoration:none;padding:8px 12px;border-radius:9px;background:#374151}
        .preview-status{opacity:.75;font-weight:500}
    </style>
</head>
<body>
    <div class="preview-bar">
        <div>PREVIEW <span class="preview-status">• {{ $article->status === 'published' ? 'Published' : 'Draft' }}</span></div>
        <a href="{{ route('admin.articles.studio', $article) }}">← Kembali ke Studio</a>
    </div>

    @include('articles.studio-render', ['article' => $article, 'design' => $design, 'formSetting' => $formSetting])
</body>
</html>
