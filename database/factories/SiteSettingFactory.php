<?php

namespace Database\Factories;

use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteSetting>
 */
class SiteSettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'key' => fake()->unique()->slug(),
            'site_name_en' => 'GilwellSyria',
            'site_name_ar' => 'جيلويل سوريا',
            'tagline_en' => fake()->sentence(6),
            'tagline_ar' => 'منصة تدريب وخدمة شبابية',
            'contact_email' => fake()->safeEmail(),
            'partnership_email' => 'partnerships@gilwellsyria.local',
            'contact_phone' => '+963 11 000 0000',
            'whatsapp_phone' => '+963 944 000 000',
            'address_en' => fake()->address(),
            'address_ar' => 'دمشق، سوريا',
            'office_hours_en' => 'Sunday to Thursday, 9:00-17:00',
            'office_hours_ar' => 'من الأحد إلى الخميس، 9:00-17:00',
            'map_url' => 'https://maps.example.test/gilwell-syria',
            'facebook_url' => null,
            'instagram_url' => null,
            'youtube_url' => null,
        ];
    }
}
