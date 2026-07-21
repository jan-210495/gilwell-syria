<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class EventResource extends CmsResource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

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
                Section::make('Schedule and location')
                    ->schema([
                        DateTimePicker::make('starts_at'),
                        DateTimePicker::make('ends_at'),
                        TextInput::make('location_en')
                            ->label('Location EN')
                            ->maxLength(255),
                        TextInput::make('location_ar')
                            ->label('Location AR')
                            ->maxLength(255),
                    ])
                    ->columns(2),
                CmsResourceFields::seoSection(),
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
                    ->sortable()
                    ->limit(45),
                TextColumn::make('title_ar')
                    ->label('Title AR')
                    ->searchable()
                    ->limit(45),
                TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                CmsResourceFields::statusColumn(),
            ])
            ->defaultSort('starts_at')
            ->recordActions(CmsResourceFields::recordActions())
            ->toolbarActions(CmsResourceFields::bulkActions());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEvents::route('/'),
        ];
    }
}
