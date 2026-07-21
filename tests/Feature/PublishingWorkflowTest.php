<?php

namespace Tests\Feature;

use App\Enums\PublishStatus;
use App\Enums\UserRole;
use App\Models\Page;
use App\Models\User;
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
}
