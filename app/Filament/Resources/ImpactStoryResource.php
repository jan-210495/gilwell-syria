<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImpactStoryResource\Pages;
use App\Models\ImpactStory;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ImpactStoryResource extends CmsResource
{
    protected static ?string $model = ImpactStory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'CMS';

    protected static ?string $recordTitleAttribute = 'title_en';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                CmsResourceFields::slugField(),
                CmsResourceFields::pathField('image_path', 'Image path'),
                CmsResourceFields::titleBodyTabs(),
                CmsResourceFields::seoSection(),
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
            'index' => Pages\ManageImpactStories::route('/'),
        ];
    }
}
