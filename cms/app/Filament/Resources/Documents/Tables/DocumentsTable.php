<?php

namespace App\Filament\Resources\Documents\Tables;

use App\Filament\Support\CmsTable;
use App\Models\Document;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('title')->label('Judul')->searchable()->wrap(),
            TextColumn::make('category')->label('Kategori')->badge(),
            TextColumn::make('file_type')->label('Tipe'),
            TextColumn::make('file_size')->label('Ukuran'),
            CmsTable::activeColumn(),
        ], [
            SelectFilter::make('category')->label('Kategori')->options(fn () => Document::query()->distinct()->pluck('category', 'category')),
        ]);
    }
}
