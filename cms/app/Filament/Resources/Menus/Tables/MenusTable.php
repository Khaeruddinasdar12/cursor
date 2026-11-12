<?php

namespace App\Filament\Resources\Menus\Tables;

use App\Filament\Support\CmsTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MenusTable
{
    public static function configure(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('name')->label('Nama menu')->searchable(),
            TextColumn::make('slug')->label('Kode')->badge(),
            TextColumn::make('items_count')->label('Jumlah item')->counts('items'),
            CmsTable::activeColumn(),
        ], reorderable: false)->defaultSort('id');
    }
}
