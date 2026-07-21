<?php

namespace Database\Factories;

use App\Enums\PublishStatus;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        $startsAt = fake()->dateTimeBetween('+1 week', '+2 months');

        return [
            'slug' => fake()->unique()->slug(),
            'title_en' => fake()->sentence(4),
            'title_ar' => 'فعالية قادمة',
            'summary_en' => fake()->sentence(12),
            'summary_ar' => 'ملخص عربي للفعالية.',
            'body_en' => fake()->paragraphs(3, true),
            'body_ar' => 'تفاصيل عربية عن الفعالية ومكانها.',
            'location_en' => 'Damascus',
            'location_ar' => 'دمشق',
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->modify('+2 hours'),
            'seo_title_en' => fake()->sentence(4),
            'seo_title_ar' => 'فعالية جيلويل سوريا',
            'seo_description_en' => fake()->sentence(12),
            'seo_description_ar' => 'وصف عربي للفعالية.',
            'image_path' => 'cms/events/example.jpg',
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
