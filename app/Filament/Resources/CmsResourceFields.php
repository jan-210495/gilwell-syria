<?php

namespace App\Filament\Resources;

use App\Enums\MediaType;
use App\Enums\PublishStatus;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CmsResourceFields
{
    public static function slugField(): TextInput
    {
        return TextInput::make('slug')
            ->required()
            ->maxLength(255);
    }

    public static function sortField(): TextInput
    {
        return TextInput::make('sort_order')
            ->numeric()
            ->default(0);
    }

    public static function pathField(string $name, string $label): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->maxLength(255);
    }

    public static function titleBodyTabs(): Tabs
    {
        return Tabs::make('Bilingual content')
            ->tabs([
                Tab::make('English')
                    ->schema([
                        TextInput::make('title_en')
                            ->label('Title')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('summary_en')
                            ->label('Summary')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('body_en')
                            ->label('Body')
                            ->rows(8)
                            ->columnSpanFull(),
                    ]),
                Tab::make('Arabic')
                    ->schema([
                        TextInput::make('title_ar')
                            ->label('Title')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('summary_ar')
                            ->label('Summary')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('body_ar')
                            ->label('Body')
                            ->rows(8)
                            ->columnSpanFull(),
                    ]),
            ])
            ->columnSpanFull();
    }

    public static function seoSection(): Section
    {
        return Section::make('SEO')
            ->schema([
                TextInput::make('seo_title_en')
                    ->label('SEO title EN')
                    ->maxLength(255),
                TextInput::make('seo_title_ar')
                    ->label('SEO title AR')
                    ->maxLength(255),
                Textarea::make('seo_description_en')
                    ->label('SEO description EN')
                    ->rows(3),
                Textarea::make('seo_description_ar')
                    ->label('SEO description AR')
                    ->rows(3),
            ])
            ->columns(2)
            ->columnSpanFull();
    }

    public static function publicationSection(): Section
    {
        return Section::make('Publication')
            ->schema([
                Select::make('status')
                    ->options(fn (): array => self::statusOptionsForCurrentUser())
                    ->default(PublishStatus::Draft->value)
                    ->required()
                    ->native(false),
                DateTimePicker::make('published_at')
                    ->disabled(fn (): bool => ! self::currentUser()?->isAdmin()),
                self::sortField(),
            ])
            ->columns(3)
            ->columnSpanFull();
    }

    /**
     * @return array<string, string>
     */
    public static function statusOptionsForCurrentUser(): array
    {
        if (self::currentUser()?->isAdmin()) {
            return PublishStatus::options();
        }

        return [
            PublishStatus::Draft->value => PublishStatus::Draft->label(),
            PublishStatus::PendingReview->value => PublishStatus::PendingReview->label(),
        ];
    }

    public static function mediaTypeSelect(): Select
    {
        return Select::make('media_type')
            ->options(MediaType::options())
            ->default(MediaType::Image->value)
            ->required()
            ->native(false);
    }

    /**
     * @return array<int, TextColumn>
     */
    public static function contentColumns(string $titleColumn = 'title_en'): array
    {
        return [
            TextColumn::make($titleColumn)
                ->label('Title EN')
                ->searchable()
                ->sortable()
                ->limit(45),
            TextColumn::make('title_ar')
                ->label('Title AR')
                ->searchable()
                ->limit(45),
            self::statusColumn(),
            TextColumn::make('sort_order')
                ->label('Sort')
                ->sortable(),
            TextColumn::make('published_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function statusColumn(): TextColumn
    {
        return TextColumn::make('status')
            ->badge()
            ->formatStateUsing(fn (mixed $state): ?string => self::statusLabel($state))
            ->color(fn (mixed $state): string => self::statusColor($state))
            ->sortable();
    }

    /**
     * @return array<int, EditAction|DeleteAction>
     */
    public static function recordActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn (Model $record): bool => self::canEditRecord($record)),
            DeleteAction::make()
                ->visible(fn (): bool => self::currentUser()?->isAdmin() ?? false),
        ];
    }

    /**
     * @return array<int, BulkActionGroup>
     */
    public static function bulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make()
                    ->visible(fn (): bool => self::currentUser()?->isAdmin() ?? false),
            ]),
        ];
    }

    private static function currentUser(): ?User
    {
        $user = Auth::user();

        return $user instanceof User ? $user : null;
    }

    private static function canEditRecord(Model $record): bool
    {
        $user = self::currentUser();

        if (! $user instanceof User) {
            return false;
        }

        if (method_exists($record, 'canBeEditedBy')) {
            return $record->canBeEditedBy($user);
        }

        return $user->isAdmin() || $user->isEditor();
    }

    private static function statusLabel(mixed $state): ?string
    {
        if ($state instanceof PublishStatus) {
            return $state->label();
        }

        if (is_string($state)) {
            return PublishStatus::tryFrom($state)?->label() ?? $state;
        }

        return null;
    }

    private static function statusColor(mixed $state): string
    {
        $value = $state instanceof PublishStatus ? $state->value : (string) $state;

        return match ($value) {
            PublishStatus::Published->value => 'success',
            PublishStatus::PendingReview->value => 'warning',
            PublishStatus::Archived->value => 'gray',
            default => 'info',
        };
    }
}
