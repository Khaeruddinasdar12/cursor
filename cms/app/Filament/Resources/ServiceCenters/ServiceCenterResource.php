<?php

namespace App\Filament\Resources\ServiceCenters;

use App\Filament\Resources\ServiceCenters\Pages\CreateServiceCenter;
use App\Filament\Resources\ServiceCenters\Pages\EditServiceCenter;
use App\Filament\Resources\ServiceCenters\Pages\ListServiceCenters;
use App\Filament\Resources\ServiceCenters\Schemas\ServiceCenterForm;
use App\Filament\Resources\ServiceCenters\Tables\ServiceCentersTable;
use App\Models\ServiceCenter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ServiceCenterResource extends Resource
{
    protected static ?string $model = ServiceCenter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Beranda';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'pusat layanan';

    protected static ?string $pluralModelLabel = 'Pusat Layanan';

    public static function form(Schema $schema): Schema
    {
        return ServiceCenterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceCentersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServiceCenters::route('/'),
            'create' => CreateServiceCenter::route('/create'),
            'edit' => EditServiceCenter::route('/{record}/edit'),
        ];
    }
}
