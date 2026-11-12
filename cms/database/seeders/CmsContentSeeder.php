<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\Menu;
use App\Models\OfficeHour;
use App\Models\Partner;
use App\Models\Pillar;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Publication;
use App\Models\QuickLink;
use App\Models\SearchEntry;
use App\Models\ServiceCenter;
use App\Models\ServiceStep;
use App\Models\SocialLink;
use App\Models\Stat;
use App\Support\SiteSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Data awal diambil persis dari konten index.html.
 */
class CmsContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->settings();
        $this->menus();
        $this->stats();
        $this->quickLinks();
        $this->announcements();
        $this->serviceCenters();
        $this->pillars();
        $this->serviceSteps();
        $this->publications();
        $this->documents();
        $this->news();
        $this->events();
        $this->officeHours();
        $this->partners();
        $this->socialLinks();
        $this->searchEntries();

        SiteSettings::flush();
    }

    private function settings(): void
    {
        $values = collect(SiteSettings::defaults())
            ->reject(fn ($value, $key) => in_array($key, ['site_logo', 'favicon'], true))
            ->all();

        SiteSettings::save($values);
    }

    private function menus(): void
    {
        $profil = [
            ['Visi dan Misi', 'fa-solid fa-bullseye'],
            ['Peran, Arah, dan Tujuan', 'fa-solid fa-compass'],
            ['Struktur Organisasi', 'fa-solid fa-sitemap'],
            ['Pimpinan LPPM', 'fa-solid fa-user-tie'],
            ['Staff LPPM', 'fa-solid fa-users'],
            ['Sejarah LPPM', 'fa-solid fa-clock-rotate-left'],
        ];

        $profilChildren = fn () => collect($profil)->map(fn ($p) => ['label' => $p[0], 'url' => '#profil', 'icon' => $p[1]])->all();

        $mega = [
            ['Penelitian & Publikasi', 1, ['Profil Singkat', 'Komite Etik Penelitian', 'Rumah Jurnal', 'Suka Press', 'Ethical Clearance']],
            ['Pengabdian Masyarakat', 2, ['Kuliah Kerja Nyata (KKN)', 'Pengabdian kepada Masyarakat', 'Sertifikat KKN', 'Aplikasi KKN']],
            ['Difabel & Inklusi', 2, ['Pusat Layanan Difabel']],
            ['Inovasi & Pemeringkatan', 3, ['Sentra HKI', 'Karya Inovasi', 'Pendampingan Publikasi', 'Dashboard Pemeringkatan', 'SDGs']],
        ];

        $megaChildren = [];
        foreach ($mega as [$group, $column, $labels]) {
            foreach ($labels as $label) {
                $megaChildren[] = ['label' => $label, 'url' => '#pusat', 'group' => $group, 'column' => $column];
            }
        }

        $pusatMobile = [
            'Pusat Penelitian dan Penerbitan',
            'Pusat Pengabdian kepada Masyarakat',
            'Pusat Layanan Difabel',
            'Pusat Inovasi, Kekayaan Intelektual & Hilirisasi',
            'Pusat Pemeringkatan dan SDGs',
        ];

        $links = fn (array $items) => collect($items)->map(fn ($i) => ['label' => $i[0], 'url' => $i[1]])->all();
        $tail = [['Kemitraan', '#kemitraan'], ['Jurnal', '#jurnal'], ['Dokumen', '#dokumen'], ['Pengumuman', '#pengumuman']];

        $this->menu('topbar', 'Top Bar', $links([['SIAKAD', '#'], ['Repository', '#'], ['E-Journal', '#']]));

        $this->menu('header', 'Menu Utama (Desktop)', [
            ['label' => 'Beranda', 'url' => '#beranda'],
            ['label' => 'Profil', 'url' => '#profil', 'children' => $profilChildren()],
            ['label' => 'Pusat', 'url' => '#pusat', 'children' => $megaChildren],
            ...$links($tail),
        ]);

        $this->menu('mobile', 'Menu Utama (Mobile)', [
            ['label' => 'Beranda', 'url' => '#beranda'],
            ['label' => 'Profil', 'url' => '#profil', 'children' => $profilChildren()],
            ['label' => 'Pusat', 'url' => '#pusat', 'children' => collect($pusatMobile)->map(fn ($l) => ['label' => $l, 'url' => '#pusat'])->all()],
            ...$links($tail),
        ]);

        $this->menu('footer_profil', 'Profil', $links([
            ['Visi dan Misi', '#profil'], ['Peran, Arah, Tujuan', '#profil'], ['Struktur Organisasi', '#profil'],
            ['Pimpinan LPPM', '#profil'], ['Staff LPPM', '#profil'],
        ]));

        $this->menu('footer_layanan', 'Layanan', $links([
            ['Surat Izin Penelitian', '#dokumen'], ['Ethical Clearance', '#dokumen'], ['Sertifikat KKN', '#'],
            ['Aplikasi KKN', '#'], ['Sentra HKI', '#pusat'],
        ]));

        $this->menu('footer_tautan', 'Tautan', $links([
            ['IAIN Bone', '#'], ['Rumah Jurnal', '#jurnal'], ['Repository', '#'],
            ['Dashboard Ranking', '#pusat'], ['Pengumuman', '#pengumuman'],
        ]));

        $this->menu('footer_legal', 'Tautan Footer Bawah', $links([['Kebijakan Privasi', '#'], ['Peta Situs', '#']]));
    }

    private function menu(string $slug, string $name, array $items): void
    {
        $menu = Menu::query()->updateOrCreate(['slug' => $slug], ['name' => $name, 'is_active' => true]);
        $menu->items()->delete();

        foreach ($items as $i => $item) {
            $children = $item['children'] ?? [];
            unset($item['children']);

            $parent = $menu->items()->create($item + ['sort' => $i + 1]);

            foreach ($children as $j => $child) {
                $menu->items()->create($child + ['parent_id' => $parent->id, 'sort' => $j + 1]);
            }
        }
    }

    private function stats(): void
    {
        Stat::query()->delete();

        foreach ([[5, null, 'Pusat Layanan'], [24, null, 'Jurnal Ilmiah'], [120, '+', 'Kegiatan PKM / Tahun']] as $i => [$value, $suffix, $label]) {
            Stat::query()->create(['value' => $value, 'suffix' => $suffix, 'label' => $label, 'sort' => $i + 1]);
        }
    }

    private function quickLinks(): void
    {
        QuickLink::query()->delete();

        $hero = [
            ['Surat Izin Penelitian', 'fa-solid fa-file-signature', '#dokumen'],
            ['Ethical Clearance', 'fa-solid fa-certificate', '#dokumen'],
            ['Sertifikat KKN', 'fa-solid fa-graduation-cap', '#dokumen'],
            ['Rumah Jurnal', 'fa-solid fa-book-open-reader', '#jurnal'],
            ['Sentra HKI', 'fa-solid fa-lightbulb', '#pusat'],
            ['Dashboard Ranking', 'fa-solid fa-chart-line', '#pusat'],
        ];

        foreach ($hero as $i => [$title, $icon, $url]) {
            QuickLink::query()->create(['placement' => QuickLink::HERO, 'title' => $title, 'icon' => $icon, 'url' => $url, 'sort' => $i + 1]);
        }

        $cta = [
            ['Surat Izin Penelitian', 'Pengajuan & penerbitan surat', 'fa-solid fa-file-signature', '#dokumen'],
            ['Ethical Clearance', 'Telaah etik penelitian', 'fa-solid fa-certificate', '#dokumen'],
            ['Aplikasi KKN', 'Pendaftaran & monitoring', 'fa-solid fa-mobile-screen-button', '#'],
            ['Hibah & Pendanaan', 'Panduan hibah internal', 'fa-solid fa-hand-holding-dollar', '#'],
        ];

        foreach ($cta as $i => [$title, $subtitle, $icon, $url]) {
            QuickLink::query()->create(['placement' => QuickLink::SERVICE_CTA, 'title' => $title, 'subtitle' => $subtitle, 'icon' => $icon, 'url' => $url, 'sort' => $i + 1]);
        }
    }

    private function announcements(): void
    {
        Announcement::query()->delete();

        foreach ([
            'Pembukaan Pendaftaran Hibah Penelitian Internal Tahun 2027',
            'Jadwal Pengurusan Ethical Clearance Semester Genap',
            'Pendaftaran KKN Reguler Angkatan Baru Telah Dibuka',
            'Call for Papers: Jurnal Penelitian & Pengabdian LPPM IAIN Bone',
        ] as $i => $text) {
            Announcement::query()->create(['text' => $text, 'sort' => $i + 1]);
        }
    }

    private function serviceCenters(): void
    {
        ServiceCenter::query()->delete();

        $centers = [
            ['PUSAT 01', 'Pusat Penelitian dan Penerbitan', 'fa-solid fa-flask-vial', ['Tim Komite Etik Penelitian dan Publikasi', 'Rumah Jurnal', 'Suka Press', 'Surat Izin Penelitian & Ethical Clearance'], '#jurnal'],
            ['PUSAT 02', 'Pusat Pengabdian kepada Masyarakat', 'fa-solid fa-people-group', ['Kuliah Kerja Nyata (KKN)', 'Pengabdian kepada Masyarakat', 'Layanan & Sertifikat KKN', 'Aplikasi KKN'], '#layanan'],
            ['PUSAT 03', 'Pusat Layanan Difabel', 'fa-solid fa-wheelchair-move', ['Tim Ahli & Relawan PLD', 'Orientasi Maba Difabel', 'Edukasi Kampus Inklusif', 'Advokasi & Juru Bahasa Isyarat'], '#layanan'],
            ['PUSAT 04', 'Pusat Inovasi, Kekayaan Intelektual, dan Hilirisasi', 'fa-solid fa-lightbulb', ['Sentra Hak Kekayaan Intelektual', 'Pendampingan Publikasi', 'Karya Inovasi', 'Hilirisasi Hasil Riset'], '#kemitraan'],
            ['PUSAT 05', 'Pusat Pemeringkatan dan SDGs', 'fa-solid fa-ranking-star', ['Dashboard Pemeringkatan', 'Data Webometrics Kampus', 'Sinergi Program SDGs'], '#pengumuman'],
        ];

        foreach ($centers as $i => [$badge, $title, $icon, $features, $url]) {
            ServiceCenter::query()->create([
                'badge' => $badge, 'title' => $title, 'icon' => $icon, 'features' => $features,
                'link_label' => 'Selengkapnya', 'link_url' => $url, 'sort' => $i + 1,
            ]);
        }
    }

    private function pillars(): void
    {
        Pillar::query()->delete();

        $pillars = [
            ['Riset Bermutu', 'Mendorong penelitian yang metodologis, etis, dan berdampak nyata.', 'fa-solid fa-microscope', 'bone-600', 'bone-800'],
            ['Pengabdian Nyata', 'Menghadirkan solusi keilmuan bagi kebutuhan masyarakat di Bone dan sekitarnya.', 'fa-solid fa-hand-holding-heart', 'gold-400', 'gold-600'],
            ['Jejaring Luas', 'Kemitraan dengan perguruan tinggi, pemerintah, dan lembaga penelitian.', 'fa-solid fa-earth-asia', 'bone-700', 'bone-900'],
            ['Tata Kelola Transparan', 'Layanan administrasi yang terbuka, terukur, dan akuntabel.', 'fa-solid fa-shield-halved', 'gold-500', 'gold-700'],
        ];

        foreach ($pillars as $i => [$title, $description, $icon, $from, $to]) {
            Pillar::query()->create(['title' => $title, 'description' => $description, 'icon' => $icon, 'gradient_from' => $from, 'gradient_to' => $to, 'sort' => $i + 1]);
        }
    }

    private function serviceSteps(): void
    {
        ServiceStep::query()->delete();

        $steps = [
            ['Pilih Jenis Layanan', 'Tentukan layanan yang dibutuhkan: izin penelitian, ethical clearance, sertifikat KKN, HKI, atau publikasi.'],
            ['Lengkapi Berkas', 'Unggah dokumen persyaratan sesuai panduan pada halaman Dokumen dan unduhan.'],
            ['Verifikasi & Proses', 'Operator dan komite terkait memeriksa kelengkapan serta memproses permohonan Anda.'],
            ['Terbit & Unduh', 'Dokumen hasil layanan diterbitkan secara elektronik dan dapat diunduh langsung.'],
        ];

        foreach ($steps as $i => [$title, $description]) {
            ServiceStep::query()->create(['title' => $title, 'description' => $description, 'sort' => $i + 1]);
        }
    }

    private function publications(): void
    {
        Publication::query()->delete();

        $items = [
            ['JURNAL', 'Jurnal Penelitian Keislaman', 'Kajian ilmu keislaman, pendidikan, dan sosial keagamaan berbasis riset lapangan.', 'fa-solid fa-book-journal-whills', 'fa-solid fa-fingerprint', 'e-ISSN', 'Terbit Berkala'],
            ['JURNAL', 'Jurnal Pengabdian Masyarakat', 'Dokumentasi program PKM, pendampingan komunitas, dan pemberdayaan masyarakat.', 'fa-solid fa-seedling', 'fa-solid fa-fingerprint', 'e-ISSN', 'Terbit Berkala'],
            ['ETIK', 'Komite Etik Penelitian', 'Layanan telaah etik dan penerbitan Ethical Clearance bagi peneliti.', 'fa-solid fa-scale-balanced', 'fa-solid fa-file-shield', 'Sertifikat Digital', 'Aktif'],
            ['PENERBIT', 'Suka Press', 'Penerbitan buku ajar, monograf, dan karya ilmiah ber-ISBN di lingkungan kampus.', 'fa-solid fa-print', 'fa-solid fa-barcode', 'ISBN', 'Terbuka'],
            ['REPOSITORI', 'Basis Data Penelitian', 'Pangkalan data terstruktur hasil penelitian untuk mendukung visibilitas kampus.', 'fa-solid fa-database', 'fa-solid fa-link', 'Terindeks', 'Berjalan'],
        ];

        foreach ($items as $i => [$badge, $title, $description, $icon, $metaIcon, $metaLabel, $metaValue]) {
            Publication::query()->create([
                'badge' => $badge, 'title' => $title, 'description' => $description, 'icon' => $icon,
                'meta_icon' => $metaIcon, 'meta_label' => $metaLabel, 'meta_value' => $metaValue, 'sort' => $i + 1,
            ]);
        }
    }

    private function documents(): void
    {
        Document::query()->delete();

        $docs = [
            ['Panduan Hibah Penelitian 2027', 'Panduan', 'fa-solid fa-file-lines', 'Tahapan, persyaratan, dan format proposal hibah penelitian internal.', '1.2 MB', 'PDF'],
            ['Formulir Ethical Clearance', 'Formulir', 'fa-solid fa-file-shield', 'Formulir permohonan telaah etik bagi peneliti dosen dan mahasiswa.', '480 KB', 'DOCX'],
            ['Prosedur Surat Izin Penelitian', 'Prosedur', 'fa-solid fa-file-signature', 'Alur dan syarat penerbitan surat izin penelitian.', '860 KB', 'PDF'],
            ['Panduan Kuliah Kerja Nyata (KKN)', 'Panduan', 'fa-solid fa-graduation-cap', 'Ketentuan, jadwal, dan tata cara pendaftaran KKN.', '2.1 MB', 'PDF'],
            ['Template Artikel Jurnal LPPM', 'Template', 'fa-solid fa-file-code', 'Format penulisan artikel untuk jurnal di lingkungan LPPM.', '320 KB', 'DOCX'],
            ['Panduan Pendaftaran HKI', 'Panduan', 'fa-solid fa-lightbulb', 'Langkah pendaftaran hak kekayaan intelektual melalui Sentra HKI.', '740 KB', 'PDF'],
        ];

        foreach ($docs as $i => [$title, $category, $icon, $description, $size, $type]) {
            Document::query()->create([
                'title' => $title, 'category' => $category, 'icon' => $icon, 'description' => $description,
                'file_size' => $size, 'file_type' => $type, 'sort' => $i + 1,
            ]);
        }
    }

    private function news(): void
    {
        Post::query()->delete();
        PostCategory::query()->delete();

        $categories = collect(['Hibah', 'Etik', 'KKN', 'Jurnal'])->mapWithKeys(
            fn ($name, $i) => [$name => PostCategory::query()->create(['name' => $name, 'slug' => Str::slug($name), 'sort' => $i + 1])]
        );

        $posts = [
            ['2026-11-02', 'Hibah', 'Pembukaan Pendaftaran Hibah Penelitian Internal Tahun 2027', 'LPPM membuka pendaftaran hibah penelitian bagi dosen IAIN Bone. Simak persyaratan dan jadwal seleksinya.'],
            ['2026-10-28', 'Etik', 'Jadwal Layanan Ethical Clearance Semester Genap', 'Pengajuan telaah etik dibuka setiap hari kerja melalui sistem layanan LPPM.'],
            ['2026-10-21', 'KKN', 'Pendaftaran KKN Reguler Telah Dibuka', 'Mahasiswa dapat mendaftar melalui aplikasi KKN dengan melengkapi berkas persyaratan.'],
            ['2026-10-15', 'Jurnal', 'Call for Papers: Jurnal Penelitian & Pengabdian', 'Rumah Jurnal LPPM IAIN Bone menerima naskah artikel untuk edisi terbitan berikutnya.'],
        ];

        foreach ($posts as [$date, $category, $title, $excerpt]) {
            Post::query()->create([
                'post_category_id' => $categories[$category]->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => $excerpt,
                'content' => '<p>'.e($excerpt).'</p>',
                'published_at' => $date,
                'is_published' => true,
            ]);
        }
    }

    private function events(): void
    {
        Event::query()->delete();

        $events = [
            ['2026-11-18', 'Sosialisasi Panduan Hibah 2027', 'Aula LPPM IAIN Bone', '09.00 WITA'],
            ['2026-11-25', 'Workshop Penulisan Artikel Jurnal', 'Ruang Rapat LPPM', '08.30 WITA'],
            ['2026-12-02', 'Pembekalan KKN Angkatan Baru', 'Gedung Rektorat', '08.00 WITA'],
            ['2026-12-10', 'Pendampingan Pendaftaran HKI', 'Sentra HKI', '10.00 WITA'],
        ];

        foreach ($events as [$date, $title, $location, $time]) {
            Event::query()->create(['event_date' => $date, 'title' => $title, 'location' => $location, 'time' => $time, 'is_published' => true]);
        }
    }

    private function officeHours(): void
    {
        OfficeHour::query()->delete();

        foreach ([['Senin – Kamis', '08.00 – 16.00 WITA', false], ['Jumat', '08.00 – 16.00 WITA', false], ['Sabtu – Minggu', 'Tutup', true]] as $i => [$days, $hours, $closed]) {
            OfficeHour::query()->create(['days' => $days, 'hours' => $hours, 'is_closed' => $closed, 'sort' => $i + 1]);
        }
    }

    private function partners(): void
    {
        Partner::query()->delete();

        foreach (["Perguruan\nTinggi", "Pemerintah\nDaerah", "Lembaga\nRiset", "Industri &\nUMKM", "LSM &\nKomunitas", "Sekolah &\nMadrasah"] as $i => $name) {
            Partner::query()->create(['name' => $name, 'sort' => $i + 1]);
        }
    }

    private function socialLinks(): void
    {
        SocialLink::query()->delete();

        foreach ([['Facebook', 'fa-brands fa-facebook-f'], ['Instagram', 'fa-brands fa-instagram'], ['YouTube', 'fa-brands fa-youtube'], ['Email', 'fa-solid fa-envelope']] as $i => [$label, $icon]) {
            SocialLink::query()->create(['label' => $label, 'icon' => $icon, 'url' => '#', 'sort' => $i + 1]);
        }
    }

    private function searchEntries(): void
    {
        SearchEntry::query()->delete();

        $entries = [
            ['Visi dan Misi LPPM', '#profil', 'Profil'],
            ['Struktur Organisasi', '#profil', 'Profil'],
            ['Pimpinan dan Staff LPPM', '#profil', 'Profil'],
            ['Sejarah LPPM', '#profil', 'Profil'],
            ['Pusat Penelitian dan Penerbitan', '#pusat', 'Pusat'],
            ['Pusat Pengabdian kepada Masyarakat', '#pusat', 'Pusat'],
            ['Pusat Layanan Difabel', '#pusat', 'Pusat'],
            ['Pusat Inovasi, Kekayaan Intelektual, dan Hilirisasi', '#pusat', 'Pusat'],
            ['Pusat Pemeringkatan dan SDGs', '#pusat', 'Pusat'],
            ['Rumah Jurnal', '#jurnal', 'Jurnal'],
            ['Suka Press', '#jurnal', 'Jurnal'],
            ['Surat Izin Penelitian', '#dokumen', 'Dokumen'],
            ['Ethical Clearance', '#dokumen', 'Dokumen'],
            ['Sertifikat KKN', '#dokumen', 'Layanan'],
            ['Aplikasi KKN', '#layanan', 'Layanan'],
            ['Pengumuman Hibah Penelitian', '#pengumuman', 'Pengumuman'],
            ['Kalender Kegiatan LPPM', '#pengumuman', 'Agenda'],
            ['Kemitraan dan Kerja Sama', '#kemitraan', 'Kemitraan'],
        ];

        foreach ($entries as $i => [$title, $url, $category]) {
            SearchEntry::query()->create(['title' => $title, 'url' => $url, 'category' => $category, 'sort' => $i + 1]);
        }
    }
}
