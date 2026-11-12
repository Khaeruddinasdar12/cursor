<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SeedersTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_admin_from_config(): void
    {
        config(['cms.admin.email' => 'redaksi@example.test', 'cms.admin.password' => 'rahasia-uji-12345']);

        $this->seed(DatabaseSeeder::class);

        $admin = User::query()->where('email', 'redaksi@example.test')->firstOrFail();
        $this->assertTrue(Hash::check('rahasia-uji-12345', $admin->password));

    }

    public function test_seeding_twice_is_idempotent(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(1, User::query()->count());
        $this->assertSame(4, Post::query()->count());
        $this->assertSame(6, Document::query()->count());
    }
}
