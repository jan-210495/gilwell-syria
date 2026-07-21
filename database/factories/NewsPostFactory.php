<?php

namespace Database\Factories;

use App\Enums\PublishStatus;
use App\Models\NewsPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NewsPost>
 */
class NewsPostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'title_en' => fake()->sentence(4),
            'title_ar' => 'خبر جديد',
            'summary_en' => fake()->sentence(12),
            'summary_ar' => 'ملخص عربي للخبر.',
            'body_en' => fake()->paragraphs(3, true),
            'body_ar' => 'نص عربي لتفاصيل الخبر.',
            'seo_title_en' => fake()->sentence(4),
            'seo_title_ar' => 'خبر جيلويل سوريا',
            'seo_description_en' => fake()->sentence(12),
            'seo_description_ar' => 'وصف عربي للخبر.',
            'image_path' => 'cms/news/example.jpg',
            'document_path' => null,
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
