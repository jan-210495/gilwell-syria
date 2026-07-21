<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PartnerResource extends CmsResource
{
    protected static ?string $model = Partner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'CMS';

    protected static ?string $recordTitleAttribute = 'name_en';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Partner')
                    ->schema([
                        CmsResourceFields::slugField(),
                        TextInput::make('name_en')
                            ->label('Name EN')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name_ar')
                            ->label('Name AR')
                            ->required()
                            ->maxLength(255),
                        CmsResourceFields::pathField('logo_path', 'Logo path'),
                        TextInput::make('website_url')
                            ->url()
                            ->maxLength(255),
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
            ->columns([
                TextColumn::make('name_en')
                    ->label('Name EN')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_ar')
                    ->label('Name AR')
                    ->searchable(),
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
            'index' => Pages\ManagePartners::route('/'),
        ];
    }
}
