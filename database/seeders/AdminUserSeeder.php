<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $username = trim((string) env('ADMIN_USERNAME'));
        $password = (string) env('ADMIN_PASSWORD');

        if ($username === '' || $password === '') {
            throw new RuntimeException('ADMIN_USERNAME dan ADMIN_PASSWORD wajib diisi di .env sebelum menjalankan db:seed.');
        }

        if (strlen($password) < 8) {
            throw new RuntimeException('ADMIN_PASSWORD minimal 8 karakter.');
        }

        User::updateOrCreate(
            ['username' => $username],
            [
                'name' => 'Administrator',
                'email' => env('ADMIN_EMAIL', 'admin@nluck.id'),
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );
    }
}
