<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCode;
use App\Models\ArticleFormSetting;
use App\Models\ArticleLead;
use App\Models\User;
use App\Models\WhatsAppSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleQrOneTimeTest extends TestCase
{
    use RefreshDatabase;

    private const GROUP = 'https://chat.whatsapp.com/TESTGROUP';

    private function article(string $slug = 'infinia-signature'): Article
    {
        return Article::create(['title' => 'Infinia Signature', 'slug' => $slug, 'status' => 'published', 'published_at' => now()->subDay()]);
    }

    private function code(Article $a, array $attrs = []): ArticleCode
    {
        return ArticleCode::create(array_merge(['article_id' => $a->id, 'code' => ArticleCode::generateCode(), 'batch' => 1], $attrs));
    }

    private function form(array $extra = []): array
    {
        return array_merge(['name' => 'Siti', 'whatsapp' => '081234567890', 'city' => 'Kudus', 'consent' => '1'], $extra);
    }

    protected function setUp(): void
    {
        parent::setUp();
        ArticleFormSetting::current();   // pastikan baris pengaturan form sudah ada (default DB terbaca)
        WhatsAppSetting::current()->update(['group_link' => self::GROUP]);
        config(['nluck.require_code' => true]);
    }

    public function test_first_use_succeeds_and_burns_code(): void
    {
        $a = $this->article();
        $c = $this->code($a);

        $this->get("/artikel/{$a->slug}?k={$c->code}")->assertOk()->assertSee('name="k"', false)->assertSee($c->code);

        $this->post("/artikel/{$a->slug}/daftar", $this->form(['k' => $c->code]))->assertRedirect(self::GROUP);

        $c->refresh();
        $this->assertSame('used', $c->status);
        $this->assertNotNull($c->lead_id);
        $this->assertSame(1, ArticleLead::count());
    }

    public function test_second_use_is_rejected_and_creates_no_lead(): void
    {
        $a = $this->article();
        $c = $this->code($a);
        $this->post("/artikel/{$a->slug}/daftar", $this->form(['k' => $c->code]))->assertRedirect(self::GROUP);

        // browser/orang lain (sesi baru)
        $this->flushSession();
        $this->get("/artikel/{$a->slug}?k={$c->code}")->assertOk()->assertSee('QR ini sudah digunakan')->assertDontSee('id="lead-whatsapp"', false);
        $resp = $this->post("/artikel/{$a->slug}/daftar", $this->form(['k' => $c->code, 'name' => 'Orang Lain']));
        $resp->assertRedirect();
        $this->assertStringContainsString('/artikel/'.$a->slug, $resp->headers->get('Location'));
        $this->assertNotSame(self::GROUP, $resp->headers->get('Location'));
        $this->assertSame(1, ArticleLead::count());
    }

    public function test_same_browser_revisit_goes_to_success_page(): void
    {
        $a = $this->article();
        $c = $this->code($a);
        $this->post("/artikel/{$a->slug}/daftar", $this->form(['k' => $c->code]));
        $this->get("/artikel/{$a->slug}?k={$c->code}")->assertRedirect("/artikel/{$a->slug}/berhasil");
    }

    public function test_no_code_or_invalid_or_wrong_article_code_rejected(): void
    {
        $a = $this->article();
        $b = $this->article('azure-mist');
        $codeOfB = $this->code($b);

        $this->get("/artikel/{$a->slug}")->assertOk()->assertSee('scan QR', false)->assertDontSee('id="lead-whatsapp"', false);
        $this->post("/artikel/{$a->slug}/daftar", $this->form())->assertRedirect();
        $this->post("/artikel/{$a->slug}/daftar", $this->form(['k' => 'NGAWUR123456']))->assertRedirect();
        $this->post("/artikel/{$a->slug}/daftar", $this->form(['k' => $codeOfB->code]))->assertRedirect(); // kode artikel lain
        $this->assertSame(0, ArticleLead::count());
        $this->assertSame('unused', $codeOfB->fresh()->status);
    }

    public function test_validation_error_does_not_burn_code(): void
    {
        $a = $this->article();
        $c = $this->code($a);
        $this->post("/artikel/{$a->slug}/daftar", ['k' => $c->code, 'name' => '', 'whatsapp' => '', 'city' => ''])->assertSessionHasErrors();
        $this->assertSame('unused', $c->fresh()->status);
        $this->assertSame(0, ArticleLead::count());
    }

    public function test_missing_group_link_does_not_burn_code(): void
    {
        $a = $this->article();
        $c = $this->code($a);
        WhatsAppSetting::current()->update(['group_link' => '']);
        $this->post("/artikel/{$a->slug}/daftar", $this->form(['k' => $c->code]))->assertSessionHasErrors('group');
        $this->assertSame('unused', $c->fresh()->status);
        $this->assertSame(0, ArticleLead::count());
    }

    public function test_revoked_code_is_rejected(): void
    {
        $a = $this->article();
        $c = $this->code($a, ['revoked_at' => now()]);
        $this->get("/artikel/{$a->slug}?k={$c->code}")->assertSee('tidak berlaku');
        $this->post("/artikel/{$a->slug}/daftar", $this->form(['k' => $c->code]));
        $this->assertSame(0, ArticleLead::count());
    }

    public function test_code_is_case_insensitive_but_atomic_claim_is_single_winner(): void
    {
        $a = $this->article();
        $c = $this->code($a, ['code' => 'ABCDEFGHJKMN']);
        // Simulasi dua request bersamaan: klaim kedua (UPDATE ... WHERE used_at IS NULL) harus gagal.
        $first = ArticleCode::whereKey($c->id)->unused()->update(['used_at' => now()]);
        $second = ArticleCode::whereKey($c->id)->unused()->update(['used_at' => now()]);
        $this->assertSame([1, 0], [$first, $second]);
        $this->assertSame('ABCDEFGHJKMN', ArticleCode::normalize(' abcdefghjkmn '));
    }

    public function test_toggle_off_keeps_old_open_behaviour(): void
    {
        config(['nluck.require_code' => false]);
        $a = $this->article();
        $this->get("/artikel/{$a->slug}")->assertOk()->assertSee('id="lead-whatsapp"', false);
        $this->post("/artikel/{$a->slug}/daftar", $this->form())->assertRedirect(self::GROUP);
        $this->assertSame(1, ArticleLead::count());
    }

    public function test_admin_generate_rebuild_status_print_and_restore(): void
    {
        $a = $this->article();
        $admin = User::create(['name' => 'Adm', 'username' => 'adm', 'email' => 'a@b.c', 'password' => bcrypt('password123')]);
        $this->actingAs($admin);

        $this->post("/admin/articles/{$a->slug}/qr/generate", ['quantity' => 5])->assertRedirect();
        $this->assertSame(5, ArticleCode::where('article_id', $a->id)->count());
        $this->assertSame(1, (int) ArticleCode::max('batch'));

        // 1 dipakai
        $used = ArticleCode::first();
        $this->post("/artikel/{$a->slug}/daftar", $this->form(['k' => $used->code]))->assertRedirect(self::GROUP);

        $this->get("/admin/articles/{$a->slug}/qr")->assertOk()->assertSee('Terpakai (hangus)')->assertSee('Siti');

        // rebuild: 3 baru, 4 lama yang belum terpakai hangus, yang terpakai tetap used
        $this->post("/admin/articles/{$a->slug}/qr/generate", ['quantity' => 3, 'revoke_unused' => 1])->assertRedirect();
        $this->assertSame(8, ArticleCode::count());
        $this->assertSame(3, ArticleCode::unused()->count());
        $this->assertSame(4, ArticleCode::whereNull('used_at')->whereNotNull('revoked_at')->count());
        $this->assertSame('used', $used->fresh()->status);

        $this->get("/admin/articles/{$a->slug}/qr/print?status=unused")->assertOk()->assertSee(ArticleCode::unused()->first()->code);
        $this->get("/admin/articles/{$a->slug}/qr?status=used&batch=1")->assertOk();

        // aktifkan ulang kode terpakai
        $this->post("/admin/articles/{$a->slug}/qr/{$used->id}/restore")->assertRedirect();
        $this->assertSame('unused', $used->fresh()->status);

        // admin index & preview tetap jalan
        $this->get('/admin/articles')->assertOk();
        $this->get("/admin/articles/{$a->slug}/preview")->assertOk();

        // kode artikel lain tidak bisa dimanipulasi lewat artikel ini
        $b = $this->article('other');
        $other = $this->code($b);
        $this->post("/admin/articles/{$a->slug}/qr/{$other->id}/revoke")->assertNotFound();

        // QR admin butuh login
        auth()->logout();
        $this->get("/admin/articles/{$a->slug}/qr")->assertRedirect();
    }

    public function test_simple_qr_mode_when_one_time_disabled(): void
    {
        config(['nluck.require_code' => false]);
        $a = $this->article();
        $admin = User::create(['name' => 'Adm', 'username' => 'adm', 'email' => 'a@b.c', 'password' => bcrypt('password123')]);
        $this->actingAs($admin);
        $this->get("/admin/articles/{$a->slug}/qr")->assertOk()->assertSee('/artikel/'.$a->slug, false)->assertDontSee('Buat QR baru');
        $this->get('/admin/articles')->assertOk()->assertDontSee('QR · ', false);
    }
}
