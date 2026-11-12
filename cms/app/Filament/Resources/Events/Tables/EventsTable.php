<?php

namespace App\Filament\Resources\Events\Tables;

use App\Filament\Support\CmsTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('event_date')->label('Tanggal')->date('d M Y')->sortable(),
            TextColumn::make('title')->label('Kegiatan')->searchable()->wrap(),
            TextColumn::make('location')->label('Tempat'),
            TextColumn::make('time')->label('Waktu'),
            ToggleColumn::make('is_published')->label('Tampil'),
        ], [
            Filter::make('upcoming')->label('Hanya mendatang')->query(fn ($query) => $query->whereDate('event_date', '>=', today())),
        ], reorderable: false)->defaultSort('event_date', 'desc');
    }
}
