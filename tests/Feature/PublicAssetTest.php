<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicAssetTest extends TestCase
{
    /**
     * @return array<string, array{0: string}>
     */
    public static function heroCornerProvider(): array
    {
        return [
            'merit' => ['merit'],
            'discipline' => ['discipline'],
            'honor' => ['honor'],
            'tenacity' => ['tenacity'],
            'loyalty' => ['loyalty'],
        ];
    }

    /** @dataProvider heroCornerProvider */
    #[DataProvider('heroCornerProvider')]
    public function test_hero_corner_source_and_optimized_assets_exist(string $key): void
    {
        $source = public_path("images/hero-corners/{$key}.png");
        $optimized = public_path("images/hero-corners/optimized/{$key}.webp");

        $this->assertFileExists($source);
        $this->assertFileExists($optimized);
        $this->assertSame('image/png', mime_content_type($source));
        $this->assertSame('image/webp', mime_content_type($optimized));
        $this->assertLessThan(filesize($source), filesize($optimized), "{$key} WebP should be smaller than PNG source.");
        $this->assertLessThan(450_000, filesize($optimized), "{$key} WebP should stay below 450KB.");

        [$width, $height] = getimagesize($optimized);

        $this->assertGreaterThan(700, $width);
        $this->assertGreaterThan(1200, $height);
        $this->assertGreaterThan($width, $height);
    }

    public function test_transparent_brand_mark_exists_for_header(): void
    {
        $brandMark = public_path('images/gilwellsyria-logo-transparent.png');

        $this->assertFileExists($brandMark);
        $this->assertSame('image/png', mime_content_type($brandMark));
        $this->assertLessThan(220_000, filesize($brandMark));
    }
}
