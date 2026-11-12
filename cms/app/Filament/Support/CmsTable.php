<?php

namespace App\Filament\Support;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CmsTable
{
    /**
     * Konfigurasi tabel standar: kolom, aksi, dan urutan seret-lepas berdasarkan kolom `sort`.
     */
    public static function configure(Table $table, array $columns, array $filters = [], bool $reorderable = true): Table
    {
        $table
            ->columns($columns)
            ->filters($filters)
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada data');

        if ($reorderable) {
            $table->reorderable('sort')->defaultSort('sort');
        }

        return $table;
    }

    public static function activeColumn(string $name = 'is_active', string $label = 'Aktif'): ToggleColumn
    {
        return ToggleColumn::make($name)->label($label);
    }

    public static function activeToggle(string $name = 'is_active', string $label = 'Aktif / tampil di situs'): Toggle
    {
        return Toggle::make($name)->label($label)->default(true);
    }

    public static function sortInput(): TextInput
    {
        return TextInput::make('sort')
            ->label('Urutan')
            ->numeric()
            ->default(0)
            ->helperText('Angka kecil tampil lebih dulu. Urutan juga bisa diubah dengan seret-lepas di tabel.');
    }

    public static function iconInput(string $name = 'icon', string $label = 'Ikon (Font Awesome)'): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->placeholder('fa-solid fa-file-lines')
            ->helperText('Kelas ikon Font Awesome 6, misalnya "fa-solid fa-bullseye" atau "fa-brands fa-youtube".');
    }

    public static function urlInput(string $name = 'url', string $label = 'Tautan'): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->default('#')
            ->helperText('Alamat lengkap (https://…), jalur internal (/pengumuman), atau jangkar (#dokumen).');
    }
}
