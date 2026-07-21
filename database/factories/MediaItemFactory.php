<?php

namespace Database\Factories;

use App\Enums\MediaType;
use App\Enums\PublishStatus;
use App\Models\GalleryAlbum;
use App\Models\MediaItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MediaItem>
 */
class MediaItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'gallery_album_id' => GalleryAlbum::factory(),
            'media_type' => MediaType::Image,
            'path' => 'cms/gallery/example.jpg',
            'thumbnail_path' => 'cms/gallery/example-thumb.jpg',
            'title_en' => fake()->sentence(3),
            'title_ar' => 'صورة من النشاط',
            'alt_text_en' => 'Participants during a GilwellSyria activity',
            'alt_text_ar' => 'مشاركون خلال نشاط لجيلويل سوريا',
            'caption_en' => fake()->sentence(10),
            'caption_ar' => 'تعليق عربي للصورة.',
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
