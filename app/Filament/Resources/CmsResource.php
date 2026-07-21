<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

abstract class CmsResource extends Resource
{
    public static function canViewAny(): bool
    {
        return static::currentCmsUser() instanceof User;
    }

    public static function canView(Model $record): bool
    {
        return static::currentCmsUser() instanceof User;
    }

    public static function canCreate(): bool
    {
        return static::currentCmsUser() instanceof User;
    }

    public static function canEdit(Model $record): bool
    {
        $user = static::currentCmsUser();

        if (! $user instanceof User) {
            return false;
        }

        if (method_exists($record, 'canBeEditedBy')) {
            return $record->canBeEditedBy($user);
        }

        return $user->isAdmin() || $user->isEditor();
    }

    public static function canDelete(Model $record): bool
    {
        return static::currentCmsUser()?->isAdmin() ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return static::currentCmsUser()?->isAdmin() ?? false;
    }

    public static function canForceDelete(Model $record): bool
    {
        return static::canDelete($record);
    }

    public static function canForceDeleteAny(): bool
    {
        return static::canDeleteAny();
    }

    public static function canRestore(Model $record): bool
    {
        return static::currentCmsUser()?->isAdmin() ?? false;
    }

    public static function canRestoreAny(): bool
    {
        return static::currentCmsUser()?->isAdmin() ?? false;
    }

    public static function canReorder(): bool
    {
        return static::currentCmsUser()?->isAdmin() ?? false;
    }

    public static function canReplicate(Model $record): bool
    {
        return static::canCreate();
    }

    protected static function currentCmsUser(): ?User
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return null;
        }

        return $user->isAdmin() || $user->isEditor() ? $user : null;
    }
}
