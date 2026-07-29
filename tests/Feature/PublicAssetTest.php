<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicAssetTest extends TestCase
{
    public function test_favicon_is_a_non_empty_three_frame_rgba_ico(): void
    {
        $favicon = public_path('favicon.ico');

        $this->assertFileExists($favicon);
        $this->assertGreaterThan(0, filesize($favicon));
        $this->assertContains(mime_content_type($favicon), [
            'image/vnd.microsoft.icon',
            'image/x-icon',
        ]);

        $contents = file_get_contents($favicon);

        $this->assertNotFalse($contents);
        $this->assertGreaterThanOrEqual(54, strlen($contents));

        $header = unpack('vreserved/vtype/vcount', substr($contents, 0, 6));

        $this->assertSame(0, $header['reserved']);
        $this->assertSame(1, $header['type']);
        $this->assertSame(3, $header['count']);

        $frames = [];

        for ($index = 0; $index < $header['count']; $index++) {
            $entry = unpack(
                'Cwidth/Cheight/Ccolor_count/Creserved/vplanes/vbits/Vbytes/Voffset',
                substr($contents, 6 + ($index * 16), 16),
            );

            $this->assertSame(0, $entry['color_count']);
            $this->assertSame(0, $entry['reserved']);
            $this->assertSame(1, $entry['planes']);
            $this->assertSame(32, $entry['bits']);
            $this->assertGreaterThan(0, $entry['bytes']);
            $this->assertGreaterThanOrEqual(54, $entry['offset']);
            $this->assertLessThanOrEqual(strlen($contents), $entry['offset'] + $entry['bytes']);

            $frames[] = [$entry['width'], $entry['height']];
        }

        $this->assertSame([[16, 16], [32, 32], [48, 48]], $frames);
    }

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
