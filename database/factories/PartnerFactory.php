<?php

namespace Database\Factories;

use App\Enums\PublishStatus;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'name_en' => fake()->company(),
            'name_ar' => 'شريك مجتمعي',
            'description_en' => fake()->sentence(12),
            'description_ar' => 'وصف عربي لدور الشريك.',
            'logo_path' => 'cms/partners/example-logo.svg',
            'website_url' => fake()->url(),
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
