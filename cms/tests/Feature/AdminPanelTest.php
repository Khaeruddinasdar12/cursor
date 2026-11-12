<?php

namespace Tests\Feature;

use App\Filament\Pages\ManageSettings;
use App\Filament\Resources\Announcements\Pages\ManageAnnouncements;
use App\Filament\Resources\Documents\Pages\CreateDocument;
use App\Filament\Resources\Documents\Pages\ListDocuments;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Menus\Pages\EditMenu;
use App\Filament\Resources\Menus\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Menu;
use App\Models\Post;
use App\Models\User;
use App\Support\SiteSettings;
use Database\Seeders\CmsContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CmsContentSeeder::class);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertOk();
    }

    public function test_every_admin_page_renders_for_a_logged_in_user(): void
    {
        $this->actingAs(User::factory()->create());

        foreach (['', '/posts', '/posts/create', '/post-categories', '/events', '/events/create', '/documents', '/documents/create',
            '/announcements', '/stats', '/quick-links', '/pillars', '/service-centers', '/service-centers/create',
            '/service-steps', '/publications', '/publications/create', '/partners', '/office-hours', '/menus', '/social-links',
            '/search-entries', '/users', '/users/create', '/pengaturan-situs', '/profile'] as $path) {
            $this->get('/admin'.$path)->assertOk();
        }

        $this->get('/admin/posts/'.Post::first()->getKey().'/edit')->assertOk();
        $this->get('/admin/menus/'.Menu::first()->getKey().'/edit')->assertOk();
    }

    public function test_admin_can_create_a_post_that_appears_on_the_site(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreatePost::class)
            ->fillForm([
                'title' => 'Pengumuman Uji Coba',
                'slug' => 'pengumuman-uji-coba',
                'excerpt' => 'Ringkasan uji.',
                'content' => '<p>Isi lengkap uji.</p>',
                'published_at' => now()->toDateString(),
                'is_published' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->get('/')->assertSee('Pengumuman Uji Coba');
        $this->get('/pengumuman/pengumuman-uji-coba')->assertOk()->assertSee('Isi lengkap uji.');
    }

    public function test_post_requires_title_and_unique_slug(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreatePost::class)
            ->fillForm(['title' => null, 'slug' => 'pembukaan-pendaftaran-hibah-penelitian-internal-tahun-2027'])
            ->call('create')
            ->assertHasFormErrors(['title' => 'required', 'slug' => 'unique']);
    }

    public function test_tables_list_seeded_records(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ListPosts::class)->assertCanSeeTableRecords(Post::all());
        Livewire::test(ListDocuments::class)->assertCanSeeTableRecords(Document::all());
        Livewire::test(ListEvents::class)->assertSuccessful();
        Livewire::test(ManageAnnouncements::class)->assertCanSeeTableRecords(Announcement::all());
    }

    public function test_admin_can_edit_a_post(): void
    {
        $this->actingAs(User::factory()->create());
        $post = Post::first();

        Livewire::test(EditPost::class, ['record' => $post->getKey()])
            ->fillForm(['title' => 'Judul Diubah'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('Judul Diubah', $post->fresh()->title);
    }

    public function test_document_upload_fills_type_and_size(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateDocument::class)
            ->fillForm([
                'title' => 'Panduan Uji',
                'category' => 'Panduan',
                'file' => UploadedFile::fake()->create('panduan.pdf', 100, 'application/pdf'),
            ])
            ->assertSchemaStateSet(['file_type' => 'PDF'])
            ->call('create')
            ->assertHasNoFormErrors();

        $document = Document::query()->where('title', 'Panduan Uji')->firstOrFail();
        $this->assertNotNull($document->file);
        Storage::disk('public')->assertExists($document->file);
        $this->get('/')->assertSee(Storage::disk('public')->url($document->file), false);
    }

    public function test_settings_page_saves_values(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ManageSettings::class)
            ->assertSchemaStateSet(['contact_phone' => '(0481) 21395'])
            ->fillForm(['contact_phone' => '(0481) 99999', 'hero_title_highlight' => 'Judul Hero Baru'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('(0481) 99999', SiteSettings::get('contact_phone'));
        $this->get('/')->assertSee('(0481) 99999')->assertSee('Judul Hero Baru');
    }

    public function test_menu_items_relation_manager_lists_items(): void
    {
        $this->actingAs(User::factory()->create());
        $menu = Menu::query()->where('slug', 'header')->firstOrFail();

        Livewire::test(ItemsRelationManager::class, ['ownerRecord' => $menu, 'pageClass' => EditMenu::class])
            ->assertSuccessful()
            ->assertSee('Visi dan Misi');
    }
}
