@extends('layouts.articles')
@section('title', $article->title)
@section('content')
<div class="article-studio-shell">
  <div class="article-studio-toolbar">
    <a href="{{ route('articles.index') }}">← Semua Artikel</a>
    <span>{{ $article->title }}</span>
  </div>
  <div class="article-studio-frame">
    @include('articles.studio-render', ['design' => $design])
  </div>
</div>

<style id="nluck-public-interactions">
.article-studio-shell{padding-bottom:70px}
.article-studio-toolbar{position:sticky;top:70px;z-index:4;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:12px 0;margin-bottom:18px;background:rgba(245,243,238,.88);backdrop-filter:blur(12px);border-bottom:1px solid transparent;transition:.25s}
.article-studio-toolbar.is-scrolled{border-color:var(--line);box-shadow:0 8px 24px rgba(40,53,31,.06)}
.article-studio-toolbar a{font-weight:600;font-size:12px;transition:transform .2s}
.article-studio-toolbar a:hover{transform:translateX(-3px)}
.article-studio-frame{animation:nluckPageIn .55s ease both}
@keyframes nluckPageIn{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
.article-studio-frame .panel,.article-studio-frame .doa-item,.article-studio-frame .asset-slot{transition:transform .25s ease,box-shadow .25s ease}
.article-studio-frame .panel:hover{box-shadow:0 14px 40px rgba(40,53,31,.06)}
.article-studio-frame .doa-item:hover{transform:translateY(-2px)}
.article-studio-frame .asset-slot img{transition:transform .55s cubic-bezier(.2,.7,.2,1)}
.article-studio-frame .asset-slot:hover img{transform:scale(1.025)}
.nluck-scroll-progress{position:fixed;left:0;top:0;height:3px;width:0;background:var(--accent,#78825b);z-index:9999;transition:width .08s linear}
.nluck-backtop{position:fixed;right:20px;bottom:88px;width:42px;height:42px;border:1px solid var(--line);border-radius:50%;background:rgba(255,255,255,.9);backdrop-filter:blur(10px);color:var(--ink);display:grid;place-items:center;cursor:pointer;opacity:0;pointer-events:none;transform:translateY(8px);transition:.25s;box-shadow:0 10px 25px rgba(0,0,0,.08);z-index:50}
.nluck-backtop.show{opacity:1;pointer-events:auto;transform:none}
@media(max-width:800px){.article-studio-toolbar{top:62px;padding:10px 0}.article-studio-toolbar span{max-width:48%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.nluck-backtop{right:14px;bottom:76px}}
</style>
<script>
(function(){
  const progress=document.createElement('div');
  progress.className='nluck-scroll-progress';
  document.body.appendChild(progress);

  const top=document.createElement('button');
  top.className='nluck-backtop';
  top.type='button';
  top.setAttribute('aria-label','Kembali ke atas');
  top.innerHTML='↑';
  document.body.appendChild(top);
  top.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}));

  const toolbar=document.querySelector('.article-studio-toolbar');
  function update(){
    const max=document.documentElement.scrollHeight-window.innerHeight;
    const pct=max>0?(window.scrollY/max)*100:0;
    progress.style.width=Math.min(100,pct)+'%';
    top.classList.toggle('show',window.scrollY>520);
    if(toolbar) toolbar.classList.toggle('is-scrolled',window.scrollY>20);
  }
  window.addEventListener('scroll',update,{passive:true});
  update();

  // Gentle reveal for major sections without changing their existing content.
  const items=document.querySelectorAll('.article-studio-frame .panel,.article-studio-frame .doa-item');
  if('IntersectionObserver' in window){
    items.forEach(el=>{el.style.opacity='0';el.style.transform='translateY(14px)'});
    const io=new IntersectionObserver(entries=>{
      entries.forEach(entry=>{
        if(!entry.isIntersecting)return;
        entry.target.style.transition='opacity .5s ease, transform .5s ease';
        entry.target.style.opacity='1';
        entry.target.style.transform='none';
        io.unobserve(entry.target);
      });
    },{threshold:.08});
    items.forEach(el=>io.observe(el));
  }
})();
</script>

@endsection
