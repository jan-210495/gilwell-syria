<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicVisualCssTest extends TestCase
{
    private const WIDE_CONTAINER = 'width: min(100% - (var(--layout-gutter) * 2), var(--layout-wide));';

    private const LISTING_GRIDS = '.section--program-feature .card-grid, .section--listing .card-grid';

    public function test_css_contains_exact_wide_visual_reset_layout_contract(): void
    {
        $css = $this->normalizedCss();

        $root = $this->block($css, ':root');
        $this->assertStringContainsString('--layout-wide: 1680px;', $root);
        $this->assertStringContainsString('--layout-reading: 820px;', $root);
        $this->assertStringContainsString('--layout-gutter: clamp(20px, 4vw, 72px);', $root);

        foreach (['.site-header__inner', '.home-hero__inner', '.section', '.credibility-strip', '.page-hero', '.site-footer__inner'] as $selector) {
            $this->assertStringContainsString(self::WIDE_CONTAINER, $this->block($css, $selector), $selector);
        }

        $this->assertStringContainsString('background-image: var(--hero-image);', $this->block($css, '.home-hero--editorial'));
        $this->assertStringContainsString('.logo-grid--wide', $css);
        $this->assertStringNotContainsString('linear-gradient', $css);
    }

    public function test_compact_and_listing_grids_follow_explicit_desktop_tablet_mobile_columns(): void
    {
        $css = $this->normalizedCss();

        $this->assertGridColumns($css, '.card-grid--compact', 4);
        $this->assertGridColumns($css, self::LISTING_GRIDS, 4);

        $veryWide = $this->block($css, '@media (min-width: 1500px)');
        $this->assertGridColumns($veryWide, '.card-grid--compact', 5);
        $this->assertGridColumns($veryWide, self::LISTING_GRIDS, 4);

        $tablet = $this->block($css, '@media (max-width: 1100px)');
        $this->assertGridColumns($tablet, '.card-grid--compact', 2);
        $this->assertGridColumns($tablet, self::LISTING_GRIDS, 2);

        $mobile = $this->block($css, '@media (max-width: 820px)');
        $this->assertGridColumns($mobile, '.card-grid--compact', 1);
        $this->assertGridColumns($mobile, self::LISTING_GRIDS, 1);
    }

    public function test_desktop_home_framing_reveals_credibility_content_below_the_hero(): void
    {
        $css = $this->normalizedCss();

        $hero = $this->block($css, '.home-hero--editorial');
        $this->assertStringContainsString('min-block-size: min(74svh, 760px);', $hero);
        $this->assertStringNotContainsString('min-block-size: min(82svh, 820px);', $hero);

        $credibilityStrip = $this->block($css, '.credibility-strip');
        $this->assertStringContainsString('padding-block: clamp(24px, 4vw, 48px);', $credibilityStrip);
        $this->assertStringNotContainsString('padding-block: clamp(32px, 5vw, 64px);', $credibilityStrip);
    }

    private function assertGridColumns(string $css, string $selector, int $columns): void
    {
        $this->assertStringContainsString(
            "grid-template-columns: repeat({$columns}, minmax(0, 1fr));",
            $this->block($css, $selector),
            $selector,
        );
    }

    private function normalizedCss(): string
    {
        $css = file_get_contents(resource_path('css/app.css'));

        $this->assertNotFalse($css);

        return preg_replace('/\s+/', ' ', trim($css)) ?? '';
    }

    private function block(string $css, string $header): string
    {
        $start = strpos($css, $header);
        $this->assertNotFalse($start, "Missing CSS block: {$header}");

        $openingBrace = strpos($css, '{', $start);
        $this->assertNotFalse($openingBrace, "Missing opening brace for CSS block: {$header}");

        $depth = 0;

        for ($position = $openingBrace, $length = strlen($css); $position < $length; $position++) {
            if ($css[$position] === '{') {
                $depth++;
            } elseif ($css[$position] === '}') {
                $depth--;

                if ($depth === 0) {
                    return substr($css, $openingBrace + 1, $position - $openingBrace - 1);
                }
            }
        }

        $this->fail("Missing closing brace for CSS block: {$header}");
    }
}
