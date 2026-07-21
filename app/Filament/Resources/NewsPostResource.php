<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsPostResource\Pages;
use App\Models\NewsPost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NewsPostResource extends Resource
{
    protected static ?string $model = NewsPost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static string|UnitEnum|null $navigationGroup = 'CMS';

    protected static ?string $recordTitleAttribute = 'title_en';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                CmsResourceFields::slugField(),
                CmsResourceFields::pathField('image_path', 'Image path'),
                CmsResourceFields::pathField('document_path', 'Document path'),
                CmsResourceFields::titleBodyTabs(),
                CmsResourceFields::seoSection(),
                CmsResourceFields::publicationSection(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(CmsResourceFields::contentColumns())
            ->defaultSort('published_at', 'desc')
            ->recordActions(CmsResourceFields::recordActions())
            ->toolbarActions(CmsResourceFields::bulkActions());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageNewsPosts::route('/'),
        ];
    }
}
