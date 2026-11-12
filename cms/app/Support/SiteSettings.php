<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * Pengaturan situs berbasis key-value. Definisi (label, tipe, nilai awal) berada di sini;
 * nilai awal sama persis dengan teks pada index.html sehingga situs tampil benar
 * bahkan sebelum admin mengubah apa pun.
 */
class SiteSettings
{
    private const CACHE_KEY = 'cms.site_settings';

    private static ?array $resolved = null;

    public static function get(string $key, mixed $default = null): mixed
    {
        $values = self::all();

        if (array_key_exists($key, $values) && $values[$key] !== null && $values[$key] !== '') {
            return $values[$key];
        }

        return $default ?? self::defaults()[$key] ?? null;
    }

    public static function all(): array
    {
        if (self::$resolved !== null) {
            return self::$resolved;
        }

        try {
            return self::$resolved = Cache::rememberForever(
                self::CACHE_KEY,
                fn () => Schema::hasTable('settings') ? Setting::query()->pluck('value', 'key')->all() : []
            );
        } catch (\Throwable) {
            return self::$resolved = [];
        }
    }

    public static function save(array $values): void
    {
        foreach ($values as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        self::flush();
    }

    public static function flush(): void
    {
        self::$resolved = null;
        Cache::forget(self::CACHE_KEY);
    }

    public static function defaults(): array
    {
        $defaults = [];

        foreach (self::groups() as $group) {
            foreach ($group['fields'] as $key => $field) {
                $defaults[$key] = $field['default'] ?? null;
            }
        }

        return $defaults;
    }

    public static function fields(): array
    {
        return collect(self::groups())->flatMap(fn ($group) => $group['fields'])->all();
    }

    /**
     * @return array<string, array{label: string, fields: array<string, array{label: string, type?: string, default?: mixed, help?: string}>}>
     */
    public static function groups(): array
    {
        return [
            'umum' => [
                'label' => 'Umum & Merek',
                'fields' => [
                    'site_title' => ['label' => 'Judul situs (tag <title>)', 'default' => 'LPPM IAIN Bone — Lembaga Penelitian dan Pengabdian kepada Masyarakat'],
                    'meta_description' => ['label' => 'Deskripsi meta (SEO)', 'type' => 'textarea', 'default' => 'Website resmi Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM) Institut Agama Islam Negeri (IAIN) Bone. Pusat publikasi penelitian, pengabdian kepada masyarakat, jurnal, dan inovasi.'],
                    'brand_name' => ['label' => 'Nama merek', 'default' => 'LPPM'],
                    'brand_highlight' => ['label' => 'Nama merek (bagian emas)', 'default' => 'IAIN Bone'],
                    'brand_tagline' => ['label' => 'Tagline navbar', 'default' => 'Penelitian & Pengabdian Masyarakat'],
                    'footer_brand_tagline' => ['label' => 'Tagline footer', 'default' => 'Penelitian & Pengabdian'],
                    'site_logo' => ['label' => 'Logo (opsional)', 'type' => 'image', 'help' => 'Kosongkan untuk memakai logo IAIN Bone bawaan.'],
                    'favicon' => ['label' => 'Favicon (opsional)', 'type' => 'image', 'help' => 'Kosongkan untuk memakai ikon bawaan.'],
                ],
            ],
            'kontak' => [
                'label' => 'Kontak',
                'fields' => [
                    'contact_phone' => ['label' => 'Telepon', 'default' => '(0481) 21395'],
                    'contact_fax' => ['label' => 'Faks', 'default' => '(0481) 23928'],
                    'contact_email' => ['label' => 'Email', 'default' => 'info@iain-bone.ac.id'],
                    'contact_website' => ['label' => 'Situs web', 'default' => 'lppm.iain-bone.ac.id'],
                    'contact_address_street' => ['label' => 'Alamat (baris 1)', 'default' => 'Jl. HOS. Cokroaminoto'],
                    'contact_address_city' => ['label' => 'Alamat (baris 2)', 'default' => 'Watampone, KP. 92733'],
                ],
            ],
            'header' => [
                'label' => 'Header & Pencarian',
                'fields' => [
                    'header_cta_label' => ['label' => 'Tombol navbar: teks', 'default' => 'Ajukan Layanan'],
                    'header_cta_url' => ['label' => 'Tombol navbar: tautan', 'default' => '#layanan'],
                    'search_placeholder' => ['label' => 'Placeholder kolom pencarian', 'default' => 'Cari layanan, dokumen, jurnal, pengumuman…'],
                    'topbar_lang_label' => ['label' => 'Tombol bahasa (top bar): teks', 'default' => 'EN'],
                    'topbar_lang_url' => ['label' => 'Tombol bahasa (top bar): tautan', 'default' => '#'],
                    'ticker_label' => ['label' => 'Label running text pengumuman', 'default' => 'INFO'],
                ],
            ],
            'hero' => [
                'label' => 'Hero',
                'fields' => [
                    'hero_badge' => ['label' => 'Lencana', 'default' => 'INSTITUT AGAMA ISLAM NEGERI BONE'],
                    'hero_arabic' => ['label' => 'Teks Arab (opsional)', 'default' => '', 'help' => 'Kosongkan agar tidak ditampilkan di hero.'],
                    'hero_title_line1' => ['label' => 'Judul (baris 1)', 'default' => 'Lembaga Penelitian dan'],
                    'hero_title_highlight' => ['label' => 'Judul (baris 2, emas)', 'default' => 'Pengabdian kepada Masyarakat'],
                    'hero_description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Pusat tata kelola penelitian, publikasi karya ilmiah, dan pengabdian kepada masyarakat di lingkungan IAIN Bone — menghadirkan informasi yang terintegrasi, transparan, dan terstruktur bagi dosen, mahasiswa, serta mitra.'],
                    'hero_button1_label' => ['label' => 'Tombol 1: teks', 'default' => 'Jelajahi Layanan'],
                    'hero_button1_url' => ['label' => 'Tombol 1: tautan', 'default' => '#layanan'],
                    'hero_button2_label' => ['label' => 'Tombol 2: teks', 'default' => 'Pengumuman Terbaru'],
                    'hero_button2_url' => ['label' => 'Tombol 2: tautan', 'default' => '#pengumuman'],
                    'hero_card_title' => ['label' => 'Kartu: judul', 'default' => 'Layanan Cepat'],
                    'hero_card_subtitle' => ['label' => 'Kartu: subjudul', 'default' => 'Akses langsung ke layanan LPPM'],
                    'hero_card_note' => ['label' => 'Kartu: catatan (sebelum teks emas)', 'default' => 'Website resmi LPPM dapat diakses melalui'],
                    'hero_card_note_highlight' => ['label' => 'Kartu: catatan (teks emas)', 'default' => 'lppm.iain-bone.ac.id'],
                ],
            ],
            'profil' => [
                'label' => 'Profil Lembaga',
                'fields' => [
                    'profile_eyebrow' => ['label' => 'Label atas judul', 'default' => 'Profil Lembaga'],
                    'profile_title' => ['label' => 'Judul', 'default' => 'Membangun Ekosistem Riset yang Berdaya Guna'],
                    'profile_paragraph1' => ['label' => 'Paragraf 1', 'type' => 'textarea', 'default' => 'LPPM IAIN Bone hadir sebagai unit pelaksana yang mengoordinasikan seluruh kegiatan penelitian dan pengabdian kepada masyarakat. Kami mewadahi dosen dan mahasiswa dalam menghasilkan karya ilmiah yang berkualitas serta mengabdi bagi kemaslahatan umat.'],
                    'profile_paragraph2' => ['label' => 'Paragraf 2', 'type' => 'textarea', 'default' => 'Melalui lima pusat layanan — penelitian & penerbitan, pengabdian masyarakat, layanan difabel, inovasi & kekayaan intelektual, serta pemeringkatan & SDGs — kami menjaga standar mutu akademik dan memperluas dampak karya kampus bagi masyarakat.'],
                    'profile_vision' => ['label' => 'Visi', 'type' => 'textarea', 'default' => 'Menjadi lembaga penelitian dan pengabdian kepada masyarakat yang unggul, inovatif, dan bereputasi dalam pengembangan ilmu keislaman dan kemasyarakatan.'],
                    'profile_mission' => ['label' => 'Misi', 'type' => 'textarea', 'default' => 'Mengembangkan penelitian bermutu, mempublikasikan hasil riset dan pengabdian, membangun kemitraan strategis, serta memperkuat kapasitas peneliti dan pengabdi.'],
                ],
            ],
            'pusat' => [
                'label' => 'Pusat Layanan',
                'fields' => [
                    'centers_eyebrow' => ['label' => 'Label atas judul', 'default' => 'Struktur Pusat'],
                    'centers_title' => ['label' => 'Judul', 'default' => 'Lima Pusat Layanan LPPM'],
                    'centers_description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Setiap pusat menaungi layanan, tim, dan program tersendiri — dari publikasi ilmiah hingga pendampingan inovasi dan pemeringkatan kampus.'],
                    'centers_cta_title' => ['label' => 'Kartu CTA: judul', 'default' => 'Butuh bantuan memilih layanan?'],
                    'centers_cta_text' => ['label' => 'Kartu CTA: teks', 'type' => 'textarea', 'default' => 'Tim LPPM siap membantu Anda menentukan alur pengajuan penelitian, pengabdian, maupun penerbitan karya ilmiah.'],
                    'centers_cta_button_label' => ['label' => 'Kartu CTA: teks tombol', 'default' => 'Hubungi LPPM'],
                    'centers_cta_button_url' => ['label' => 'Kartu CTA: tautan tombol', 'default' => '#kontak'],
                ],
            ],
            'alur' => [
                'label' => 'Alur Layanan',
                'fields' => [
                    'steps_eyebrow' => ['label' => 'Label atas judul', 'default' => 'Alur Layanan'],
                    'steps_title' => ['label' => 'Judul', 'default' => 'Empat Langkah, Selesai'],
                    'steps_description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Proses pengajuan layanan LPPM IAIN Bone dirancang sederhana dan transparan — Anda dapat memantau setiap tahapan secara langsung.'],
                    'steps_button_label' => ['label' => 'Tombol: teks', 'default' => 'Mulai Pengajuan'],
                    'steps_button_url' => ['label' => 'Tombol: tautan', 'default' => '#layanan'],
                ],
            ],
            'jurnal' => [
                'label' => 'Rumah Jurnal',
                'fields' => [
                    'publications_eyebrow' => ['label' => 'Label atas judul', 'default' => 'Rumah Jurnal'],
                    'publications_title' => ['label' => 'Judul', 'default' => 'Publikasi & Repositori Karya Ilmiah'],
                    'publications_description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Wadah penerbitan jurnal ilmiah, buku, serta repositori hasil penelitian dan pengabdian dosen dan mahasiswa IAIN Bone.'],
                    'publications_button_label' => ['label' => 'Tombol: teks', 'default' => 'Kunjungi Rumah Jurnal'],
                    'publications_button_url' => ['label' => 'Tombol: tautan', 'default' => '#'],
                ],
            ],
            'dokumen' => [
                'label' => 'Dokumen',
                'fields' => [
                    'documents_eyebrow' => ['label' => 'Label atas judul', 'default' => 'Pusat Dokumen'],
                    'documents_title' => ['label' => 'Judul', 'default' => 'Dokumen & Panduan'],
                    'documents_description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Unduh panduan, formulir, dan template yang dibutuhkan untuk setiap layanan LPPM.'],
                ],
            ],
            'pengumuman' => [
                'label' => 'Pengumuman & Agenda',
                'fields' => [
                    'news_eyebrow' => ['label' => 'Label atas judul', 'default' => 'Informasi'],
                    'news_title' => ['label' => 'Judul', 'default' => 'Pengumuman Terbaru'],
                    'news_all_label' => ['label' => 'Tautan "lihat semua": teks', 'default' => 'Lihat semua'],
                    'news_read_more_label' => ['label' => 'Tautan baca selengkapnya', 'default' => 'Baca selengkapnya'],
                    'news_home_limit' => ['label' => 'Jumlah pengumuman di beranda', 'type' => 'number', 'default' => 4],
                    'agenda_title' => ['label' => 'Agenda: judul', 'default' => 'Kalender Kegiatan'],
                    'agenda_subtitle' => ['label' => 'Agenda: subjudul', 'default' => 'Agenda LPPM mendatang'],
                    'agenda_home_limit' => ['label' => 'Jumlah agenda di beranda', 'type' => 'number', 'default' => 4],
                    'office_hours_title' => ['label' => 'Judul jam operasional', 'default' => 'Jam Operasional Kantor'],
                ],
            ],
            'kemitraan' => [
                'label' => 'Kemitraan',
                'fields' => [
                    'partners_eyebrow' => ['label' => 'Label atas judul', 'default' => 'Kemitraan'],
                    'partners_title' => ['label' => 'Judul', 'default' => 'Berkolaborasi untuk Dampak Lebih Luas'],
                    'partners_description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'LPPM IAIN Bone membuka kerja sama riset, pengabdian, dan pengembangan kapasitas bersama mitra.'],
                    'partners_button_label' => ['label' => 'Tombol: teks', 'default' => 'Ajukan Kerja Sama'],
                    'partners_button_url' => ['label' => 'Tombol: tautan', 'default' => '#kontak'],
                ],
            ],
            'layanan' => [
                'label' => 'Layanan Terpadu',
                'fields' => [
                    'cta_eyebrow' => ['label' => 'Label atas judul', 'default' => 'Layanan Terpadu'],
                    'cta_title' => ['label' => 'Judul', 'default' => 'Satu Pintu untuk Semua Layanan LPPM'],
                    'cta_description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Ajukan surat izin penelitian, ethical clearance, sertifikat KKN, pendaftaran HKI, hingga pendampingan publikasi — seluruhnya melalui satu sistem terintegrasi.'],
                    'cta_button1_label' => ['label' => 'Tombol 1: teks', 'default' => 'Masuk Sistem Layanan'],
                    'cta_button1_url' => ['label' => 'Tombol 1: tautan', 'default' => '#'],
                    'cta_button2_label' => ['label' => 'Tombol 2: teks', 'default' => 'Unduh Panduan'],
                    'cta_button2_url' => ['label' => 'Tombol 2: tautan', 'default' => '#dokumen'],
                ],
            ],
            'footer' => [
                'label' => 'Footer',
                'fields' => [
                    'footer_description' => ['label' => 'Deskripsi lembaga (Enter = baris baru)', 'type' => 'textarea', 'default' => "Lembaga Penelitian dan Pengabdian kepada Masyarakat\nInstitut Agama Islam Negeri (IAIN) Bone"],
                    'footer_copyright' => ['label' => 'Hak cipta', 'default' => '© 2026 LPPM — Institut Agama Islam Negeri Bone. Seluruh hak cipta dilindungi.'],
                    'footer_back_to_top' => ['label' => 'Teks "Kembali ke Atas"', 'default' => 'Kembali ke Atas'],
                ],
            ],
        ];
    }
}
