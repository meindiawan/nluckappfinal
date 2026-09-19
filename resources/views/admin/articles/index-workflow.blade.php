{{-- Copy the action column below into your existing admin/articles/index.blade.php --}}
<div class="article-actions">
    <a href="{{ route('admin.articles.studio', $article) }}">Studio</a>
    <a href="{{ route('admin.articles.preview', $article) }}" target="_blank">Preview</a>

    @if($article->status === 'published')
        <a href="{{ route('articles.show', $article->slug) }}" target="_blank">Lihat Artikel</a>
        <form method="POST" action="{{ route('admin.articles.unpublish', $article) }}" style="display:inline">
            @csrf
            <button type="submit">Jadikan Draft</button>
        </form>
    @else
        <form method="POST" action="{{ route('admin.articles.publish', $article) }}" style="display:inline">
            @csrf
            <button type="submit">Terbitkan</button>
        </form>
    @endif

    <form method="POST" action="{{ route('admin.articles.duplicate', $article) }}" style="display:inline">
        @csrf
        <button type="submit">Duplikat</button>
    </form>
</div>
