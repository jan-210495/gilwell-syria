<?php

namespace App\Models\Concerns;

use App\Enums\PublishStatus;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasPublicationWorkflow
{
    public static function bootHasPublicationWorkflow(): void
    {
        static::saving(function (Model $model): void {
            $model->normalizePublicationStateForSave();
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

    private function normalizePublicationStateForSave(): void
    {
        if ($this->status === null) {
            $this->status = PublishStatus::Draft;
        }

        $this->authorizeCurrentUserCanSavePublicationStatus();

        if ($this->publicationStatus() === PublishStatus::Published && $this->published_at === null) {
            $this->published_at = now();
        }

        if ($this->publicationStatus() === PublishStatus::Draft) {
            $this->published_at = null;
        }
    }

    private function authorizeCurrentUserCanSavePublicationStatus(): void
    {
        $user = Auth::user();

        if (! $user instanceof User || $user->isAdmin()) {
            return;
        }

        $status = $this->publicationStatus();

        if (in_array($status, [PublishStatus::Published, PublishStatus::Archived], true)) {
            throw new AuthorizationException('Editors may only save draft or pending review CMS content.');
        }

        if ($this->exists && $this->originalPublicationStatus() !== PublishStatus::Draft) {
            throw new AuthorizationException('Editors may only update draft CMS content.');
        }
    }

    private function publicationStatus(): ?PublishStatus
    {
        if ($this->status instanceof PublishStatus) {
            return $this->status;
        }

        if (is_string($this->status)) {
            return PublishStatus::tryFrom($this->status);
        }

        return null;
    }

    private function originalPublicationStatus(): ?PublishStatus
    {
        $status = $this->getOriginal('status');

        if ($status instanceof PublishStatus) {
            return $status;
        }

        if (is_string($status)) {
            return PublishStatus::tryFrom($status);
        }

        return null;
    }
}
