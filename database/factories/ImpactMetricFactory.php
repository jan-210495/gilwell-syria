<?php

namespace Database\Factories;

use App\Enums\PublishStatus;
use App\Models\ImpactMetric;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImpactMetric>
 */
class ImpactMetricFactory extends Factory
{
    public function definition(): array
    {
        return [
            'label_en' => 'Youth reached',
            'label_ar' => 'الشباب المستفيدون',
            'value' => (string) fake()->numberBetween(100, 5000),
            'unit_en' => 'participants',
            'unit_ar' => 'مشارك',
            'description_en' => fake()->sentence(10),
            'description_ar' => 'وصف مختصر للأثر.',
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
