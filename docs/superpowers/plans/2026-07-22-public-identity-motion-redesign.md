# Public Identity Motion Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Turn the stable public visual reset into a living GilwellSyria identity experience with a five-corner cinematic hero, accessible burger navigation, transparent-feeling brand treatment, and tactile motion.

**Architecture:** Keep the Laravel Blade public frontend. Generate optimized static assets from the user-provided hero-corner PNGs, then update Blade markup, CSS, and small vanilla JavaScript to support the new hero, header, burger menu, hover/focus states, and scroll reveals. Use focused PHP feature tests and CSS contract tests to lock the behavior before implementation.

**Tech Stack:** Laravel 13, Blade, Vite, Tailwind CSS entry file with custom CSS, vanilla JavaScript in `resources/js/app.js`, PHPUnit feature tests, ImageMagick `convert`, Docker-backed PHP helper scripts in `scripts/dev-php`, npm/Vite build.

## Global Constraints

- Use the five source images under `public/images/hero-corners/`: `merit.png`, `discipline.png`, `honor.png`, `tenacity.png`, `loyalty.png`.
- Generate optimized WebP files under `public/images/hero-corners/optimized/`: `merit.webp`, `discipline.webp`, `honor.webp`, `tenacity.webp`, `loyalty.webp`.
- Do not serve the five `2MB+` PNGs as the primary hero delivery format.
- Header logo must no longer appear trapped inside a white tile.
- Mobile navigation must be a burger menu, not horizontal scrolling nav.
- Use a small vanilla JavaScript controller in `resources/js/app.js`; do not add a frontend framework.
- Default hero state is quiet and cinematic; value names become prominent on hover/focus.
- Hover states must have matching focus-visible states for keyboard users.
- Respect `prefers-reduced-motion`.
- No donation flow, donation CTA, donation settings, or public contact form.
- No decorative orb/blob background systems.
- Do not copy the Arena React implementation or convert the Laravel public site to React.
- Preserve locale-prefixed public URLs: `/en` and `/ar`.
- Preserve equal-quality English LTR and Arabic RTL experiences.

---

## File Structure

- Create `tests/Feature/PublicAssetTest.php`: verifies source hero-corner images, optimized WebP derivatives, and transparent brand mark.
- Modify `tests/Feature/PublicSiteTest.php`: verifies five-corner hero markup, optimized hero delivery, transparent brand mark usage, and accessible burger menu.
- Modify `tests/Feature/PublicVisualCssTest.php`: verifies header/menu CSS, five-corner hero CSS, hover/focus motion, reduced-motion protections, and no horizontal mobile nav.
- Create `public/images/gilwellsyria-logo-transparent.png`: transparent brand-mark derivative from the existing approved logo.
- Add `public/images/hero-corners/*.png`: user-provided source images.
- Create `public/images/hero-corners/optimized/*.webp`: optimized delivery images for the hero panels.
- Modify `resources/views/public/layout.blade.php`: add header state hooks, transparent brand mark, burger button, accessible menu panel, and preload yield compatibility.
- Modify `resources/views/public/home.blade.php`: replace the single-photo hero with five hero-corner panels and localized value copy.
- Modify `resources/css/app.css`: add identity color tokens, header overlay/burger menu rules, five-corner hero layout, tactile interaction states, scroll reveal, and reduced-motion protections.
- Modify `resources/js/app.js`: add vanilla controllers for burger menu, header scroll state, and reveal-on-scroll.
- Modify `docs/design/brand-system.md` and `docs/design/stitch-prompts.md`: record the living five-corner identity direction.
- Modify `AGENT_LOG.md`, `DECISIONS.md`, and `LIVE_STATUS.md`: record execution and final acceptance.

## Task 1: Asset Pipeline And Public Asset Tests

**Files:**
- Create: `tests/Feature/PublicAssetTest.php`
- Create: `public/images/gilwellsyria-logo-transparent.png`
- Add: `public/images/hero-corners/merit.png`
- Add: `public/images/hero-corners/discipline.png`
- Add: `public/images/hero-corners/honor.png`
- Add: `public/images/hero-corners/tenacity.png`
- Add: `public/images/hero-corners/loyalty.png`
- Create: `public/images/hero-corners/optimized/merit.webp`
- Create: `public/images/hero-corners/optimized/discipline.webp`
- Create: `public/images/hero-corners/optimized/honor.webp`
- Create: `public/images/hero-corners/optimized/tenacity.webp`
- Create: `public/images/hero-corners/optimized/loyalty.webp`
- Modify: `AGENT_LOG.md`
- Modify: `LIVE_STATUS.md`

**Interfaces:**
- Produces: `asset('images/gilwellsyria-logo-transparent.png')`, consumed by `resources/views/public/layout.blade.php`.
- Produces: `asset("images/hero-corners/optimized/{$key}.webp")`, consumed by `resources/views/public/home.blade.php`.
- Produces: source PNG fallback paths under `images/hero-corners/{$key}.png`.

- [ ] **Step 1: Add the failing asset test**

Create `tests/Feature/PublicAssetTest.php`:

```php
<?php

namespace Tests\Feature;

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

    /**
     * @dataProvider heroCornerProvider
     */
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
```

