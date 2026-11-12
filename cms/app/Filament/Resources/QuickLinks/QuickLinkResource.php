<?php

namespace App\Filament\Resources\QuickLinks;

use App\Filament\Resources\QuickLinks\Pages\ManageQuickLinks;
use App\Filament\Support\CmsTable;
use App\Models\QuickLink;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class QuickLinkResource extends Resource
{
    protected static ?string $model = QuickLink::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBolt;

    protected static string|UnitEnum|null $navigationGroup = 'Beranda';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'tautan layanan cepat';

    protected static ?string $pluralModelLabel = 'Layanan Cepat';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('placement')->label('Lokasi')->options(QuickLink::PLACEMENTS)->default(QuickLink::HERO)->required()->live(),
            TextInput::make('title')->label('Judul')->required()->maxLength(255),
            TextInput::make('subtitle')->label('Subjudul')->maxLength(255)
                ->helperText('Hanya ditampilkan pada bagian Layanan Terpadu.')
                ->visible(fn ($get) => $get('placement') === QuickLink::SERVICE_CTA),
            CmsTable::iconInput(),
            CmsTable::urlInput(),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('placement')->label('Lokasi')->formatStateUsing(fn ($state) => QuickLink::PLACEMENTS[$state] ?? $state)->badge(),
            TextColumn::make('title')->label('Judul')->searchable(),
            TextColumn::make('url')->label('Tautan'),
            CmsTable::activeColumn(),
        ], [
            SelectFilter::make('placement')->label('Lokasi')->options(QuickLink::PLACEMENTS),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageQuickLinks::route('/')];
    }
}
