<?php

namespace App\Filament\Resources\ServiceCenters\Tables;

use App\Filament\Support\CmsTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceCentersTable
{
    public static function configure(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('badge')->label('Lencana')->badge(),
            TextColumn::make('title')->label('Nama pusat')->searchable()->wrap(),
            TextColumn::make('features')->label('Jumlah layanan')->formatStateUsing(fn ($state, $record) => count($record->features ?? [])),
            CmsTable::activeColumn(),
        ]);
    }
}
