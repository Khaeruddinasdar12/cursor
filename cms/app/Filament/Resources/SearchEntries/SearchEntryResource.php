<?php

namespace App\Filament\Resources\SearchEntries;

use App\Filament\Resources\SearchEntries\Pages\ManageSearchEntries;
use App\Filament\Support\CmsTable;
use App\Models\SearchEntry;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SearchEntryResource extends Resource
{
    protected static ?string $model = SearchEntry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlass;

    protected static string|UnitEnum|null $navigationGroup = 'Navigasi';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'entri pencarian';

    protected static ?string $pluralModelLabel = 'Indeks Pencarian';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Judul')->required()->maxLength(255),
            CmsTable::urlInput('url', 'Tautan tujuan')->required(),
            TextInput::make('category')->label('Kategori')->required()->maxLength(255),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('title')->label('Judul')->searchable(),
            TextColumn::make('category')->label('Kategori')->badge(),
            TextColumn::make('url')->label('Tautan'),
            CmsTable::activeColumn(),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageSearchEntries::route('/')];
    }
}
