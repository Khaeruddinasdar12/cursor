<?php

namespace App\Filament\Resources\Pillars;

use App\Filament\Resources\Pillars\Pages\ManagePillars;
use App\Filament\Support\CmsTable;
use App\Models\Pillar;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PillarResource extends Resource
{
    protected static ?string $model = Pillar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|UnitEnum|null $navigationGroup = 'Beranda';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'nilai / pilar';

    protected static ?string $pluralModelLabel = 'Nilai & Pilar (Profil)';

    public const SHADES = [
        'bone-600' => 'Hijau 600', 'bone-700' => 'Hijau 700', 'bone-800' => 'Hijau 800', 'bone-900' => 'Hijau 900',
        'gold-400' => 'Emas 400', 'gold-500' => 'Emas 500', 'gold-600' => 'Emas 600', 'gold-700' => 'Emas 700',
    ];

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Judul')->required()->maxLength(255),
            Textarea::make('description')->label('Deskripsi')->required()->rows(3),
            CmsTable::iconInput(),
            Select::make('gradient_from')->label('Warna gradien atas')->options(self::SHADES)->default('bone-600')->required(),
            Select::make('gradient_to')->label('Warna gradien bawah')->options(self::SHADES)->default('bone-800')->required(),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('title')->label('Judul')->searchable(),
            TextColumn::make('description')->label('Deskripsi')->limit(60),
            CmsTable::activeColumn(),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManagePillars::route('/')];
    }
}
