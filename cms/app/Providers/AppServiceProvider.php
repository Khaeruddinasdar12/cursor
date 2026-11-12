<?php

namespace App\Providers;

use App\Models\SearchEntry;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.site', function ($view) {
            $view->with('searchIndex', Schema::hasTable('search_entries')
                ? SearchEntry::active()->ordered()->get()
                    ->map(fn (SearchEntry $entry) => ['t' => $entry->title, 'h' => site_url($entry->url), 'k' => $entry->category])
                    ->values()
                : []);
        });
    }
}
