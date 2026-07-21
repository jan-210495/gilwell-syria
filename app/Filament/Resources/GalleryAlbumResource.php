<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryAlbumResource\Pages;
use App\Models\GalleryAlbum;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GalleryAlbumResource extends Resource
{
    protected static ?string $model = GalleryAlbum::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'CMS';

    protected static ?string $recordTitleAttribute = 'title_en';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Album')
                    ->schema([
                        CmsResourceFields::slugField(),
                        TextInput::make('title_en')
                            ->label('Title EN')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title_ar')
                            ->label('Title AR')
                            ->required()
                            ->maxLength(255),
                        CmsResourceFields::pathField('cover_image_path', 'Cover image path'),
                        Textarea::make('description_en')
                            ->label('Description EN')
                            ->rows(3),
                        Textarea::make('description_ar')
                            ->label('Description AR')
                            ->rows(3),
                    ])
                    ->columns(2),
                CmsResourceFields::publicationSection(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(CmsResourceFields::contentColumns())
            ->defaultSort('sort_order')
            ->recordActions(CmsResourceFields::recordActions())
            ->toolbarActions(CmsResourceFields::bulkActions());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGalleryAlbums::route('/'),
        ];
    }
}
