<?php

namespace App\Filament\Resources\ServiceSteps;

use App\Filament\Resources\ServiceSteps\Pages\ManageServiceSteps;
use App\Filament\Support\CmsTable;
use App\Models\ServiceStep;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ServiceStepResource extends Resource
{
    protected static ?string $model = ServiceStep::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static string|UnitEnum|null $navigationGroup = 'Beranda';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'langkah layanan';

    protected static ?string $pluralModelLabel = 'Alur Layanan';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Judul langkah')->required()->maxLength(255),
            Textarea::make('description')->label('Deskripsi')->required()->rows(3),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('title')->label('Judul langkah')->searchable(),
            TextColumn::make('description')->label('Deskripsi')->limit(70),
            CmsTable::activeColumn(),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageServiceSteps::route('/')];
    }
}
