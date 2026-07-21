<?php

namespace Database\Factories;

use App\Enums\PublishStatus;
use App\Models\ImpactStory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImpactStory>
 */
class ImpactStoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'title_en' => fake()->sentence(4),
            'title_ar' => 'قصة أثر',
            'summary_en' => fake()->sentence(10),
            'summary_ar' => 'ملخص عربي لقصة الأثر.',
            'body_en' => fake()->paragraphs(3, true),
            'body_ar' => 'قصة عربية توضح أثر برامج جيلويل سوريا.',
            'seo_title_en' => fake()->sentence(4),
            'seo_title_ar' => 'قصة أثر جيلويل سوريا',
            'seo_description_en' => fake()->sentence(12),
            'seo_description_ar' => 'وصف عربي لقصة الأثر.',
            'image_path' => 'cms/impact/example.jpg',
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
