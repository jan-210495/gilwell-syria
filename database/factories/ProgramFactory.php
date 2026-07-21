<?php

namespace Database\Factories;

use App\Enums\PublishStatus;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Program>
 */
class ProgramFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'title_en' => fake()->sentence(3),
            'title_ar' => 'برنامج تدريبي',
            'summary_en' => fake()->sentence(10),
            'summary_ar' => 'ملخص عربي للبرنامج.',
            'body_en' => fake()->paragraphs(3, true),
            'body_ar' => 'تفاصيل عربية عن البرنامج وأنشطته وأثره.',
            'image_path' => 'cms/programs/example.jpg',
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
