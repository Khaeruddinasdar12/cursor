<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\Menu;
use App\Models\Post;
use App\Models\PostCategory;
use App\Support\SiteSettings;
use Database\Seeders\CmsContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo('2026-11-12 10:00:00');
        $this->seed(CmsContentSeeder::class);
    }

    public function test_hero_arabic_text_is_shown_only_when_set(): void
    {
        $this->get('/')->assertDontSee('font-arabic', false);

        SiteSettings::save(['hero_arabic' => 'بِسْمِ اللَّهِ']);

        $this->get('/')->assertSee('بِسْمِ اللَّهِ')->assertSee('font-arabic', false);
    }

    public function test_home_page_renders_all_seeded_sections(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('LPPM IAIN Bone — Lembaga Penelitian dan Pengabdian kepada Masyarakat', false)
            ->assertSee('Pengabdian kepada Masyarakat')
            ->assertDontSee('font-arabic', false)
            ->assertSee('Membangun Ekosistem Riset yang Berdaya Guna')
            ->assertSee('Lima Pusat Layanan LPPM')
            ->assertSee('PUSAT 05')
            ->assertSee('Empat Langkah, Selesai')
            ->assertSee('Jurnal Penelitian Keislaman')
            ->assertSee('Panduan Hibah Penelitian 2027')
            ->assertSee('Pembukaan Pendaftaran Hibah Penelitian Internal Tahun 2027')
            ->assertSee('Sosialisasi Panduan Hibah 2027')
            ->assertSee('Senin – Kamis')
            ->assertSee('Berkolaborasi untuk Dampak Lebih Luas')
            ->assertSee('Satu Pintu untuk Semua Layanan LPPM')
            ->assertSee('info@iain-bone.ac.id')
            ->assertSee('Seluruh hak cipta dilindungi.');
    }

    public function test_home_page_renders_navigation_menus(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Visi dan Misi')
            ->assertSee('Penelitian &amp; Publikasi', false)
            ->assertSee('Difabel &amp; Inklusi', false)
            ->assertSee('Pusat Inovasi, Kekayaan Intelektual &amp; Hilirisasi', false)
            ->assertSee('SIAKAD');
    }

    public function test_agenda_only_lists_upcoming_events(): void
    {
        Event::factory()->create(['title' => 'Kegiatan Lampau', 'event_date' => '2026-11-01']);

        $this->get('/')->assertOk()->assertDontSee('Kegiatan Lampau')->assertSee('Workshop Penulisan Artikel Jurnal');
    }

    public function test_inactive_and_unpublished_items_are_hidden(): void
    {
        Announcement::query()->where('text', 'like', 'Pendaftaran KKN Reguler%')->update(['is_active' => false]);
        Document::query()->where('title', 'Formulir Ethical Clearance')->update(['is_active' => false]);
        Post::query()->where('slug', 'pendaftaran-kkn-reguler-telah-dibuka')->update(['is_published' => false]);
        Menu::query()->where('slug', 'footer_legal')->update(['is_active' => false]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Pendaftaran KKN Reguler Angkatan Baru Telah Dibuka')
            ->assertDontSee('Formulir Ethical Clearance')
            ->assertDontSee('Pendaftaran KKN Reguler Telah Dibuka')
            ->assertDontSee('Kebijakan Privasi');
    }

    public function test_site_settings_drive_the_page(): void
    {
        SiteSettings::save(['hero_title_highlight' => 'Judul Baru dari Admin', 'contact_phone' => '(0000) 11111']);

        $this->get('/')->assertSee('Judul Baru dari Admin')->assertSee('(0000) 11111');
    }

    public function test_post_detail_and_listing(): void
    {
        $this->get('/pengumuman')
            ->assertOk()
            ->assertSee('Jadwal Layanan Ethical Clearance Semester Genap');

        $this->get('/pengumuman/pembukaan-pendaftaran-hibah-penelitian-internal-tahun-2027')
            ->assertOk()
            ->assertSee('Pembukaan Pendaftaran Hibah Penelitian Internal Tahun 2027')
            ->assertSee('LPPM membuka pendaftaran hibah penelitian bagi dosen IAIN Bone.')
            ->assertSee('02 Nov 2026');
    }

    public function test_post_listing_can_be_filtered_by_category(): void
    {
        $this->get('/pengumuman?kategori=kkn')
            ->assertOk()
            ->assertSee('Pendaftaran KKN Reguler Telah Dibuka')
            ->assertDontSee('Jadwal Layanan Ethical Clearance Semester Genap');
    }

    public function test_unpublished_or_future_posts_return_404(): void
    {
        $category = PostCategory::factory()->create();
        Post::factory()->draft()->for($category, 'category')->create(['slug' => 'draf']);
        Post::factory()->for($category, 'category')->create(['slug' => 'masa-depan', 'published_at' => '2026-12-31']);

        $this->get('/pengumuman/draf')->assertNotFound();
        $this->get('/pengumuman/masa-depan')->assertNotFound();
        $this->get('/pengumuman/tidak-ada')->assertNotFound();
    }

    public function test_post_content_is_sanitised(): void
    {
        Post::factory()->create(['slug' => 'xss', 'content' => '<p>Aman</p><script>alert(1)</script>']);

        $this->get('/pengumuman/xss')->assertOk()->assertSee('Aman')->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_anchor_links_point_to_home_on_inner_pages(): void
    {
        $this->get('/pengumuman')->assertSee(url('/').'#profil', false);
    }
}
