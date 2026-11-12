<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Nama kegiatan')->required()->maxLength(255)->columnSpanFull(),
            DatePicker::make('event_date')->label('Tanggal')->required()->native(false)->displayFormat('d F Y'),
            TextInput::make('time')->label('Waktu')->placeholder('09.00 WITA')->maxLength(255),
            TextInput::make('location')->label('Tempat')->placeholder('Aula LPPM IAIN Bone')->maxLength(255)->columnSpanFull(),
            Textarea::make('description')->label('Keterangan (opsional)')->rows(3)->columnSpanFull(),
            Toggle::make('is_published')->label('Tampil di situs')->default(true),
        ])->columns(2);
    }
}
