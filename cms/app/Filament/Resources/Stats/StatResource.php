<?php

namespace App\Filament\Resources\Stats;

use App\Filament\Resources\Stats\Pages\ManageStats;
use App\Filament\Support\CmsTable;
use App\Models\Stat;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class StatResource extends Resource
{
    protected static ?string $model = Stat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Beranda';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'statistik hero';

    protected static ?string $pluralModelLabel = 'Statistik Hero';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('label')->label('Label')->required()->maxLength(255),
            TextInput::make('value')->label('Angka')->numeric()->required()->minValue(0),
            TextInput::make('suffix')->label('Akhiran (mis. +)')->maxLength(10),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('label')->label('Label'),
            TextColumn::make('value')->label('Angka'),
            TextColumn::make('suffix')->label('Akhiran'),
            CmsTable::activeColumn(),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageStats::route('/')];
    }
}
