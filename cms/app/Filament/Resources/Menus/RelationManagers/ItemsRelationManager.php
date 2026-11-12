<?php

namespace App\Filament\Resources\Menus\RelationManagers;

use App\Filament\Support\CmsTable;
use App\Models\MenuItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Item menu';

    protected static ?string $modelLabel = 'item menu';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('label')->label('Label')->required()->maxLength(255),
            CmsTable::urlInput('url', 'Tautan')->required(),
            Select::make('parent_id')
                ->label('Induk (submenu dari)')
                ->options(fn (?MenuItem $record) => MenuItem::query()
                    ->where('menu_id', $this->getOwnerRecord()->getKey())
                    ->whereNull('parent_id')
                    ->when($record, fn (Builder $q) => $q->whereKeyNot($record->getKey()))
                    ->orderBy('sort')
                    ->pluck('label', 'id'))
                ->placeholder('— Item tingkat atas —')
                ->helperText('Pilih item induk agar item ini muncul sebagai submenu.'),
            CmsTable::iconInput()->helperText('Dipakai pada submenu dropdown (mis. "fa-solid fa-bullseye").'),
            TextInput::make('group')
                ->label('Judul kelompok (mega menu)')
                ->maxLength(255)
                ->helperText('Isi untuk submenu bergaya mega menu: item dengan judul sama dikelompokkan dalam satu kolom.'),
            TextInput::make('column')->label('Kolom (mega menu, 1–3)')->numeric()->minValue(1)->maxValue(3)->default(1),
            CmsTable::sortInput(),
            Toggle::make('open_in_new_tab')->label('Buka di tab baru')->default(false),
            CmsTable::activeToggle(),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->modifyQueryUsing(fn (Builder $query) => $query->reorder()->orderByRaw(
                'COALESCE((select p.sort from menu_items p where p.id = menu_items.parent_id), menu_items.sort), COALESCE(menu_items.parent_id, menu_items.id), (menu_items.parent_id is not null), menu_items.sort'
            ))
            ->columns([
                TextColumn::make('label')
                    ->label('Label')
                    ->formatStateUsing(fn ($state, MenuItem $record) => ($record->parent_id ? '— ' : '').$state)
                    ->searchable(),
                TextColumn::make('url')->label('Tautan'),
                TextColumn::make('group')->label('Kelompok'),
                TextColumn::make('sort')->label('Urutan'),
                CmsTable::activeColumn(),
            ])
            ->headerActions([CreateAction::make()])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->emptyStateHeading('Belum ada item menu');
    }
}
