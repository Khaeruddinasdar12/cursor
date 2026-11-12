<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat akun admin dari ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD (.env).
     * Jika ADMIN_PASSWORD kosong, kata sandi acak dibuat dan ditampilkan sekali di konsol.
     * Akun yang sudah ada tidak ditimpa.
     */
    public function run(): void
    {
        $email = config('cms.admin.email');

        if (User::query()->where('email', $email)->exists()) {
            $this->command?->info("Admin {$email} sudah ada, dilewati.");

            return;
        }

        $password = config('cms.admin.password');
        $generated = blank($password);

        if ($generated) {
            $password = Str::password(16, symbols: false);
        }

        User::query()->create([
            'name' => config('cms.admin.name'),
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->command?->info("Admin dibuat: {$email}");

        if ($generated) {
            $this->command?->warn("Kata sandi acak (catat sekarang, tidak ditampilkan lagi): {$password}");
        }
    }
}
