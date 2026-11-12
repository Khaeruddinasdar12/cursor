<?php

namespace App\Filament\Resources\Publications\Tables;

use App\Filament\Support\CmsTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PublicationsTable
{
    public static function configure(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('badge')->label('Lencana')->badge(),
            TextColumn::make('title')->label('Judul')->searchable()->wrap(),
            TextColumn::make('meta_value')->label('Status'),
            CmsTable::activeColumn(),
        ]);
    }
}
