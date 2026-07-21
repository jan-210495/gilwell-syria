<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImpactMetricResource\Pages;
use App\Models\ImpactMetric;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ImpactMetricResource extends CmsResource
{
    protected static ?string $model = ImpactMetric::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'CMS';

    protected static ?string $recordTitleAttribute = 'label_en';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Metric')
                    ->schema([
                        TextInput::make('label_en')
                            ->label('Label EN')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('label_ar')
                            ->label('Label AR')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('value')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('unit_en')
                            ->label('Unit EN')
                            ->maxLength(255),
                        TextInput::make('unit_ar')
                            ->label('Unit AR')
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
                TextColumn::make('label_en')
                    ->label('Label EN')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('label_ar')
                    ->label('Label AR')
                    ->searchable(),
                TextColumn::make('value')
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
            'index' => Pages\ManageImpactMetrics::route('/'),
        ];
    }
}
