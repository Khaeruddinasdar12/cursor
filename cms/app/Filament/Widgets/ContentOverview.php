<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use App\Models\Event;
use App\Models\Post;
use App\Models\Publication;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Konten';

    protected function getStats(): array
    {
        return [
            Stat::make('Pengumuman terbit', Post::published()->count())->icon('heroicon-o-newspaper'),
            Stat::make('Agenda mendatang', Event::upcoming()->count())->icon('heroicon-o-calendar-days'),
            Stat::make('Dokumen aktif', Document::active()->count())->icon('heroicon-o-document-text'),
            Stat::make('Publikasi aktif', Publication::active()->count())->icon('heroicon-o-book-open'),
        ];
    }
}
