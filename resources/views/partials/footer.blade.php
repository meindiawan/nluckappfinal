@php($wa = $whatsappSetting ?? \App\Models\WhatsAppSetting::current())
<footer class="site-footer">
    <div class="wrap footer-grid">
        <div>
            <div class="logo"><img src="{{ asset('assets/logo/nluck-mark.png') }}" alt="NLUCK"><span>Nluck</span></div>
            <p>Elegan dalam setiap langkah. Koleksi modest wear untuk keseharian yang tenang, hangat, dan personal.</p>
            @if($wa->has_social_links)
                <div class="footer-social">
                    @if($wa->instagram_url)
                        <a href="{{ $wa->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram Nluck">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    @endif
                    @if($wa->tiktok_url)
                        <a href="{{ $wa->tiktok_url }}" target="_blank" rel="noopener" aria-label="TikTok Nluck">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M16.6 5.82a4.278 4.278 0 0 1-3.75-4.05h-3.01v14.24c0 1.55-1.26 2.81-2.81 2.81a2.81 2.81 0 0 1-2.81-2.81 2.81 2.81 0 0 1 2.81-2.81c.26 0 .5.03.74.09v-3.06a5.86 5.86 0 0 0-.74-.05A5.87 5.87 0 0 0 0 15.99a5.87 5.87 0 0 0 5.87 5.87 5.87 5.87 0 0 0 5.87-5.87V9.14a7.267 7.267 0 0 0 4.25 1.36V7.48c-.6 0-1.16-.15-1.66-.42a4.28 4.28 0 0 1-1.73-1.24z"/></svg>
                        </a>
                    @endif
                    @if($wa->facebook_url)
                        <a href="{{ $wa->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook Nluck">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22 12.06C22 6.505 17.523 2 12 2S2 6.505 2 12.06c0 5.02 3.657 9.184 8.438 9.94v-7.03H7.898v-2.91h2.54V9.845c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.242 0-1.63.771-1.63 1.562v1.877h2.773l-.443 2.91h-2.33V22c4.78-.756 8.437-4.92 8.437-9.94z"/></svg>
                        </a>
                    @endif
                </div>
            @endif
        </div>
        <div>
            <h4>Menu</h4>
            <a href="{{ route('catalog') }}">Beranda</a><br>
            <a href="{{ route('catalog.browse') }}">Koleksi</a><br>
            <a href="{{ route('articles.index') }}">Artikel</a>
        </div>
        <div>
            <h4>Cerita</h4>
            <a href="{{ route('pages.about') }}">Tentang Kami</a><br>
            <a href="{{ route('pages.philosophy') }}">Filosofi</a><br>
            <a href="{{ route('pages.doa') }}">Doa</a>
        </div>
        <div>
            <h4>Hubungi Kami</h4>
            <a href="{{ $wa->group_link }}" target="_blank" rel="noopener">Gabung Grup WhatsApp</a><br>
            @if($wa->contact_whatsapp_link)
                <a href="{{ $wa->contact_whatsapp_link }}" target="_blank" rel="noopener">Chat Admin</a><br>
            @endif
            @if($wa->contact_email)
                <a href="mailto:{{ $wa->contact_email }}">{{ $wa->contact_email }}</a>
            @endif
            <div class="footer-contact">Senin–Sabtu · respon cepat lewat WhatsApp</div>
        </div>
    </div>
    <div class="wrap copyright">© {{ date('Y') }} NLUCK. All rights reserved.</div>
</footer>
<a class="wa-float" href="{{ $wa->group_link }}" target="_blank" rel="noopener" aria-label="Gabung Grup WhatsApp NLUCK" title="Gabung Grup WhatsApp NLUCK">☎</a>
