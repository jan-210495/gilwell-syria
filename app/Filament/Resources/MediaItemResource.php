<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaItemResource\Pages;
use App\Models\MediaItem;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class MediaItemResource extends Resource
{
    protected static ?string $model = MediaItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFilm;

    protected static string|UnitEnum|null $navigationGroup = 'CMS';

    protected static ?string $recordTitleAttribute = 'title_en';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Media')
                    ->schema([
                        Select::make('gallery_album_id')
                            ->relationship('galleryAlbum', 'title_en')
                            ->searchable()
                            ->preload(),
                        CmsResourceFields::mediaTypeSelect(),
                        TextInput::make('path')
                            ->required()
                            ->maxLength(255),
                        CmsResourceFields::pathField('thumbnail_path', 'Thumbnail path'),
                    ])
                    ->columns(2),
                Section::make('Bilingual metadata')
                    ->schema([
                        TextInput::make('title_en')
                            ->label('Title EN')
                            ->maxLength(255),
                        TextInput::make('title_ar')
                            ->label('Title AR')
                            ->maxLength(255),
                        TextInput::make('alt_text_en')
                            ->label('Alt text EN')
                            ->maxLength(255),
                        TextInput::make('alt_text_ar')
                            ->label('Alt text AR')
                            ->maxLength(255),
                        Textarea::make('caption_en')
                            ->label('Caption EN')
                            ->rows(3),
                        Textarea::make('caption_ar')
                            ->label('Caption AR')
                            ->rows(3),
                    ])
                    ->columns(2),
                CmsResourceFields::publicationSection(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title_en')
                    ->label('Title EN')
                    ->searchable()
                    ->limit(35),
                TextColumn::make('galleryAlbum.title_en')
                    ->label('Album')
                    ->sortable(),
                TextColumn::make('media_type')
                    ->badge()
                    ->sortable(),
                CmsResourceFields::statusColumn(),
                TextColumn::make('sort_order')
                    ->label('Sort')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->recordActions(CmsResourceFields::recordActions())
            ->toolbarActions(CmsResourceFields::bulkActions());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMediaItems::route('/'),
        ];
    }
}
