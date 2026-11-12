<?php

namespace App\Filament\Resources\Publications\Schemas;

use App\Filament\Support\CmsTable;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PublicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Judul')->required()->maxLength(255),
            TextInput::make('badge')->label('Lencana')->required()->placeholder('JURNAL')->maxLength(50),
            Textarea::make('description')->label('Deskripsi')->required()->rows(3)->columnSpanFull(),
            CmsTable::iconInput(),
            CmsTable::urlInput('url', 'Tautan (opsional)')->default(null),
            CmsTable::iconInput('meta_icon', 'Ikon baris bawah'),
            TextInput::make('meta_label')->label('Label baris bawah (kiri)')->maxLength(255),
            TextInput::make('meta_value')->label('Nilai baris bawah (kanan, emas)')->maxLength(255),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ])->columns(2);
    }
}
