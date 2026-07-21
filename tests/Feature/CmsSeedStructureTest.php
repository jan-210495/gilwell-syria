<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\ImpactMetric;
use App\Models\MediaItem;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Program;
use App\Models\SiteSetting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsSeedStructureTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_default_admin_and_editor(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@gilwellsyria.local',
            'role' => 'admin',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'editor@gilwellsyria.local',
            'role' => 'editor',
        ]);
    }

    public function test_database_seeder_creates_bilingual_starter_content(): void
    {
        $this->seed(DatabaseSeeder::class);

        $settings = SiteSetting::query()->where('key', 'main')->firstOrFail();

        $this->assertSame('info@gilwellsyria.local', $settings->contact_email);
        $this->assertSame('partnerships@gilwellsyria.local', $settings->partnership_email);

        foreach (['home', 'about', 'programs', 'impact', 'partners', 'gallery', 'news', 'events', 'contact'] as $slug) {
            $page = Page::query()->where('slug', $slug)->firstOrFail();

            $this->assertNotEmpty($page->title_en);
            $this->assertNotEmpty($page->title_ar);
            $this->assertNotEmpty($page->summary_en);
            $this->assertNotEmpty($page->summary_ar);
            $this->assertNotEmpty($page->body_en);
            $this->assertNotEmpty($page->body_ar);
            $this->assertTrue($page->isPublished());
        }

        $this->assertGreaterThanOrEqual(1, Program::query()->count());
        $this->assertGreaterThanOrEqual(1, ImpactMetric::query()->count());
        $this->assertGreaterThanOrEqual(1, Partner::query()->count());
        $this->assertGreaterThanOrEqual(1, GalleryAlbum::query()->count());
        $this->assertGreaterThanOrEqual(1, MediaItem::query()->count());
        $this->assertGreaterThanOrEqual(1, NewsPost::query()->count());
        $this->assertGreaterThanOrEqual(1, Event::query()->count());
    }
}
