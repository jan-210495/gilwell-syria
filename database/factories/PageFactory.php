<?php

namespace Database\Factories;

use App\Enums\PublishStatus;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'title_en' => fake()->sentence(3),
            'title_ar' => 'صفحة تعريفية',
            'summary_en' => fake()->sentence(10),
            'summary_ar' => 'ملخص عربي للمحتوى التعريفي.',
            'body_en' => fake()->paragraphs(3, true),
            'body_ar' => 'نص عربي طويل يشرح محتوى الصفحة ويستخدم لاختبار الواجهة.',
            'seo_title_en' => fake()->sentence(4),
            'seo_title_ar' => 'عنوان تحسين البحث',
            'seo_description_en' => fake()->sentence(12),
            'seo_description_ar' => 'وصف عربي قصير لمحركات البحث.',
            'hero_image_path' => 'cms/pages/example-hero.jpg',
            'sort_order' => 0,
            'status' => PublishStatus::Draft,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PublishStatus::Published,
            'published_at' => now(),
        ]);
    }
}