- [ ] **Step 2: Run the targeted red test**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicAssetTest.php
```

Expected: FAIL because `public/images/hero-corners/optimized/*.webp` and `public/images/gilwellsyria-logo-transparent.png` do not exist yet.

- [ ] **Step 3: Verify source images are present**

Run:

```bash
for name in merit discipline honor tenacity loyalty; do
  test -f "public/images/hero-corners/${name}.png"
done
identify public/images/hero-corners/*.png
```

Expected: each source file exists and reports `PNG 941x1672`.

If any source image is missing, stop and report `BLOCKED` to Mastermind with the missing filename.

- [ ] **Step 4: Generate optimized hero-corner WebP files**

Run:

```bash
mkdir -p public/images/hero-corners/optimized
for name in merit discipline honor tenacity loyalty; do
  convert "public/images/hero-corners/${name}.png" \
    -strip \
    -resize '941x1672>' \
    -quality 76 \
    -define webp:method=6 \
    "public/images/hero-corners/optimized/${name}.webp"
done
```

Expected: five WebP files are created under `public/images/hero-corners/optimized/`.

- [ ] **Step 5: Generate transparent brand mark**

Run:

```bash
convert public/images/gilwellsyria-logo.jpeg \
  -alpha set \
  -fuzz 6% \
  -transparent white \
  -strip \
  public/images/gilwellsyria-logo-transparent.png
```

Expected: `public/images/gilwellsyria-logo-transparent.png` exists and is a PNG.

- [ ] **Step 6: Verify generated asset sizes**

Run:

```bash
identify public/images/gilwellsyria-logo-transparent.png public/images/hero-corners/optimized/*.webp
ls -lh public/images/gilwellsyria-logo-transparent.png public/images/hero-corners/*.png public/images/hero-corners/optimized/*.webp
```

Expected: every optimized WebP is smaller than its matching PNG and below `450KB`.

- [ ] **Step 7: Run the green asset test**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicAssetTest.php
```

Expected: PASS, `6 tests`.

- [ ] **Step 8: Commit Task 1**

Run:

```bash
git add tests/Feature/PublicAssetTest.php \
  public/images/gilwellsyria-logo-transparent.png \
  public/images/hero-corners \
  AGENT_LOG.md LIVE_STATUS.md
git commit -m "feat: add identity hero assets"
```

Expected: commit includes only Task 1 files and generated assets.

## Task 2: Transparent Header And Accessible Burger Menu

**Files:**
- Modify: `tests/Feature/PublicSiteTest.php`
- Modify: `tests/Feature/PublicVisualCssTest.php`
- Modify: `resources/views/public/layout.blade.php`
- Modify: `resources/css/app.css`
- Modify: `resources/js/app.js`
- Modify: `AGENT_LOG.md`
- Modify: `LIVE_STATUS.md`

**Interfaces:**
- Consumes: `images/gilwellsyria-logo-transparent.png` from Task 1.
- Produces: `[data-site-header]`, `[data-menu-toggle]`, `[data-menu-panel]`, `.menu-toggle`, and `.site-header.is-menu-open` hooks.
- Produces: JavaScript state behavior for menu open/close and header scrolled state.

- [ ] **Step 1: Add the failing public header test**

Add this method to `tests/Feature/PublicSiteTest.php` after `test_home_preloads_and_serves_optimized_hero_with_png_fallback()`:

```php
    public function test_public_header_uses_transparent_brand_and_accessible_burger_menu(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/en')
            ->assertOk()
            ->assertSee('data-site-header', false)
            ->assertSee('gilwellsyria-logo-transparent.png')
            ->assertSee('class="brand__logo brand__logo--transparent"', false)
            ->assertSee('class="menu-toggle"', false)
            ->assertSee('type="button"', false)
            ->assertSee('aria-expanded="false"', false)
            ->assertSee('aria-controls="site-menu-panel"', false)
            ->assertSee('data-menu-toggle', false)
            ->assertSee('id="site-menu-panel"', false)
            ->assertSee('data-menu-panel', false)
            ->assertSee('data-menu-close', false);

        $this->get('/ar')
            ->assertOk()
            ->assertSee('data-site-header', false)
            ->assertSee('aria-controls="site-menu-panel"', false)
            ->assertSee('جيلويل سوريا');
    }
```

- [ ] **Step 2: Add the failing CSS header/menu contract test**

Add this method to `tests/Feature/PublicVisualCssTest.php` after `test_mobile_header_uses_compact_non_sticky_layout()`:

```php
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
    }
```

- [ ] **Step 3: Run targeted red tests**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=public_header_uses_transparent_brand
scripts/dev-php artisan test tests/Feature/PublicVisualCssTest.php --filter=header_uses_overlay_brand
```

Expected: both FAIL because layout/CSS still use the old header and mobile horizontal nav.

- [ ] **Step 4: Update `layout.blade.php` header markup**

In `resources/views/public/layout.blade.php`, change:

```blade
        <header class="site-header">
```

to:

```blade
        <header class="site-header" data-site-header>
```

Replace the brand image line:

```blade
                    <img class="brand__logo" src="{{ asset('images/gilwellsyria-logo.jpeg') }}" alt="{{ $siteName }}">
```

with:

```blade
                    <img class="brand__logo brand__logo--transparent" src="{{ asset('images/gilwellsyria-logo-transparent.png') }}" alt="{{ $siteName }}">
```

Insert this burger button immediately before the `<nav class="site-nav"` element:

```blade
                <button class="menu-toggle" type="button" aria-label="{{ $labels['nav_label'] }}" aria-expanded="false" aria-controls="site-menu-panel" data-menu-toggle>
                    <span class="menu-toggle__line"></span>
                    <span class="menu-toggle__line"></span>
                    <span class="menu-toggle__line"></span>
                </button>
```

Replace:

```blade
                <nav class="site-nav" aria-label="{{ $labels['nav_label'] }}">
```

with:

```blade
                <nav id="site-menu-panel" class="site-nav" aria-label="{{ $labels['nav_label'] }}" data-menu-panel>
```

Inside the nav link loop, add `data-menu-close` to each nav anchor:

```blade
                        <a class="site-nav__link {{ $active ? 'is-active' : '' }}" href="{{ $item['href'] }}" data-menu-close @if ($active) aria-current="page" @endif>
```

Add `data-menu-close` to the language and contact links inside `.site-header__actions`:

```blade
                    <a class="language-switch" href="{{ $languageUrl }}" hreflang="{{ $otherLocale }}" data-menu-close>{{ $languageLabel }}</a>
                    <a class="button button--primary" href="{{ url("/{$locale}/contact") }}" data-menu-close>{{ $labels['contact'] }}</a>
```

- [ ] **Step 5: Add vanilla menu/header JavaScript**

Replace the entire contents of `resources/js/app.js` with:

```js
const siteHeader = document.querySelector('[data-site-header]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const menuPanel = document.querySelector('[data-menu-panel]');
const menuCloseTargets = document.querySelectorAll('[data-menu-close]');

function setMenuOpen(open) {
    if (!siteHeader || !menuToggle || !menuPanel) {
        return;
    }

    siteHeader.classList.toggle('is-menu-open', open);
    menuToggle.setAttribute('aria-expanded', String(open));
    menuPanel.toggleAttribute('data-open', open);
    document.documentElement.classList.toggle('has-open-menu', open);
}

if (siteHeader && menuToggle && menuPanel) {
    menuToggle.addEventListener('click', () => {
        setMenuOpen(menuToggle.getAttribute('aria-expanded') !== 'true');
    });

    menuCloseTargets.forEach((target) => {
        target.addEventListener('click', () => setMenuOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMenuOpen(false);
        }
    });

    const updateHeaderState = () => {
        siteHeader.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    updateHeaderState();
    window.addEventListener('scroll', updateHeaderState, { passive: true });
}
```

- [ ] **Step 6: Add header and burger CSS**

In `resources/css/app.css`, replace the existing `.site-header`, `.site-header__inner`, `.brand__logo`, `.site-nav`, `.site-nav__link`, `.site-header__actions`, and mobile nav rules with CSS that includes these exact contract fragments:

```css
    .site-header {
        position: fixed;
        z-index: 30;
        inset-block-start: 0;
        inset-inline: 0;
        border-block-end: 1px solid transparent;
        background: rgb(18 33 25 / 0%);
        color: var(--color-white);
        transition: background 320ms ease, border-color 320ms ease, color 320ms ease, box-shadow 320ms ease;
    }

    .site-header.is-scrolled,
    .site-header.is-menu-open {
        border-block-end-color: var(--color-border);
        background: rgb(248 247 243 / 94%);
        color: var(--color-ink);
        box-shadow: 0 10px 30px rgb(17 24 39 / 8%);
        backdrop-filter: blur(14px);
    }

    .brand__logo--transparent {
        inline-size: 62px;
        block-size: 62px;
        background: transparent;
        object-fit: contain;
        filter: drop-shadow(0 8px 16px rgb(0 0 0 / 18%));
        transition: transform 320ms ease, filter 320ms ease;
    }

    .brand:hover .brand__logo--transparent,
    .brand:focus-visible .brand__logo--transparent {
        transform: rotate(4deg) scale(1.04);
    }

    .menu-toggle {
        display: none;
        align-items: center;
        justify-content: center;
        inline-size: 46px;
        block-size: 46px;
        border: 1px solid currentColor;
        border-radius: 999px;
        background: transparent;
        color: currentColor;
    }

    .menu-toggle__line {
        position: absolute;
        inline-size: 18px;
        block-size: 2px;
        border-radius: 999px;
        background: currentColor;
        transition: transform 260ms ease, opacity 260ms ease;
    }

    .menu-toggle__line:nth-child(1) {
        transform: translateY(-6px);
    }

    .menu-toggle__line:nth-child(3) {
        transform: translateY(6px);
    }

    .site-header.is-menu-open .menu-toggle__line:nth-child(1) {
        transform: rotate(45deg);
    }

    .site-header.is-menu-open .menu-toggle__line:nth-child(2) {
        opacity: 0;
    }

    .site-header.is-menu-open .menu-toggle__line:nth-child(3) {
        transform: rotate(-45deg);
    }
```

Under `@media (max-width: 820px)`, include:

```css
    .menu-toggle {
        display: inline-flex;
        position: relative;
    }

    .site-header {
        position: fixed;
        backdrop-filter: none;
    }

    .site-nav {
        position: fixed;
        inset-block-start: 82px;
        inset-inline: 16px;
        display: grid;
        gap: 0;
        max-block-size: calc(100svh - 104px);
        padding: 10px 18px;
        overflow-y: auto;
        border: 1px solid var(--color-border);
        border-radius: 8px;
        background: var(--color-paper);
        color: var(--color-ink);
        box-shadow: var(--shadow-hero);
        opacity: 0;
        pointer-events: none;
        transform: translateY(-10px);
        transition: opacity 260ms ease, transform 260ms ease;
    }

    .site-header.is-menu-open .site-nav {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }

    .site-nav__link {
        min-block-size: 52px;
        padding-block: 15px;
        border-block-end: 1px solid var(--color-border);
    }
```

- [ ] **Step 7: Run targeted green tests**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=public_header_uses_transparent_brand
scripts/dev-php artisan test tests/Feature/PublicVisualCssTest.php --filter=header_uses_overlay_brand
```

Expected: both PASS.

- [ ] **Step 8: Run public tests**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php tests/Feature/PublicVisualCssTest.php
```

Expected: PASS.

- [ ] **Step 9: Commit Task 2**

Run:

```bash
git add tests/Feature/PublicSiteTest.php tests/Feature/PublicVisualCssTest.php \
  resources/views/public/layout.blade.php resources/css/app.css resources/js/app.js \
  AGENT_LOG.md LIVE_STATUS.md
git commit -m "feat: add living public header"
```

Expected: commit includes only Task 2 files.

## Task 3: Five-Corner Cinematic Home Hero

**Files:**
- Modify: `tests/Feature/PublicSiteTest.php`
- Modify: `tests/Feature/PublicVisualCssTest.php`
- Modify: `resources/views/public/home.blade.php`
- Modify: `resources/css/app.css`
- Modify: `AGENT_LOG.md`
- Modify: `LIVE_STATUS.md`

**Interfaces:**
- Consumes: optimized hero-corner WebPs and source PNG fallbacks from Task 1.
- Consumes: fixed overlay header from Task 2.
- Produces: `.home-hero--corners`, `.hero-corners__panels`, `.hero-corner-panel`, `data-hero-corner`, and five value-copy hooks.

- [ ] **Step 1: Replace existing hero assertions with five-corner assertions**

In `tests/Feature/PublicSiteTest.php`, replace `test_home_uses_visual_reset_hero_and_wide_section_hooks()` with:

```php
    public function test_home_uses_five_corner_identity_hero_and_wide_section_hooks(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/en')
            ->assertOk()
            ->assertSee('class="home-hero home-hero--corners"', false)
            ->assertSee('class="hero-corners__panels"', false)
            ->assertSee('<h1>GilwellSyria</h1>', false)
            ->assertDontSee('<h1>Home</h1>', false)
            ->assertSee('class="credibility-strip"', false)
            ->assertSee('class="section section--program-feature"', false)
            ->assertSee('class="section section--partner-wall"', false)
            ->assertSee('class="section section--content-feed"', false);

        foreach (['merit', 'discipline', 'honor', 'tenacity', 'loyalty'] as $corner) {
            $this->get('/en')
                ->assertOk()
                ->assertSee("data-hero-corner=\"{$corner}\"", false)
                ->assertSee("images/hero-corners/optimized/{$corner}.webp")
                ->assertSee("images/hero-corners/{$corner}.png");
        }

        $this->get('/ar')
            ->assertOk()
            ->assertSee('class="home-hero home-hero--corners"', false)
            ->assertSee('<h1>جيلويل سوريا</h1>', false)
            ->assertDontSee('<h1>الرئيسية</h1>', false)
            ->assertSee('data-hero-corner="merit"', false);
    }
```

Replace `test_home_preloads_and_serves_optimized_hero_with_png_fallback()` with:

```php
    public function test_home_preloads_and_serves_optimized_corner_hero_assets(): void
    {
        $this->seed(DatabaseSeeder::class);

        foreach (['merit', 'discipline', 'honor', 'tenacity', 'loyalty'] as $corner) {
            $optimizedHero = public_path("images/hero-corners/optimized/{$corner}.webp");
            $sourceHero = public_path("images/hero-corners/{$corner}.png");

            $this->assertFileExists($optimizedHero);
            $this->assertLessThan(filesize($sourceHero), filesize($optimizedHero));
        }

        $this->get('/en')
            ->assertOk()
            ->assertSee('<link rel="preload" as="image"', false)
            ->assertSee('images/hero-corners/optimized/merit.webp')
            ->assertSee('image-set(', false)
            ->assertSee('images/hero-corners/merit.png')
            ->assertDontSee('gilwellsyria-hero-training.webp');
    }
```

- [ ] **Step 2: Add the failing five-corner CSS contract test**

Add this method to `tests/Feature/PublicVisualCssTest.php` after `test_desktop_home_framing_reveals_credibility_content_below_the_hero()`:

```php
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
```

- [ ] **Step 3: Run targeted red tests**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=five_corner_identity
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=optimized_corner_hero
scripts/dev-php artisan test tests/Feature/PublicVisualCssTest.php --filter=five_corner_hero
```

Expected: FAIL because current home still uses `.home-hero--editorial`.

- [ ] **Step 4: Replace the home page top variables**

In `resources/views/public/home.blade.php`, replace the opening `@php` block with:

```blade
@php
    $siteName = $field($settings, 'site_name', 'GilwellSyria');
    $title = $field($page, 'seo_title', $siteName);
    $heroTitle = $siteName;
    $heroSummary = $field($settings, 'tagline', $field($page, 'summary'));
    $heroBody = $field($page, 'body');
    $heroCorners = [
        [
            'key' => 'merit',
            'number' => '01',
            'color' => '#6B0F68',
            'label_en' => 'Merit',
            'label_ar' => 'الاستحقاق',
            'copy_en' => 'Earned growth through skill, service, and recognition.',
            'copy_ar' => 'نمو مستحق عبر المهارة والخدمة والتقدير.',
        ],
        [
            'key' => 'discipline',
            'number' => '02',
            'color' => '#2E5A2A',
            'label_en' => 'Discipline',
            'label_ar' => 'الانضباط',
            'copy_en' => 'Focused training, structure, and reliable practice.',
            'copy_ar' => 'تدريب مركز ونظام وممارسة موثوقة.',
        ],
        [
            'key' => 'honor',
            'number' => '03',
            'color' => '#E0AB00',
            'label_en' => 'Honor',
            'label_ar' => 'الشرف',
            'copy_en' => 'Dignified service and responsibility to others.',
            'copy_ar' => 'خدمة كريمة ومسؤولية تجاه الآخرين.',
        ],
        [
            'key' => 'tenacity',
            'number' => '04',
            'color' => '#0B3570',
            'label_en' => 'Tenacity',
            'label_ar' => 'المثابرة',
            'copy_en' => 'Perseverance through challenge and teamwork.',
            'copy_ar' => 'ثبات أمام التحدي بروح الفريق.',
        ],
        [
            'key' => 'loyalty',
            'number' => '05',
            'color' => '#B3121B',
            'label_en' => 'Loyalty',
            'label_ar' => 'الولاء',
            'copy_en' => 'Belonging, trust, and shared commitment.',
            'copy_ar' => 'انتماء وثقة والتزام مشترك.',
        ],
    ];
@endphp
```

- [ ] **Step 5: Update hero preload section**

Replace the current `@section('preload')` block with:

```blade
@section('preload')
    <link rel="preload" as="image" href="{{ asset('images/hero-corners/optimized/merit.webp') }}" type="image/webp" fetchpriority="high">
@endsection
```

- [ ] **Step 6: Replace the home hero markup**

Replace the entire current `<section class="home-hero home-hero--editorial" ...>` block through its closing `</section>` with:

```blade
    <section class="home-hero home-hero--corners" aria-labelledby="home-hero-title">
        <div class="hero-corners__backdrop" aria-hidden="true">
            <ul class="hero-corners__panels" aria-label="{{ $locale === 'ar' ? 'زوايا جيلويل الخمس' : 'Five corners of Gilwell' }}">
                @foreach ($heroCorners as $corner)
                    @php
                        $cornerLabel = $locale === 'ar' ? $corner['label_ar'] : $corner['label_en'];
                        $cornerCopy = $locale === 'ar' ? $corner['copy_ar'] : $corner['copy_en'];
                        $cornerSource = asset("images/hero-corners/{$corner['key']}.png");
                        $cornerOptimized = asset("images/hero-corners/optimized/{$corner['key']}.webp");
                    @endphp
                    <li class="hero-corner-panel hero-corner-panel--{{ $corner['key'] }}" data-hero-corner="{{ $corner['key'] }}" style="--corner-color: {{ $corner['color'] }}; --corner-image-fallback: url('{{ $cornerSource }}'); --corner-image: image-set(url('{{ $cornerOptimized }}') type('image/webp'), url('{{ $cornerSource }}') type('image/png'));">
                        <button class="hero-corner-panel__button" type="button" aria-label="{{ $cornerLabel }} - {{ $cornerCopy }}">
                            <span class="hero-corner-panel__number">{{ $corner['number'] }}</span>
                            <span class="hero-corner-panel__value">
                                <strong>{{ $cornerLabel }}</strong>
                                <span>{{ $cornerCopy }}</span>
                            </span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="home-hero__inner">
            <div class="home-hero__content" data-reveal>
                <p class="eyebrow">{{ $labels['home'] }}</p>
                <h1 id="home-hero-title">{{ $heroTitle }}</h1>
                @if ($heroSummary !== '')
                    <p class="lead">{{ $heroSummary }}</p>
                @endif
                @include('public.partials.body', ['body' => $heroBody])
                <div class="action-row">
                    <a class="button button--primary" href="{{ url("/{$locale}/contact") }}">{{ $labels['contact'] }}</a>
                    <a class="button button--secondary" href="{{ url("/{$locale}/contact") }}">{{ $labels['partner_with_us'] }}</a>
                    <a class="button button--text" href="{{ url("/{$locale}/programs") }}">{{ $labels['explore_programs'] }}</a>
                </div>
            </div>
        </div>
    </section>
```

- [ ] **Step 7: Add five-corner hero CSS**

In `resources/css/app.css`, replace the `.home-hero--editorial` rules and its child rules with the new `.home-hero--corners` family. Include these exact blocks:

```css
    .home-hero--corners {
        position: relative;
        isolation: isolate;
        display: grid;
        align-items: end;
        min-block-size: 100svh;
        overflow: hidden;
        background: var(--color-pine-900);
        color: var(--color-white);
    }

    .hero-corners__backdrop {
        position: absolute;
        z-index: -2;
        inset: 0;
        background: var(--color-pine-900);
    }

    .hero-corners__panels {
        display: flex;
        block-size: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .hero-corner-panel {
        position: relative;
        isolation: isolate;
        flex: 1 1 0;
        overflow: hidden;
        background-color: var(--color-pine-900);
        background-image: var(--corner-image-fallback);
        background-image: var(--corner-image);
        background-position: center;
        background-size: cover;
        transition: flex-grow 820ms cubic-bezier(0.16, 1, 0.3, 1), opacity 420ms ease;
    }

    .hero-corner-panel::before {
        content: "";
        position: absolute;
        z-index: -1;
        inset: 0;
        background: rgb(8 15 12 / 52%);
        transition: background 520ms ease;
    }

    .hero-corner-panel::after {
        content: "";
        position: absolute;
        inset-block: 0;
        inset-inline-start: 0;
        inline-size: 4px;
        background: var(--corner-color);
        transform: scaleY(0.2);
        transform-origin: bottom;
        transition: transform 520ms ease;
    }

    .hero-corner-panel:hover,
    .hero-corner-panel:focus-within {
        flex-grow: 2.35;
    }

    .hero-corner-panel:hover::before,
    .hero-corner-panel:focus-within::before {
        background: rgb(8 15 12 / 34%);
    }

    .hero-corner-panel:hover::after,
    .hero-corner-panel:focus-within::after {
        transform: scaleY(1);
    }

    .hero-corner-panel__button {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: flex-end;
        inline-size: 100%;
        block-size: 100%;
        padding: clamp(18px, 2vw, 32px);
        border: 0;
        background: transparent;
        color: var(--color-white);
        cursor: pointer;
        text-align: start;
    }

    .hero-corner-panel__number {
        position: absolute;
        inset-block-start: clamp(96px, 12vh, 150px);
        inset-inline-start: clamp(18px, 2vw, 30px);
        font-size: 0.75rem;
        font-weight: 900;
        letter-spacing: 0.18em;
        opacity: 0.62;
    }

    .hero-corner-panel__value {
        display: grid;
        gap: 8px;
        max-inline-size: 260px;
        opacity: 0;
        transform: translateY(18px);
        transition: opacity 420ms ease, transform 520ms cubic-bezier(0.16, 1, 0.3, 1);
    }

    .hero-corner-panel__value strong {
        color: var(--color-white);
        font-size: clamp(1.35rem, 2.4vw, 2.35rem);
        line-height: 1;
    }

    .hero-corner-panel__value span {
        color: rgb(255 255 255 / 78%);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .hero-corner-panel:hover .hero-corner-panel__value,
    .hero-corner-panel:focus-within .hero-corner-panel__value {
        opacity: 1;
        transform: translateY(0);
    }
```

Keep `.home-hero__inner`, `.home-hero__content`, and hero text styles, but update them so they sit above the panels:

```css
    .home-hero__inner {
        position: relative;
        z-index: 2;
        width: min(100% - (var(--layout-gutter) * 2), var(--layout-wide));
        margin-inline: auto;
        padding-block: clamp(130px, 18vh, 220px) clamp(48px, 8vh, 92px);
    }
```

Under `@media (max-width: 820px)`, include:

```css
    .home-hero--corners {
        min-block-size: auto;
        padding-block-start: 82px;
    }

    .hero-corners__backdrop {
        position: relative;
        order: 2;
        min-block-size: auto;
    }

    .hero-corners__panels {
        display: grid;
        grid-template-columns: 1fr;
    }

    .hero-corner-panel {
        min-block-size: 176px;
        flex: none;
    }

    .hero-corner-panel__value {
        opacity: 1;
        transform: none;
    }

    .home-hero__inner {
        padding-block: 44px 32px;
    }
```

- [ ] **Step 8: Remove old hero image dependency from home tests**

Run:

```bash
rg -n "home-hero--editorial|gilwellsyria-hero-training.webp|gilwellsyria-hero-training.png" tests/Feature resources/views/public/home.blade.php
```

Expected: no matches in tests or `home.blade.php`. The old assets may remain in `public/images/` as fallback/source history but must not be the active home hero.

- [ ] **Step 9: Run targeted green tests**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=five_corner_identity
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=optimized_corner_hero
scripts/dev-php artisan test tests/Feature/PublicVisualCssTest.php --filter=five_corner_hero
```

Expected: all PASS.

- [ ] **Step 10: Run public visual tests**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php tests/Feature/PublicVisualCssTest.php tests/Feature/PublicAssetTest.php
```

Expected: PASS.

- [ ] **Step 11: Commit Task 3**

Run:

```bash
git add tests/Feature/PublicSiteTest.php tests/Feature/PublicVisualCssTest.php \
  resources/views/public/home.blade.php resources/css/app.css \
  AGENT_LOG.md LIVE_STATUS.md
git commit -m "feat: build five corner public hero"
```

Expected: commit includes only Task 3 files.

## Task 4: Tactile Motion System And Scroll Reveal

**Files:**
- Modify: `tests/Feature/PublicSiteTest.php`
- Modify: `tests/Feature/PublicVisualCssTest.php`
- Modify: `resources/views/public/home.blade.php`
- Modify: `resources/views/public/partials/record-card.blade.php`
- Modify: `resources/views/public/partials/metric-card.blade.php`
- Modify: `resources/views/public/partials/media-frame.blade.php`
- Modify: `resources/views/public/layout.blade.php`
- Modify: `resources/css/app.css`
- Modify: `resources/js/app.js`
- Modify: `AGENT_LOG.md`
- Modify: `LIVE_STATUS.md`

**Interfaces:**
- Consumes: header/hero hooks from Tasks 2 and 3.
- Produces: `data-reveal`, `.reveal`, `.is-visible`, tactile hover/focus CSS for buttons/nav/cards/metrics/partners.

- [ ] **Step 1: Add failing motion CSS contract test**

Add this method to `tests/Feature/PublicVisualCssTest.php` after `test_five_corner_hero_has_interactive_panel_contract()`:

```php
    public function test_motion_system_adds_tactile_hover_focus_and_reduced_motion_contracts(): void
    {
        $css = $this->normalizedCss();

        $root = $this->block($css, ':root');
        $this->assertStringContainsString('--motion-fast: 180ms;', $root);
        $this->assertStringContainsString('--motion-medium: 320ms;', $root);
        $this->assertStringContainsString('--motion-slow: 820ms;', $root);
        $this->assertStringContainsString('--ease-out: cubic-bezier(0.16, 1, 0.3, 1);', $root);

        $button = $this->block($css, '.button');
        $this->assertStringContainsString('transition:', $button);

        $buttonHover = $this->block($css, '.button:hover, .button:focus-visible');
        $this->assertStringContainsString('transform: translateY(-2px);', $buttonHover);

        $navAfter = $this->block($css, '.site-nav__link::after');
        $this->assertStringContainsString('transform: scaleX(0);', $navAfter);

        $cardHover = $this->block($css, '.content-card:hover, .content-card:focus-within');
        $this->assertStringContainsString('transform: translateY(-6px);', $cardHover);

        $mediaHover = $this->block($css, '.content-card:hover .media-frame__image, .content-card:focus-within .media-frame__image');
        $this->assertStringContainsString('transform: scale(1.045);', $mediaHover);

        $reveal = $this->block($css, '[data-reveal]');
        $this->assertStringContainsString('opacity: 0;', $reveal);
        $this->assertStringContainsString('transform: translateY(26px);', $reveal);

        $visible = $this->block($css, '[data-reveal].is-visible');
        $this->assertStringContainsString('opacity: 1;', $visible);
        $this->assertStringContainsString('transform: none;', $visible);

        $reduced = $this->block($css, '@media (prefers-reduced-motion: reduce)');
        $this->assertStringContainsString('animation-duration: 0.01ms !important;', $reduced);
        $this->assertStringContainsString('transition-duration: 0.01ms !important;', $reduced);
    }
```

- [ ] **Step 2: Add failing reveal markup test**

Add this method to `tests/Feature/PublicSiteTest.php` after the five-corner hero test:

```php
    public function test_home_marks_major_content_for_scroll_reveal(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/en')
            ->assertOk()
            ->assertSee('data-reveal', false)
            ->assertSee('class="content-card', false)
            ->assertSee('class="metric-card metric-card--proof"', false)
            ->assertSee('class="partner-tile"', false);
    }
```

- [ ] **Step 3: Run targeted red tests**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicVisualCssTest.php --filter=motion_system
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=marks_major_content
```

Expected: CSS test FAILS because motion tokens/reveal contracts are missing or incomplete. Markup test may pass if Task 3 already added one `data-reveal`; if it passes immediately, add the missing assertions listed in Step 4 before implementation and rerun.

- [ ] **Step 4: Add reveal hooks to repeated public components**

In `resources/views/public/partials/record-card.blade.php`, replace:

```blade
<article class="content-card {{ $cardClass }}">
```

with:

```blade
<article class="content-card {{ $cardClass }}" data-reveal>
```

In `resources/views/public/partials/metric-card.blade.php`, replace:

```blade
<article class="metric-card metric-card--proof">
```

with:

```blade
<article class="metric-card metric-card--proof" data-reveal>
```

In `resources/views/public/home.blade.php`, add `data-reveal` to section headers where repeated cards do not already provide it:

```blade
        <div class="section__header" data-reveal>
```

Use this for the credibility strip, program feature, partner wall, gallery feature, and content-feed headers.

- [ ] **Step 5: Extend JavaScript for scroll reveal**

Append this code to the end of `resources/js/app.js`:

```js
const revealTargets = document.querySelectorAll('[data-reveal]');

if (revealTargets.length > 0) {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) {
        revealTargets.forEach((target) => target.classList.add('is-visible'));
    } else {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '0px 0px -8% 0px',
            threshold: 0.14,
        });

        revealTargets.forEach((target) => revealObserver.observe(target));
    }
}
```

- [ ] **Step 6: Add motion CSS**

In `:root`, add:

```css
        --motion-fast: 180ms;
        --motion-medium: 320ms;
        --motion-slow: 820ms;
        --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
```

Update `.button`:

```css
        transition: transform var(--motion-fast) var(--ease-out), background var(--motion-medium) ease, border-color var(--motion-medium) ease, color var(--motion-medium) ease, box-shadow var(--motion-medium) ease;
```

Add:

```css
    .button:hover,
    .button:focus-visible {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgb(17 24 39 / 14%);
    }

    .button:active {
        transform: translateY(0);
    }

    .site-nav__link {
        position: relative;
    }

    .site-nav__link::after {
        content: "";
        position: absolute;
        inset-inline: 10px;
        inset-block-end: -1px;
        block-size: 3px;
        background: var(--color-gold-500);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform var(--motion-medium) var(--ease-out);
    }

    [dir="rtl"] .site-nav__link::after {
        transform-origin: right;
    }

    .site-nav__link:hover::after,
    .site-nav__link:focus-visible::after,
    .site-nav__link.is-active::after {
        transform: scaleX(1);
    }

    .content-card,
    .metric-card,
    .partner-tile,
    .gallery-item,
    .contact-block {
        transition: transform var(--motion-medium) var(--ease-out), border-color var(--motion-medium) ease, box-shadow var(--motion-medium) ease;
    }

    .content-card:hover,
    .content-card:focus-within {
        transform: translateY(-6px);
        border-color: rgb(220 168 74 / 68%);
        box-shadow: 0 22px 54px rgb(17 24 39 / 13%);
    }

    .media-frame__image {
        transition: transform var(--motion-slow) var(--ease-out);
    }

    .content-card:hover .media-frame__image,
    .content-card:focus-within .media-frame__image {
        transform: scale(1.045);
    }

    .metric-card:hover,
    .metric-card:focus-within,
    .partner-tile:hover,
    .partner-tile:focus-within {
        transform: translateY(-4px);
        border-color: rgb(220 168 74 / 72%);
    }

    [data-reveal] {
        opacity: 0;
        transform: translateY(26px);
        transition: opacity 720ms var(--ease-out), transform 720ms var(--ease-out);
    }

    [data-reveal].is-visible {
        opacity: 1;
        transform: none;
    }
```

In the existing `@media (prefers-reduced-motion: reduce)` block, keep `animation-duration` and `transition-duration` overrides and add:

```css
        [data-reveal] {
            opacity: 1 !important;
            transform: none !important;
        }
```

- [ ] **Step 7: Run targeted green tests**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicVisualCssTest.php --filter=motion_system
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=marks_major_content
```

Expected: both PASS.

- [ ] **Step 8: Run public tests and build**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php tests/Feature/PublicVisualCssTest.php
npm run build
```

Expected: tests PASS and build PASS. The optional `fontaine` warning is acceptable.

- [ ] **Step 9: Commit Task 4**

Run:

```bash
git add tests/Feature/PublicSiteTest.php tests/Feature/PublicVisualCssTest.php \
  resources/views/public/home.blade.php resources/views/public/partials/record-card.blade.php \
  resources/views/public/partials/metric-card.blade.php resources/views/public/partials/media-frame.blade.php \
  resources/views/public/layout.blade.php resources/css/app.css resources/js/app.js \
  AGENT_LOG.md LIVE_STATUS.md
git commit -m "feat: add tactile public motion"
```

Expected: commit includes only Task 4 files.

## Task 5: Durable Documentation And Final Verification

**Files:**
- Modify: `docs/design/brand-system.md`
- Modify: `docs/design/stitch-prompts.md`
- Modify: `AGENT_LOG.md`
- Modify: `DECISIONS.md`
- Modify: `LIVE_STATUS.md`

**Interfaces:**
- Consumes: all prior tasks.
- Produces: durable guidance for future agents and final acceptance ledger.

- [ ] **Step 1: Add documentation red check**

Run:

```bash
if rg -n "five-corner cinematic hero|burger menu|tactile motion|hero-corners" docs/design; then
  exit 1
else
  exit 0
fi
```

Expected: PASS as a red check, meaning the required new guidance is absent before this task.

- [ ] **Step 2: Update brand system guidance**

Append this section to `docs/design/brand-system.md`:

```markdown
## Identity Motion Addendum

The accepted second visual revision uses a five-corner cinematic hero built
from realistic scout-panel photography: Merit, Discipline, Honor, Tenacity, and
Loyalty. The default hero state should be quiet and image-led; value labels and
meanings become prominent on hover and keyboard focus.

The public header should feel integrated with the hero, not like a government
navigation bar. Use a transparent brand-mark treatment derived from the
approved logo, animated nav underline states, and a paper/backdrop state after
scroll.

Mobile navigation must use an accessible burger menu with a stacked panel. Do
not use horizontal scrolling nav for the primary mobile menu.

Buttons, cards, metrics, partner tiles, and hero panels need visible hover,
focus, and press feedback. Keep motion restrained, respect
`prefers-reduced-motion`, and avoid decorative orb/blob background systems.
```

- [ ] **Step 3: Update Stitch prompts guidance**

Add this section near the top of `docs/design/stitch-prompts.md`:

```markdown
## Identity Motion Revision Prompt

Create a premium bilingual GilwellSyria homepage inspired by a cinematic
five-corner identity system, not a government website. The hero should use five
vertical realistic scout photography panels for Merit, Discipline, Honor,
Tenacity, and Loyalty. Default state is quiet and image-led; hover/focus makes a
panel expand and reveal the value name, short meaning, and color accent.

Use a transparent-feeling logo treatment derived from the approved mark, a
strong editorial GilwellSyria wordmark, tactile hover/press button states,
animated nav underline states, cards that lift subtly on hover, and scroll
reveal motion. Mobile uses a burger menu with stacked links, never a horizontal
scrolling navbar. Preserve English LTR and Arabic RTL quality. No donation UI
and no public contact form.
```

- [ ] **Step 4: Add final acceptance decision**

Append this line inside the code block in `DECISIONS.md`:

```text
2026-07-22 | D-014 | Mastermind | Public identity motion implementation | Accept the five-corner identity hero, transparent brand treatment, accessible burger menu, and tactile motion system as the next public visual baseline | Final verification confirmed the site no longer feels like a static government page and preserves tests, build, routing, bilingual behavior, and no donation/form boundaries | Keep single-photo hero, boxed logo header, horizontal mobile nav, static buttons/cards | Future public design work should build on the five-corner hero and motion tokens rather than reintroducing static CMS-scaffold styling
```

- [ ] **Step 5: Run full PHP tests**

Run:

```bash
scripts/dev-php artisan test
```

Expected: PASS.

- [ ] **Step 6: Run production build**

Run:

```bash
npm run build
```

Expected: PASS. The optional `fontaine` warning is acceptable.

- [ ] **Step 7: Verify route cache**

Run:

```bash
scripts/dev-php artisan route:cache
scripts/dev-php artisan route:clear
```

Expected:

```text
INFO  Routes cached successfully.
INFO  Route cache cleared successfully.
```

- [ ] **Step 8: Reseed local dev database**

Run:

```bash
scripts/dev-php artisan migrate:fresh --seed --force
```

Expected:

```text
Seeded local CMS users: admin@gilwellsyria.local / password, editor@gilwellsyria.local / password
Seeded starter program: leadership-training
```

- [ ] **Step 9: Start or reuse a worktree-local HTTP server**

If no worktree-local server is running on `127.0.0.1:8001`, run:

```bash
docker run --rm --publish 127.0.0.1:8001:8001 --user "$(id -u):$(id -g)" \
  --env COMPOSER_HOME=/tmp/composer --env APP_ENV=local \
  --env APP_KEY="base64:$(openssl rand -base64 32)" \
  --volume "$PWD:/app" --workdir /app gilwell-syria-php \
  php artisan serve --host=0.0.0.0 --port=8001
```

Expected: server responds at `http://127.0.0.1:8001`.

- [ ] **Step 10: Run HTTP smoke checks**

Run:

```bash
curl -I -s http://127.0.0.1:8001/ | sed -n '1,8p'
curl -s http://127.0.0.1:8001/en | rg -n "home-hero--corners|hero-corner-panel|data-menu-toggle|GilwellSyria|Contact us|Donate|donation|<form"
curl -s http://127.0.0.1:8001/ar | rg -n "home-hero--corners|hero-corner-panel|data-menu-toggle|جيلويل سوريا|تواصل معنا|Donate|donation|<form"
curl -I -s http://127.0.0.1:8001/fr | sed -n '1,6p'
curl -s http://127.0.0.1:8001/admin/login | rg -n "Login|Sign in|Email address|Password"
```

Expected:

- `/` returns `302` with `Location: /en`.
- `/en` includes `home-hero--corners`, `hero-corner-panel`, `data-menu-toggle`, `GilwellSyria`, and `Contact us`, with no active `Donate`, `donation`, or public `<form` match.
- `/ar` includes `home-hero--corners`, `hero-corner-panel`, `data-menu-toggle`, `جيلويل سوريا`, and `تواصل معنا`, with no active `Donate`, `donation`, or public `<form` match.
- `/fr` returns `404`.
- `/admin/login` includes login, sign-in, email, and password text.

- [ ] **Step 11: Capture visual evidence**

Use Playwright if available, otherwise system browser screenshot support:

```bash
npx playwright screenshot --viewport-size=1440,900 http://127.0.0.1:8001/en /tmp/gilwell-identity-en-1440.png
npx playwright screenshot --viewport-size=1920,1080 http://127.0.0.1:8001/en /tmp/gilwell-identity-en-1920.png
npx playwright screenshot --viewport-size=390,844 http://127.0.0.1:8001/en /tmp/gilwell-identity-en-390.png
npx playwright screenshot --viewport-size=390,844 http://127.0.0.1:8001/ar /tmp/gilwell-identity-ar-390.png
```

If Playwright browsers are unavailable, use the installed system browser and save equivalent screenshots under `/tmp`.

Expected visual checks:

- Header no longer looks like a government navbar.
- Logo no longer appears boxed inside a white tile.
- Mobile nav is a burger menu, not a horizontal scrolling primary nav.
- Hero clearly presents five Gilwell value panels.
- Buttons and cards have visible hover/focus interaction when inspected.
- English and Arabic mobile have no overlapping controls or text.

- [ ] **Step 12: Run forbidden-pattern and whitespace scans**

Run:

```bash
rg -n "Donate|donation|<form|orb|blob" app database resources routes tests docs/design docs/superpowers README.md DECISIONS.md AGENT_LOG.md
if rg -n "overflow-x: auto" resources/css/app.css resources/views/public; then exit 1; fi
git diff --check
git status --short
```

Expected:

- `Donate`, `donation`, and `<form` appear only in negative tests, docs that reject those features, or historical ledger entries.
- `orb` and `blob` appear only in docs that reject those features.
- No active public mobile nav uses `overflow-x: auto`.
- `git diff --check` exits with no output.
- `git status --short` shows only intended final docs/ledger updates before the final commit.

- [ ] **Step 13: Commit Task 5**

Run:

```bash
git add docs/design/brand-system.md docs/design/stitch-prompts.md \
  AGENT_LOG.md DECISIONS.md LIVE_STATUS.md
git commit -m "docs: accept identity motion redesign"
```

Expected: commit succeeds and includes only Task 5 files.

## Final Review Gate

After Task 5, run a broad whole-branch review against the branch base using the `superpowers:requesting-code-review` workflow.

The reviewer must specifically check:

- Five-corner hero implementation meets the approved identity spec.
- Mobile navigation is an accessible burger menu, not horizontal scrolling nav.
- Header brand treatment no longer boxes the logo.
- Motion is tactile but respects `prefers-reduced-motion`.
- Hero-corner assets are optimized and not delivered as five large PNGs.
- `/en` and `/ar` remain equal quality.
- No donation/form/backend/schema scope was introduced.

If the reviewer finds Critical or Important issues, dispatch one focused fix pass and re-review before presenting integration options.
