<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\MediaItem;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Program;
use App\Models\SiteSetting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_english_home_and_invalid_locales_404(): void
    {
        $this->get('/')->assertRedirect('/en');

        $this->get('/fr')->assertNotFound();
        $this->get('/fr/programs')->assertNotFound();
    }

    public function test_home_renders_locale_language_direction_and_seeded_cms_content(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/en')
            ->assertOk()
            ->assertSee('lang="en"', false)
            ->assertSee('dir="ltr"', false)
            ->assertSee('Training young leaders for service across Syria.')
            ->assertSee('Leadership Training')
            ->assertSee('Youth reached')
            ->assertSee('Community Partner')
            ->assertSee('Field Activities')
            ->assertSee('New training cycle opens')
            ->assertSee('Introductory Open Day');

        $this->get('/ar')
            ->assertOk()
            ->assertSee('lang="ar"', false)
            ->assertSee('dir="rtl"', false)
            ->assertSee('تدريب قادة شباب للخدمة في سوريا.')
            ->assertSee('التدريب القيادي')
            ->assertSee('الشباب المستفيدون');
    }

    public function test_home_uses_visual_reset_hero_and_wide_section_hooks(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/en')
            ->assertOk()
            ->assertSee('class="home-hero home-hero--editorial"', false)
            ->assertSee('images/gilwellsyria-hero-training.png')
            ->assertSee('<h1>GilwellSyria</h1>', false)
            ->assertDontSee('<h1>Home</h1>', false)
            ->assertSee('class="credibility-strip"', false)
            ->assertSee('class="section section--program-feature"', false)
            ->assertSee('class="section section--partner-wall"', false)
            ->assertSee('class="section section--content-feed"', false);

        $this->get('/ar')
            ->assertOk()
            ->assertSee('class="home-hero home-hero--editorial"', false)
            ->assertSee('<h1>جيلويل سوريا</h1>', false)
            ->assertDontSee('<h1>الرئيسية</h1>', false);
    }

    public function test_home_preloads_and_serves_optimized_hero_with_png_fallback(): void
    {
        $this->seed(DatabaseSeeder::class);

        $optimizedHero = public_path('images/gilwellsyria-hero-training.webp');
        $sourceHero = public_path('images/gilwellsyria-hero-training.png');

        $this->assertFileExists($optimizedHero);
        $this->assertLessThan(filesize($sourceHero), filesize($optimizedHero));

        $this->get('/en')
            ->assertOk()
            ->assertSee('<link rel="preload" as="image"', false)
            ->assertSee('gilwellsyria-hero-training.webp')
            ->assertSee('image-set(', false)
            ->assertSee('gilwellsyria-hero-training.png');
    }

    public function test_core_pages_render_published_cms_records_and_hide_drafts(): void
    {
        $this->createMainSettings();
        Page::factory()->published()->create([
            'slug' => 'about',
            'title_en' => 'About Published Page',
            'body_en' => 'Published about body from CMS.',
        ]);
        Page::factory()->create([
            'slug' => 'about-draft',
            'title_en' => 'Hidden Draft Page',
            'body_en' => 'Draft body should not render.',
        ]);

        $program = Program::factory()->published()->create([
            'slug' => 'published-program',
            'title_en' => 'Published Program',
            'body_en' => 'Published program detail body.',
        ]);
        Program::factory()->create([
            'slug' => 'draft-program',
            'title_en' => 'Hidden Draft Program',
        ]);

        $album = GalleryAlbum::factory()->published()->create([
            'slug' => 'published-album',
            'title_en' => 'Published Album',
        ]);
        GalleryAlbum::factory()->create([
            'slug' => 'draft-album',
            'title_en' => 'Hidden Draft Album',
        ]);
        MediaItem::factory()->published()->create([
            'gallery_album_id' => $album->id,
            'title_en' => 'Published Gallery Image',
            'caption_en' => 'Published gallery caption.',
        ]);
        MediaItem::factory()->create([
            'gallery_album_id' => $album->id,
            'title_en' => 'Hidden Draft Gallery Image',
        ]);

        $post = NewsPost::factory()->published()->create([
            'slug' => 'published-news',
            'title_en' => 'Published News',
            'body_en' => 'Published news detail body.',
        ]);
        NewsPost::factory()->create([
            'slug' => 'draft-news',
            'title_en' => 'Hidden Draft News',
        ]);

        $event = Event::factory()->published()->create([
            'slug' => 'published-event',
            'title_en' => 'Published Event',
            'body_en' => 'Published event detail body.',
        ]);
        Event::factory()->create([
            'slug' => 'draft-event',
            'title_en' => 'Hidden Draft Event',
        ]);

        $this->get('/en/about')
            ->assertOk()
            ->assertSee('About Published Page')
            ->assertSee('Published about body from CMS.')
            ->assertDontSee('Hidden Draft Page');

        $this->get('/en/programs')
            ->assertOk()
            ->assertSee('Published Program')
            ->assertDontSee('Hidden Draft Program');
        $this->get("/en/programs/{$program->slug}")
            ->assertOk()
            ->assertSee('Published program detail body.');
        $this->get('/en/programs/draft-program')->assertNotFound();

        $this->get('/en/gallery')
            ->assertOk()
            ->assertSee('Published Album')
            ->assertDontSee('Hidden Draft Album');
        $this->get("/en/gallery/{$album->slug}")
            ->assertOk()
            ->assertSee('Published Gallery Image')
            ->assertSee('Published gallery caption.')
            ->assertDontSee('Hidden Draft Gallery Image');
        $this->get('/en/gallery/draft-album')->assertNotFound();

        $this->get('/en/news')
            ->assertOk()
            ->assertSee('Published News')
            ->assertDontSee('Hidden Draft News');
        $this->get("/en/news/{$post->slug}")
            ->assertOk()
            ->assertSee('Published news detail body.');
        $this->get('/en/news/draft-news')->assertNotFound();

        $this->get('/en/events')
            ->assertOk()
            ->assertSee('Published Event')
            ->assertDontSee('Hidden Draft Event');
        $this->get("/en/events/{$event->slug}")
            ->assertOk()
            ->assertSee('Published event detail body.');
        $this->get('/en/events/draft-event')->assertNotFound();
    }

    public function test_empty_listing_pages_have_public_empty_states(): void
    {
        $this->createMainSettings();

        $this->get('/en/programs')->assertOk()->assertSee('No published programs yet.');
        $this->get('/en/impact')->assertOk()->assertSee('No published impact updates yet.');
        $this->get('/en/partners')->assertOk()->assertSee('No published partners yet.');
        $this->get('/en/gallery')->assertOk()->assertSee('No published albums yet.');
        $this->get('/en/news')->assertOk()->assertSee('No published news yet.');
        $this->get('/en/events')->assertOk()->assertSee('No published events or trainings yet.');
    }

    public function test_listing_and_contact_pages_use_visual_reset_hooks(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/en/programs')
            ->assertOk()
            ->assertSee('class="section section--listing"', false)
            ->assertSee('class="card-grid card-grid--featured"', false)
            ->assertSee('class="page-hero page-hero--substantial"', false);

        $this->get('/en/gallery')
            ->assertOk()
            ->assertSee('class="card-grid card-grid--compact"', false);

        $this->get('/en/news')
            ->assertOk()
            ->assertSee('class="card-grid card-grid--compact"', false);

        $this->get('/en/events')
            ->assertOk()
            ->assertSee('class="card-grid card-grid--compact"', false);

        $this->get('/en/partners')
            ->assertOk()
            ->assertSee('class="logo-grid logo-grid--wide"', false)
            ->assertSee('class="content-card content-card--partner"', false);

        $this->get('/en/contact')
            ->assertOk()
            ->assertSee('class="contact-grid contact-grid--wide"', false);
    }

    public function test_contact_page_shows_details_only_without_forms_or_donation_language(): void
    {
        $this->createMainSettings([
            'contact_email' => 'hello@gilwell.test',
            'partnership_email' => 'partners@gilwell.test',
            'contact_phone' => '+963 11 123 4567',
            'whatsapp_phone' => '+963 944 123 456',
            'address_en' => 'Damascus public office',
            'address_ar' => 'مكتب دمشق العام',
            'office_hours_en' => 'Sunday to Thursday',
            'office_hours_ar' => 'من الأحد إلى الخميس',
        ]);

        $this->get('/en/contact')
            ->assertOk()
            ->assertSee('hello@gilwell.test')
            ->assertSee('partners@gilwell.test')
            ->assertSee('+963 11 123 4567')
            ->assertSee('Damascus public office')
            ->assertDontSee('<form', false)
            ->assertDontSee('Donate')
            ->assertDontSee('donation');

        $this->get('/ar/contact')
            ->assertOk()
            ->assertSee('مكتب دمشق العام')
            ->assertDontSee('<form', false)
            ->assertDontSee('تبرع');
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function createMainSettings(array $overrides = []): SiteSetting
    {
        return SiteSetting::factory()->create([
            'key' => 'main',
            ...$overrides,
        ]);
    }
}
