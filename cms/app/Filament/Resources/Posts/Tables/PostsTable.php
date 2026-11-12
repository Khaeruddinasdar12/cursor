<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Filament\Support\CmsTable;
use App\Models\PostCategory;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('title')->label('Judul')->searchable()->limit(60)->wrap(),
            TextColumn::make('category.name')->label('Kategori')->badge()->sortable(),
            TextColumn::make('published_at')->label('Tanggal')->date('d M Y')->sortable(),
            ToggleColumn::make('is_published')->label('Terbit'),
        ], [
            SelectFilter::make('post_category_id')->label('Kategori')->options(fn () => PostCategory::query()->pluck('name', 'id')),
            TernaryFilter::make('is_published')->label('Status terbit'),
        ], reorderable: false)->defaultSort('published_at', 'desc');
    }
}
