<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

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
            'index' => Pages\ManagePrograms::route('/'),
        ];
    }
}
