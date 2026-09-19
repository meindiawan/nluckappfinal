<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);
    }

    public function test_guest_cannot_open_admin_dashboard(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_with_username_and_password(): void
    {
        $this->admin();

        $this->post('/admin/login', [
            'username' => 'admin',
            'password' => 'admin',
        ])->assertRedirect('/admin');

        $this->assertAuthenticated();
    }

    public function test_wrong_password_is_rejected(): void
    {
        $this->admin();

        $this->post('/admin/login', [
            'username' => 'admin',
            'password' => 'salah',
        ])->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_admin_can_logout(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post('/admin/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
