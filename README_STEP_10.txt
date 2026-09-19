STEP 10 — PUBLIC ARTICLE RENDERER FROM NLUCK STUDIO

Tujuan:
/artikel/{slug} sekarang merender template HTML/CSS NLUCK Studio asli dengan design state dari articles.content_json.

Pasang:
- app/Http/Controllers/ArticleController.php
- resources/views/articles/show.blade.php
- resources/views/articles/studio-render.blade.php
- resources/views/articles/index.blade.php
- resources/views/layouts/articles.blade.php
- public/studio/layouts.css
- public/studio/themes.css
- routes/articles-public.php

Pastikan route file dimuat dari routes/web.php dan Article model/migration STEP 4/9 tersedia.

Renderer publik:
- menerapkan theme, layout, background, accent, font, ukuran, alignment, rounded/shadow/floral/overlay
- menerapkan seluruh content
- menerapkan assets dari Media Library
- mematikan contenteditable pada publik
- tidak bergantung pada localStorage untuk artikel publik
