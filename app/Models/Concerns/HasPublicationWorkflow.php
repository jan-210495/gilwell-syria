<?php

namespace App\Models\Concerns;

use App\Enums\PublishStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasPublicationWorkflow
{
    public static function bootHasPublicationWorkflow(): void
    {
        static::creating(function (Model $model): void {
            if ($model->status === null) {
                $model->status = PublishStatus::Draft;
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function publishableCasts(): array
    {
        return [
            'status' => PublishStatus::class,
            'published_at' => 'datetime',
        ];
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', PublishStatus::Published->value)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isPublished(): bool
    {
        return $this->status === PublishStatus::Published
            && $this->published_at !== null
            && $this->published_at->lte(now());
    }

    public function canBeEditedBy(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEditor() && $this->status === PublishStatus::Draft;
    }

    public function canBeSubmittedForReviewBy(User $user): bool
    {
        return ($user->isAdmin() || $user->isEditor())
            && $this->status === PublishStatus::Draft;
    }

    public function canBePublishedBy(User $user): bool
    {
        return $user->isAdmin();
    }

    public function submitForReview(User $user): bool
    {
        if (! $this->canBeSubmittedForReviewBy($user)) {
            return false;
        }

        $this->status = PublishStatus::PendingReview;

        return $this->save();
    }

    public function publish(User $user): bool
    {
        if (! $this->canBePublishedBy($user)) {
            return false;
        }

        $this->status = PublishStatus::Published;
        $this->published_at ??= now();

        return $this->save();
    }

    public function archive(User $user): bool
    {
        if (! $user->isAdmin()) {
            return false;
        }

        $this->status = PublishStatus::Archived;

        return $this->save();
    }

    public function markDraft(User $user): bool
    {
        if (! ($user->isAdmin() || $user->isEditor())) {
            return false;
        }

        $this->status = PublishStatus::Draft;
        $this->published_at = null;

        return $this->save();
    }
}
