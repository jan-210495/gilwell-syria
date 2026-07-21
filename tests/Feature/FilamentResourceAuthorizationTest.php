<?php

namespace Tests\Feature;

use App\Enums\PublishStatus;
use App\Enums\UserRole;
use App\Filament\Resources\PageResource;
use App\Filament\Resources\SiteSettingResource;
use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentResourceAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admins_can_create_edit_and_delete_publishable_cms_records(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin]);
        $publishedPage = Page::factory()->published()->create();

        $this->actingAs($admin);

        $this->assertTrue(PageResource::canCreate());
        $this->assertTrue(PageResource::canEdit($publishedPage));
        $this->assertTrue(PageResource::canDelete($publishedPage));
        $this->assertTrue(PageResource::canDeleteAny());
    }

    public function test_editors_can_create_and_only_edit_draft_publishable_cms_records(): void
    {
        $editor = User::factory()->create(['role' => UserRole::Editor]);
        $draftPage = Page::factory()->create([
            'status' => PublishStatus::Draft,
            'published_at' => null,
        ]);
        $pendingPage = Page::factory()->create([
            'status' => PublishStatus::PendingReview,
            'published_at' => null,
        ]);
        $publishedPage = Page::factory()->published()->create();

        $this->actingAs($editor);

        $this->assertTrue(PageResource::canCreate());
        $this->assertTrue(PageResource::canEdit($draftPage));
        $this->assertFalse(PageResource::canEdit($pendingPage));
        $this->assertFalse(PageResource::canEdit($publishedPage));
        $this->assertFalse(PageResource::canDelete($draftPage));
        $this->assertFalse(PageResource::canDeleteAny());
    }

    public function test_site_settings_allow_editor_edits_but_only_admin_deletes(): void
    {
        $editor = User::factory()->create(['role' => UserRole::Editor]);
        $admin = User::factory()->create(['role' => UserRole::Admin]);
        $settings = SiteSetting::factory()->create();

        $this->actingAs($editor);

        $this->assertTrue(SiteSettingResource::canCreate());
        $this->assertTrue(SiteSettingResource::canEdit($settings));
        $this->assertFalse(SiteSettingResource::canDelete($settings));
        $this->assertFalse(SiteSettingResource::canDeleteAny());

        $this->actingAs($admin);

        $this->assertTrue(SiteSettingResource::canCreate());
        $this->assertTrue(SiteSettingResource::canEdit($settings));
        $this->assertTrue(SiteSettingResource::canDelete($settings));
        $this->assertTrue(SiteSettingResource::canDeleteAny());
    }
}
