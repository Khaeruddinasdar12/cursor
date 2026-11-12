<?php

namespace App\Filament\Resources\SocialLinks;

use App\Filament\Resources\SocialLinks\Pages\ManageSocialLinks;
use App\Filament\Support\CmsTable;
use App\Models\SocialLink;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SocialLinkResource extends Resource
{
    protected static ?string $model = SocialLink::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShare;

    protected static string|UnitEnum|null $navigationGroup = 'Navigasi';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'media sosial';

    protected static ?string $pluralModelLabel = 'Media Sosial (Footer)';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('label')->label('Nama')->required()->maxLength(255),
            CmsTable::iconInput()->required()->default('fa-brands fa-facebook-f'),
            CmsTable::urlInput(),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('label')->label('Nama'),
            TextColumn::make('icon')->label('Ikon'),
            TextColumn::make('url')->label('Tautan'),
            CmsTable::activeColumn(),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageSocialLinks::route('/')];
    }
}
