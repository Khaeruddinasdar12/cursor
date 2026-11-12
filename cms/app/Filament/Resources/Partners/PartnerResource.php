<?php

namespace App\Filament\Resources\Partners;

use App\Filament\Resources\Partners\Pages\ManagePartners;
use App\Filament\Support\CmsTable;
use App\Models\Partner;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'Beranda';

    protected static ?int $navigationSort = 7;

    protected static ?string $modelLabel = 'mitra';

    protected static ?string $pluralModelLabel = 'Kemitraan';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('name')->label('Nama mitra')->required()->rows(2)
                ->helperText('Tekan Enter untuk memecah teks menjadi dua baris, seperti pada tampilan awal.'),
            FileUpload::make('logo')->label('Logo (opsional)')->image()->imageEditor()->disk('public')->directory('partners')->maxSize(2048)
                ->helperText('Jika diisi, logo ditampilkan menggantikan teks nama.'),
            TextInput::make('url')->label('Tautan (opsional)')->maxLength(255),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CmsTable::configure($table, [
            ImageColumn::make('logo')->label('Logo')->disk('public')->height(32),
            TextColumn::make('name')->label('Nama')->formatStateUsing(fn ($state) => str_replace("\n", ' ', $state))->searchable(),
            CmsTable::activeColumn(),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManagePartners::route('/')];
    }
}
