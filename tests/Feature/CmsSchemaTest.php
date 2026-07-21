<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CmsSchemaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{string, array<int, string>}>
     */
    public static function bilingualTableProvider(): array
    {
        return [
            'site settings' => ['site_settings', ['site_name_en', 'site_name_ar', 'address_en', 'address_ar']],
            'pages' => ['pages', ['title_en', 'title_ar', 'body_en', 'body_ar']],
            'programs' => ['programs', ['title_en', 'title_ar', 'summary_en', 'summary_ar']],
            'impact metrics' => ['impact_metrics', ['label_en', 'label_ar']],
            'impact stories' => ['impact_stories', ['title_en', 'title_ar', 'body_en', 'body_ar']],
            'partners' => ['partners', ['name_en', 'name_ar', 'description_en', 'description_ar']],
            'gallery albums' => ['gallery_albums', ['title_en', 'title_ar', 'description_en', 'description_ar']],
            'media items' => ['media_items', ['title_en', 'title_ar', 'alt_text_en', 'alt_text_ar']],
            'news posts' => ['news_posts', ['title_en', 'title_ar', 'body_en', 'body_ar']],
            'events' => ['events', ['title_en', 'title_ar', 'location_en', 'location_ar']],
        ];
    }

    /**
     * @param  array<int, string>  $columns
     */
    #[DataProvider('bilingualTableProvider')]
    public function test_cms_tables_store_bilingual_fields_on_each_record(string $table, array $columns): void
    {
        $this->assertTrue(Schema::hasTable($table), "Expected {$table} table to exist.");
        $this->assertTrue(Schema::hasColumns($table, $columns), "Expected {$table} to have bilingual columns.");
    }

    public function test_publishable_tables_have_workflow_columns(): void
    {
        $publishableTables = [
            'pages',
            'programs',
            'impact_metrics',
            'impact_stories',
            'partners',
            'gallery_albums',
            'media_items',
            'news_posts',
            'events',
        ];

        foreach ($publishableTables as $table) {
            $this->assertTrue(Schema::hasColumns($table, ['status', 'published_at']), "Expected {$table} to have publish workflow columns.");
        }
    }

    public function test_site_settings_are_limited_to_v1_contact_and_partnership_details(): void
    {
        $this->assertTrue(Schema::hasColumns('site_settings', [
            'contact_email',
            'partnership_email',
            'contact_phone',
            'whatsapp_phone',
            'address_en',
            'address_ar',
        ]));

        $this->assertFalse(Schema::hasColumn('site_settings', 'donation_url'));
    }
}
