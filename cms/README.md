# CMS LPPM IAIN Bone

Back end CMS dinamis untuk halaman `index.html` LPPM IAIN Bone. Seluruh konten (menu, hero, profil, pusat layanan,
jurnal, dokumen, pengumuman, agenda, kemitraan, footer, dll.) dibaca dari database dan dikelola lewat panel admin
**Filament** di `/admin`. Tampilan publik sama dengan `index.html` asli.

| Komponen | Versi |
| --- | --- |
| PHP | 8.5 (minimal 8.3) |
| Laravel | 13.x |
| Filament | 5.x (Livewire 4) |
| Database | SQLite (default, untuk pengembangan) atau MySQL/MariaDB/PostgreSQL |

## Kebutuhan server

- PHP **8.3 atau lebih baru** (diuji pada 8.5) dengan ekstensi: `ctype`, `curl`, `dom`, `fileinfo`, `gd`, `intl`, `json`, `mbstring`,
  `openssl`, `pdo` + driver database (`pdo_mysql` / `pdo_sqlite` / `pdo_pgsql`), `tokenizer`, `xml`, `zip`.
  Ekstensi **intl** wajib karena dipakai Filament.
- [Composer](https://getcomposer.org) 2.
- Web server (Nginx/Apache) dengan document root ke folder `public/`.
- Akses internet pada browser pengunjung: tampilan memakai Tailwind CSS (CDN), Font Awesome, AOS, Swiper, dan
  Google Fonts persis seperti `index.html` asli.

## Instalasi

```bash
cd cms
composer install
cp .env.example .env
php artisan key:generate
# sesuaikan .env (lihat bagian berikut), lalu:
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Buka `http://127.0.0.1:8000` (situs) dan `http://127.0.0.1:8000/admin` (panel admin).

`composer run setup` menjalankan urutan yang sama (kecuali `serve`).

`migrate --seed` mengisi database dengan konten awal yang diambil persis dari `index.html`, serta membuat akun admin.
Seeder aman dijalankan ulang: akun admin yang sudah ada tidak ditimpa, sedangkan konten awal direset ke versi `index.html`.
Jangan menjalankan `db:seed` ulang di situs yang sudah diedit admin kecuali memang ingin mengembalikan konten awal.

## Konfigurasi `.env`

| Variabel | Keterangan |
| --- | --- |
| `APP_NAME`, `APP_URL` | Nama aplikasi dan URL publik situs (mis. `https://lppm.iain-bone.ac.id`). |
| `APP_ENV`, `APP_DEBUG` | Produksi: `production` dan `false`. |
| `APP_LOCALE`, `APP_TIMEZONE` | Default `id` dan `Asia/Makassar` (WITA). Tanggal agenda mengikuti zona waktu ini. |
| `DB_CONNECTION` dan `DB_*` | Default SQLite (`database/database.sqlite`). Untuk MySQL isi `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`. |
| `FILESYSTEM_DISK` | `public` agar unggahan (gambar, dokumen) dapat diakses publik. Wajib menjalankan `php artisan storage:link`. |
| `ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD` | Akun admin yang dibuat oleh seeder. |
| `SESSION_DRIVER`, `CACHE_STORE`, `QUEUE_CONNECTION` | Default `database`; tabelnya dibuat oleh migrasi. |

## Membuat dan mengganti admin

Akun admin **tidak** memakai kata sandi bawaan di repositori.

1. **Lewat seeder**: isi `ADMIN_EMAIL` dan `ADMIN_PASSWORD` di `.env` sebelum `php artisan migrate --seed`.
   Jika `ADMIN_PASSWORD` dikosongkan, seeder membuat kata sandi acak dan menampilkannya **satu kali** di konsol; catat segera.
2. **Lewat perintah**: `php artisan make:filament-user` (menanyakan nama, email, dan kata sandi).
3. **Dari panel admin**: menu *Pengaturan → Pengguna Admin* untuk menambah, mengubah email/kata sandi, atau menghapus admin.
   Setiap pengguna dapat mengganti kata sandi sendiri lewat menu profil (ikon avatar di kanan atas).
4. **Lupa kata sandi**: `php artisan tinker`, lalu
   `App\Models\User::where('email', 'admin@contoh.ac.id')->first()->update(['password' => 'kata-sandi-baru']);`
   (kata sandi di-hash otomatis).

Setelah login pertama di server produksi, segera ganti kata sandi dan hapus/ubah `ADMIN_PASSWORD` dari `.env`.

> Semua pengguna terdaftar dapat masuk ke panel admin. Jika perlu pembatasan peran, ubah `User::canAccessPanel()`.

## Mengelola konten di panel admin

| Menu | Isi |
| --- | --- |
| Konten → Pengumuman, Kategori Pengumuman | Berita/pengumuman dengan editor kaya, gambar sampul, status terbit, tanggal terbit. Halaman publik `/pengumuman` dan `/pengumuman/{slug}`. |
| Konten → Agenda Kegiatan | Kalender kegiatan; beranda menampilkan agenda yang akan datang. |
| Konten → Dokumen & Panduan | Unggah berkas (tipe dan ukuran terisi otomatis) atau pakai tautan luar. |
| Konten → Teks Berjalan (INFO) | Teks pada running text di bawah hero. |
| Beranda | Statistik hero, layanan cepat, nilai & pilar, pusat layanan, alur layanan, rumah jurnal, kemitraan (logo opsional), jam operasional. |
| Navigasi | Menu (top bar, menu desktop dengan dropdown/mega menu, menu mobile, kolom footer) beserta item-itemnya, media sosial, indeks pencarian. |
| Pengaturan → Pengaturan Situs | Semua teks tetap: judul/SEO, logo & favicon, kontak, judul tiap bagian, hero, footer, dll. |
| Pengaturan → Pengguna Admin | Kelola akun admin. |

Urutan item dapat diubah dengan seret-lepas di tabel (kolom `sort`); item bisa dinonaktifkan tanpa dihapus.

## Struktur singkat

- `app/Models`, `database/migrations`, `database/seeders/CmsContentSeeder.php` (data awal dari `index.html`)
- `app/Filament` — resource, halaman pengaturan, widget panel admin
- `app/Support/SiteSettings.php` — definisi semua pengaturan situs beserta nilai awalnya
- `resources/views` — `layouts/site.blade.php`, `partials/`, `sections/` (Blade dari `index.html`)
- `public/css/site.css`, `public/js/site.js`, `public/js/tailwind-config.js` — aset dari `index.html`

## Pengujian

```bash
php artisan test
```

## Deploy (ringkas)

1. Unggah kode (tanpa `vendor/` dan `.env`), arahkan document root ke `public/`.
2. `composer install --no-dev --optimize-autoloader` (otomatis menjalankan `filament:upgrade` yang mempublikasikan aset Filament).
3. Buat `.env` produksi (`APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, database, `FILESYSTEM_DISK=public`, `ADMIN_*`), lalu `php artisan key:generate`.
4. `php artisan migrate --force --seed` (seed hanya pada instalasi pertama), `php artisan storage:link`.
5. Optimasi: `php artisan optimize` dan `php artisan filament:optimize`.
6. Pastikan `storage/` dan `bootstrap/cache/` dapat ditulis oleh user web server.
7. Di belakang reverse proxy/HTTPS, atur trusted proxies agar URL yang dihasilkan memakai `https`.
8. Setiap rilis: `composer install --no-dev -o && php artisan migrate --force && php artisan optimize:clear && php artisan optimize`.

## Catatan

- `.env`, `vendor/`, database SQLite, dan aset Filament hasil publikasi tidak di-commit (lihat `.gitignore`).
- Font pada `index.html` asli dimuat lewat `/cf-fonts/...` (artefak Cloudflare); di sini diganti dengan Google Fonts
  (Plus Jakarta Sans dan Scheherazade New) sehingga tampilan sama dengan yang dimaksud desain.
