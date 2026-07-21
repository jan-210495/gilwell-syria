<?php

namespace Tests\Feature;

use App\Enums\PublishStatus;
use App\Enums\UserRole;
use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishingWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_editors_can_submit_drafts_but_cannot_publish(): void
    {
        $editor = User::factory()->create(['role' => UserRole::Editor]);
        $page = Page::factory()->create([
            'status' => PublishStatus::Draft,
            'published_at' => null,
        ]);

        $this->assertTrue($page->submitForReview($editor));
        $this->assertSame(PublishStatus::PendingReview, $page->refresh()->status);

        $this->assertFalse($page->publish($editor));
        $this->assertSame(PublishStatus::PendingReview, $page->refresh()->status);
        $this->assertNull($page->published_at);
    }

    public function test_admins_can_publish_and_archive_content(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin]);
        $page = Page::factory()->create([
            'status' => PublishStatus::PendingReview,
            'published_at' => null,
        ]);

        $this->assertTrue($page->publish($admin));

        $page->refresh();
        $this->assertSame(PublishStatus::Published, $page->status);
        $this->assertNotNull($page->published_at);
        $this->assertTrue(Page::published()->whereKey($page)->exists());

        $this->assertTrue($page->archive($admin));
        $this->assertSame(PublishStatus::Archived, $page->refresh()->status);
        $this->assertFalse(Page::published()->whereKey($page)->exists());
    }

    public function test_published_content_without_published_at_is_normalized_on_save(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin]);
        $page = Page::factory()->create([
            'status' => PublishStatus::Draft,
            'published_at' => null,
        ]);

        $this->actingAs($admin);

        $page->status = PublishStatus::Published;
        $page->published_at = null;
        $page->save();

        $page->refresh();

        $this->assertSame(PublishStatus::Published, $page->status);
        $this->assertNotNull($page->published_at);
        $this->assertTrue(Page::published()->whereKey($page)->exists());
    }

    public function test_draft_content_clears_published_at_on_save(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin]);
        $page = Page::factory()->published()->create();

        $this->actingAs($admin);

        $page->status = PublishStatus::Draft;
        $page->save();

        $this->assertNull($page->refresh()->published_at);
        $this->assertFalse(Page::published()->whereKey($page)->exists());
    }

    public function test_editors_cannot_save_published_or_archived_statuses(): void
    {
        $editor = User::factory()->create(['role' => UserRole::Editor]);

        $this->actingAs($editor);

        foreach ([PublishStatus::Published, PublishStatus::Archived] as $status) {
            $page = Page::factory()->create([
                'status' => PublishStatus::Draft,
                'published_at' => null,
            ]);

            $page->status = $status;

            try {
                $page->save();
                $this->fail("Editor saved forbidden {$status->value} status.");
            } catch (AuthorizationException) {
                $this->assertSame(PublishStatus::Draft, $page->refresh()->status);
            }
        }
    }

    public function test_editors_cannot_update_existing_non_draft_content(): void
    {
        $editor = User::factory()->create(['role' => UserRole::Editor]);
        $page = Page::factory()->create([
            'status' => PublishStatus::PendingReview,
            'published_at' => null,
        ]);

        $this->actingAs($editor);

        $page->status = PublishStatus::Draft;
        $page->summary_en = 'Attempted editor update after submission.';

        $this->expectException(AuthorizationException::class);

        $page->save();
    }
}
