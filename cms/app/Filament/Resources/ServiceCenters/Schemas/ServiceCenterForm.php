<?php

namespace App\Filament\Resources\ServiceCenters\Schemas;

use App\Filament\Support\CmsTable;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ServiceCenterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Nama pusat')->required()->maxLength(255)->columnSpanFull(),
            TextInput::make('badge')->label('Lencana')->required()->placeholder('PUSAT 01')->maxLength(50),
            CmsTable::iconInput()->default('fa-solid fa-flask-vial'),
            Repeater::make('features')
                ->label('Daftar layanan')
                ->simple(TextInput::make('text')->label('Layanan')->required()->maxLength(255))
                ->reorderable()
                ->addActionLabel('Tambah layanan')
                ->columnSpanFull(),
            TextInput::make('link_label')->label('Teks tautan')->default('Selengkapnya')->required(),
            CmsTable::urlInput('link_url', 'Tujuan tautan'),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ])->columns(2);
    }
}
