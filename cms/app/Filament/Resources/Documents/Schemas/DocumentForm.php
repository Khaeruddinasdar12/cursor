<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Filament\Support\CmsTable;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Arr;
use Illuminate\Support\Number;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Judul')->required()->maxLength(255)->columnSpanFull(),
            TextInput::make('category')
                ->label('Kategori')
                ->required()
                ->maxLength(255)
                ->datalist(['Panduan', 'Formulir', 'Prosedur', 'Template']),
            CmsTable::iconInput()->default('fa-solid fa-file-lines'),
            Textarea::make('description')->label('Deskripsi')->rows(3)->columnSpanFull(),
            FileUpload::make('file')
                ->label('Berkas')
                ->disk('public')
                ->directory('documents')
                ->maxSize(20480)
                ->live()
                ->afterStateUpdated(function ($state, $set) {
                    $file = is_array($state) ? Arr::first($state) : $state;

                    if ($file instanceof TemporaryUploadedFile) {
                        $set('file_type', strtoupper($file->getClientOriginalExtension()));
                        $set('file_size', Number::fileSize($file->getSize(), precision: 1));
                    }
                })
                ->helperText('Tipe dan ukuran berkas terisi otomatis setelah unggah. Kosongkan jika memakai tautan luar.')
                ->columnSpanFull(),
            TextInput::make('url')->label('Atau tautan luar')->maxLength(255)->columnSpanFull(),
            TextInput::make('file_type')->label('Tipe berkas')->placeholder('PDF')->maxLength(20),
            TextInput::make('file_size')->label('Ukuran berkas')->placeholder('1.2 MB')->maxLength(20),
            CmsTable::sortInput(),
            CmsTable::activeToggle(),
        ])->columns(2);
    }
}
