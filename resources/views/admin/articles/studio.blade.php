@extends('layouts.admin')

@section('title', 'NLUCK Studio')

@section('content')
<style>
    html:has(.nluck-studio-shell), body:has(.nluck-studio-shell) { overflow: hidden; }
    .nluck-studio-shell {
        position: fixed;
        inset: 0;
        z-index: 9999;
        width: 100vw;
        height: 100vh;
        background: #f3f1eb;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        margin: 0;
    }
    .nluck-studio-topbar {
        height: 68px;
        min-height: 68px;
        background: rgba(255,255,255,.97);
        border-bottom: 1px solid #e6e1d8;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 18px;
        box-shadow: 0 4px 20px rgba(30,25,20,.06);
        position: relative;
        z-index: 2;
        gap: 16px;
    }
    .nluck-studio-brand { display:flex; align-items:center; gap:12px; min-width:0; }
    .nluck-studio-back {
        width:38px; height:38px; flex:0 0 38px; display:grid; place-items:center;
        border:1px solid #e2ddd4; border-radius:11px; text-decoration:none;
        color:#292722; font-size:21px; background:#fff;
    }
    .nluck-studio-back:hover { background:#f8f5ef; transform:translateX(-1px); }
    .nluck-studio-eyebrow { font-size:10px; font-weight:800; letter-spacing:.16em; color:#8b8377; }
    .nluck-studio-title { margin-top:2px; font-size:14px; font-weight:700; color:#25221e; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:55vw; }
    .nluck-studio-actions { display:flex; align-items:center; gap:10px; flex-shrink:0; }
    .nluck-studio-status { font-size:12px; color:#766f66; display:flex; align-items:center; gap:7px; white-space:nowrap; }
    .nluck-studio-status .dot { width:7px; height:7px; border-radius:50%; background:#aaa; }
    .nluck-studio-status.ready .dot,.nluck-studio-status.saved .dot { background:#3c8d62; }
    .nluck-studio-status.saving .dot { background:#c9953e; }
    .nluck-studio-status.error .dot { background:#c85a50; }
    .nluck-studio-close { display:inline-flex; align-items:center; height:38px; padding:0 14px; border:1px solid #ded8ce; border-radius:10px; background:#fff; color:#3c3833; text-decoration:none; font-size:12px; font-weight:700; }
    .nluck-studio-frame-wrap { flex:1; min-height:0; width:100%; position:relative; overflow:hidden; }
    .nluck-studio-frame { display:block; width:100%; height:100%; min-height:0; border:0; background:#f3f1eb; }
    @media(max-width:700px) {
        .nluck-studio-topbar { height:58px; min-height:58px; padding:0 10px; }
        .nluck-studio-title { max-width:45vw; font-size:13px; }
        .nluck-studio-status { display:none; }
        .nluck-studio-close { height:34px; padding:0 10px; }
        .nluck-studio-back { width:34px; height:34px; flex-basis:34px; }
    }
</style>

<div class="nluck-studio-shell">
    <header class="nluck-studio-topbar">
        <div class="nluck-studio-brand">
            <a href="{{ route('admin.articles.index', [], false) }}" class="nluck-studio-back" title="Kembali ke Artikel" aria-label="Kembali ke Artikel">←</a>
            <div>
                <div class="nluck-studio-eyebrow">NLUCK STUDIO</div>
                <div class="nluck-studio-title">{{ $article->title ?: 'Artikel Baru' }}</div>
            </div>
        </div>
        <div class="nluck-studio-actions">
            <span id="studio-status" class="nluck-studio-status"><span class="dot"></span> Memuat Studio…</span>
            <a href="{{ route('admin.articles.index', [], false) }}" class="nluck-studio-close">Tutup Studio</a>
        </div>
    </header>

    <main class="nluck-studio-frame-wrap">
        <iframe id="studio" src="{{ asset('studio/admin.html', false) }}?id={{ $article->id }}" title="NLUCK Studio" class="nluck-studio-frame"></iframe>
    </main>
</div>

<script>
(() => {
    const frame = document.getElementById('studio');
    const status = document.getElementById('studio-status');
    const csrf = @json(csrf_token());
    const dataUrl = @json(route('admin.articles.studio.data', $article, false));
    const saveUrl = @json(route('admin.articles.studio.save', $article, false));
    const mediaJsonUrl = @json(route('admin.media.json', [], false));
    const mediaUploadUrl = @json(route('admin.media.store', [], false));
    const previewUrl = @json(route('admin.articles.preview', $article, false));
    let saveTimer = null;

    function setStatus(text, state = '') {
        status.className = 'nluck-studio-status ' + state;
        status.innerHTML = '<span class="dot"></span> ' + text;
    }

    async function loadDesign() {
        try {
            const response = await fetch(dataUrl, { headers: { Accept: 'application/json' } });
            if (!response.ok) throw new Error('Gagal memuat desain');
            const payload = await response.json();
            frame.contentWindow?.postMessage({
                type: 'NLUCK_CONFIG',
                config: {
                    mediaJsonUrl,
                    mediaUploadUrl,
                    csrfToken: csrf,
                    previewUrl,
                }
            }, '*');
            frame.contentWindow?.postMessage({ type: 'NLUCK_LOAD_DESIGN', design: payload.design || {} }, '*');
            setStatus('Siap mengedit', 'ready');
        } catch (error) {
            console.error(error);
            setStatus('Gagal memuat data artikel', 'error');
        }
    }

    async function saveDesign(design, action = 'draft') {
        try {
            setStatus(action === 'publish' ? 'Menerbitkan…' : 'Menyimpan…', 'saving');
            const response = await fetch(saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    Accept: 'application/json'
                },
                body: JSON.stringify({ design, action })
            });
            if (!response.ok) throw new Error('Gagal menyimpan');
            frame.contentWindow?.postMessage({ type: 'NLUCK_SERVER_SAVED', action }, '*');
            setStatus(action === 'publish' ? 'Artikel diterbitkan' : 'Tersimpan', 'saved');
        } catch (error) {
            console.error(error);
            setStatus('Gagal menyimpan', 'error');
        }
    }

    window.addEventListener('message', (event) => {
        if (event.source !== frame.contentWindow || !event.data) return;
        if (event.data.type === 'NLUCK_ARTICLE_SAVE' && event.data.design) {
            clearTimeout(saveTimer);
            saveTimer = setTimeout(() => saveDesign(event.data.design, event.data.action || 'draft'), 300);
        }
        if (event.data.type === 'NLUCK_ARTICLE_PREVIEW') {
            window.open(previewUrl, '_blank', 'noopener');
        }
        if (event.data.type === 'NLUCK_ARTICLE_CLOSE') {
            window.location.href = @json(route('admin.articles.index', [], false));
        }
    });

    frame.addEventListener('load', loadDesign);
    loadDesign();
})();
</script>
@endsection
