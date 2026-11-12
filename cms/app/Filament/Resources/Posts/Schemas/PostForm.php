<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Isi pengumuman')
                ->columnSpan(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set, $get) => filled($get('slug')) ? null : $set('slug', Str::slug((string) $state))),
                    TextInput::make('slug')
                        ->label('Slug (alamat URL)')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    Textarea::make('excerpt')
                        ->label('Ringkasan')
                        ->rows(3)
                        ->helperText('Tampil pada kartu pengumuman di beranda.'),
                    RichEditor::make('content')
                        ->label('Isi')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('posts/attachments')
                        ->columnSpanFull(),
                ]),
            Section::make('Pengaturan')
                ->columnSpan(1)
                ->schema([
                    Toggle::make('is_published')->label('Terbitkan')->default(true),
                    DatePicker::make('published_at')->label('Tanggal terbit')->default(now())->native(false)->displayFormat('d F Y'),
                    Select::make('post_category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')->label('Nama')->required(),
                            TextInput::make('slug')->label('Slug')->required()->unique('post_categories', 'slug'),
                        ]),
                    FileUpload::make('image')
                        ->label('Gambar sampul')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('posts')
                        ->maxSize(4096),
                ]),
        ])->columns(3);
    }
}
