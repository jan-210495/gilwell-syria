<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'CMS';

    protected static ?string $recordTitleAttribute = 'key';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identity')
                    ->schema([
                        TextInput::make('key')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('site_name_en')
                            ->label('Site name EN')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('site_name_ar')
                            ->label('Site name AR')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('tagline_en')
                            ->label('Tagline EN')
                            ->maxLength(255),
                        TextInput::make('tagline_ar')
                            ->label('Tagline AR')
                            ->maxLength(255),
                    ])
                    ->columns(2),
                Section::make('Contact')
                    ->schema([
                        TextInput::make('contact_email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('contact_phone')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('whatsapp_phone')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('partnership_email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('office_hours_en')
                            ->label('Office hours EN')
                            ->maxLength(255),
                        TextInput::make('office_hours_ar')
                            ->label('Office hours AR')
                            ->maxLength(255),
                        Textarea::make('address_en')
                            ->label('Address EN')
                            ->rows(3),
                        Textarea::make('address_ar')
                            ->label('Address AR')
                            ->rows(3),
                    ])
                    ->columns(2),
                Section::make('Links')
                    ->schema([
                        TextInput::make('map_url')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('facebook_url')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('instagram_url')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('youtube_url')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('site_name_en')
                    ->label('Site name EN')
                    ->searchable(),
                TextColumn::make('site_name_ar')
                    ->label('Site name AR')
                    ->searchable(),
                TextColumn::make('contact_email')
                    ->searchable(),
            ])
            ->recordActions(CmsResourceFields::recordActions())
            ->toolbarActions(CmsResourceFields::bulkActions());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSiteSettings::route('/'),
        ];
    }
}
