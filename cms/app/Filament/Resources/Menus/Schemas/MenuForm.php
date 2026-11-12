<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama menu')
                ->required()
                ->maxLength(255)
                ->helperText('Untuk kolom footer (Profil, Layanan, Tautan), nama ini menjadi judul kolom.'),
            TextInput::make('slug')
                ->label('Kode menu')
                ->required()
                ->unique(ignoreRecord: true)
                ->disabled(fn (?object $record) => $record !== null)
                ->dehydrated()
                ->helperText('Dipakai oleh template: topbar, header, mobile, footer_profil, footer_layanan, footer_tautan, footer_legal.'),
            Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(2);
    }
}
