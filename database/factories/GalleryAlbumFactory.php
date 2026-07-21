<?php

namespace Database\Factories;

use App\Enums\PublishStatus;
use App\Models\GalleryAlbum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GalleryAlbum>
 */
class GalleryAlbumFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'title_en' => fake()->sentence(3),
            'title_ar' => 'ألبوم صور',
            'description_en' => fake()->sentence(12),
            'description_ar' => 'وصف عربي للألبوم.',
            'cover_image_path' => 'cms/gallery/cover.jpg',
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
