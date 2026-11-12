<?php

namespace App\Filament\Resources\OfficeHours;

use App\Filament\Resources\OfficeHours\Pages\ManageOfficeHours;
use App\Filament\Support\CmsTable;
use App\Models\OfficeHour;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class OfficeHourResource extends Resource
{
    protected static ?string $model = OfficeHour::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static string|UnitEnum|null $navigationGroup = 'Beranda';

    protected static ?int $navigationSort = 8;

    protected static ?string $modelLabel = 'jam operasional';

    protected static ?string $pluralModelLabel = 'Jam Operasional';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('days')->label('Hari')->required()->maxLength(255),
            TextInput::make('hours')->label('Jam / keterangan')->required()->maxLength(255)->placeholder('08.00 – 16.00 WITA'),
            Toggle::make('is_closed')->label('Tutup (teks ditampilkan abu-abu)')->default(false),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('days')->label('Hari'),
            TextColumn::make('hours')->label('Jam'),
            IconColumn::make('is_closed')->label('Tutup')->boolean(),
            CmsTable::activeColumn(),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageOfficeHours::route('/')];
    }
}
