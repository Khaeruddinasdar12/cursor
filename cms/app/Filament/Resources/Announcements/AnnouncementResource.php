<?php

namespace App\Filament\Resources\Announcements;

use App\Filament\Resources\Announcements\Pages\ManageAnnouncements;
use App\Filament\Support\CmsTable;
use App\Models\Announcement;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'teks berjalan';

    protected static ?string $pluralModelLabel = 'Teks Berjalan (INFO)';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('text')->label('Teks')->required()->maxLength(255)->columnSpanFull(),
            CmsTable::urlInput('url', 'Tautan (opsional)')->default(null),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('text')->label('Teks')->searchable()->wrap(),
            CmsTable::activeColumn(),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageAnnouncements::route('/')];
    }
}
