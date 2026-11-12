<?php

use App\Support\SiteSettings;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return SiteSettings::get($key, $default);
    }
}

if (! function_exists('site_url')) {
    /**
     * Tautan jangkar (#profil) diarahkan ke beranda bila halaman saat ini bukan beranda.
     */
    function site_url(?string $url): string
    {
        $url = trim((string) $url);

        if ($url === '' || $url === '#') {
            return '#';
        }

        if (str_starts_with($url, '#') && ! request()->routeIs('home')) {
            return url('/').$url;
        }

        return $url;
    }
}

if (! function_exists('month_short')) {
    function month_short(int $month): string
    {
        return ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'][$month - 1];
    }
}
