<?php

namespace App\Filament\Resources\PostCategories;

use App\Filament\Resources\PostCategories\Pages\ManagePostCategories;
use App\Filament\Support\CmsTable;
use App\Models\PostCategory;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class PostCategoryResource extends Resource
{
    protected static ?string $model = PostCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'kategori pengumuman';

    protected static ?string $pluralModelLabel = 'Kategori Pengumuman';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set, $get) => filled($get('slug')) ? null : $set('slug', Str::slug((string) $state))),
            TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true)->maxLength(255),
            CmsTable::sortInput(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return CmsTable::configure($table, [
            TextColumn::make('name')->label('Nama')->searchable(),
            TextColumn::make('slug')->label('Slug'),
            TextColumn::make('posts_count')->label('Jumlah pengumuman')->counts('posts'),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManagePostCategories::route('/')];
    }
}
