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

        $this->assertStringContainsString('background-image: var(--corner-image);', $this->block($css, '.hero-corner-panel'));
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

    public function test_desktop_home_framing_uses_cinematic_hero_and_credibility_spacing(): void
    {
        $css = $this->normalizedCss();

        $hero = $this->block($css, '.home-hero--corners');
        $this->assertStringContainsString('min-block-size: 100svh;', $hero);

        $credibilityStrip = $this->block($css, '.credibility-strip');
        $this->assertStringContainsString('padding-block: clamp(24px, 4vw, 48px);', $credibilityStrip);
        $this->assertStringNotContainsString('padding-block: clamp(32px, 5vw, 64px);', $credibilityStrip);
    }

    public function test_five_corner_hero_has_interactive_panel_contract(): void
    {
        $css = $this->normalizedCss();

        $hero = $this->block($css, '.home-hero--corners');
        $this->assertStringContainsString('min-block-size: 100svh;', $hero);
        $this->assertStringContainsString('background: var(--color-pine-900);', $hero);

        $panels = $this->block($css, '.hero-corners__panels');
        $this->assertStringContainsString('display: flex;', $panels);

        $panel = $this->block($css, '.hero-corner-panel');
        $this->assertStringContainsString('flex: 1 1 0;', $panel);
        $this->assertStringContainsString('background-image: var(--corner-image-fallback);', $panel);
        $this->assertStringContainsString('background-image: var(--corner-image);', $panel);

        $active = $this->block($css, '.hero-corner-panel:hover, .hero-corner-panel:focus-within');
        $this->assertStringContainsString('flex-grow: 2.35;', $active);

        $value = $this->block($css, '.hero-corner-panel__value');
        $this->assertStringContainsString('opacity: 0;', $value);

        $activeValue = $this->block($css, '.hero-corner-panel:hover .hero-corner-panel__value, .hero-corner-panel:focus-within .hero-corner-panel__value');
        $this->assertStringContainsString('opacity: 1;', $activeValue);

        $mobile = $this->block($css, '@media (max-width: 820px)');
        $mobilePanels = $this->block($mobile, '.hero-corners__panels');
        $this->assertStringContainsString('display: grid;', $mobilePanels);
        $this->assertStringContainsString('grid-template-columns: 1fr;', $mobilePanels);
    }

    public function test_content_feed_uses_desktop_split_and_responsive_single_column_layout(): void
    {
        $css = $this->normalizedCss();

        $contentFeed = $this->block($css, '.section--content-feed');
        $this->assertStringContainsString('display: grid;', $contentFeed);
        $this->assertStringContainsString('grid-template-columns: repeat(2, minmax(0, 1fr));', $contentFeed);

        $tablet = $this->block($css, '@media (max-width: 1100px)');
        $this->assertStringContainsString(
            'grid-template-columns: 1fr;',
            $this->block($tablet, '.section--content-feed'),
        );
    }

    public function test_mobile_header_uses_compact_fixed_layout(): void
    {
        $css = $this->normalizedCss();
        $mobile = $this->block($css, '@media (max-width: 820px)');

        $header = $this->block($mobile, '.site-header');
        $this->assertStringContainsString('position: fixed;', $header);

        $inner = $this->block($mobile, '.site-header__inner');
        $this->assertStringContainsString('grid-template-columns: minmax(0, 1fr) auto auto;', $inner);

        $nav = $this->block($mobile, '.site-nav');
        $this->assertStringContainsString('position: fixed;', $nav);
        $this->assertStringContainsString('overflow-y: auto;', $nav);

        $actions = $this->block($mobile, '.site-header__actions');
        $this->assertStringContainsString('grid-column: 3;', $actions);
        $this->assertStringContainsString('grid-row: 1;', $actions);

        $brand = $this->block($mobile, '.brand {');
        $this->assertStringContainsString('min-inline-size: 0;', $brand);

        $brandText = $this->block($mobile, '.brand__text');
        $this->assertStringContainsString('display: none;', $brandText);
    }

    public function test_header_uses_overlay_brand_and_mobile_burger_panel(): void
    {
        $css = $this->normalizedCss();

        $header = $this->block($css, '.site-header');
        $this->assertStringContainsString('position: fixed;', $header);
        $this->assertStringContainsString('transition:', $header);

        $brandLogo = $this->block($css, '.brand__logo--transparent');
        $this->assertStringContainsString('background: transparent;', $brandLogo);
        $this->assertStringNotContainsString('border:', $brandLogo);

        $menuToggle = $this->block($css, '.menu-toggle');
        $this->assertStringContainsString('display: none;', $menuToggle);

        $mobile = $this->block($css, '@media (max-width: 820px)');
        $mobileToggle = $this->block($mobile, '.menu-toggle');
        $this->assertStringContainsString('display: inline-flex;', $mobileToggle);

        $mobileNav = $this->block($mobile, '.site-nav');
        $this->assertStringContainsString('position: fixed;', $mobileNav);
        $this->assertStringContainsString('overflow-y: auto;', $mobileNav);
        $this->assertStringNotContainsString('overflow-x: auto;', $mobileNav);

        $openNav = $this->block($mobile, '.site-header.is-menu-open .site-nav');
        $this->assertStringContainsString('opacity: 1;', $openNav);
        $this->assertStringContainsString('pointer-events: auto;', $openNav);

        $headerBrandText = $this->block($css, '.site-header .brand__text strong');
        $this->assertStringContainsString('color: currentColor;', $headerBrandText);

        $menuLock = $this->block($css, 'html.has-open-menu');
        $this->assertStringContainsString('overflow: hidden;', $menuLock);
    }

    public function test_partner_logo_media_uses_contain_without_changing_content_card_cropping(): void
    {
        $css = $this->normalizedCss();

        $this->assertStringContainsString('object-fit: cover;', $this->block($css, '.media-frame__image'));

        $partnerFrame = $this->block($css, '.content-card--partner .media-frame');
        $this->assertStringContainsString('aspect-ratio: 4 / 3;', $partnerFrame);
        $this->assertStringContainsString('padding: clamp(16px, 2vw, 24px);', $partnerFrame);

        $partnerImage = $this->block($css, '.content-card--partner .media-frame__image');
        $this->assertStringContainsString('object-fit: contain;', $partnerImage);
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
