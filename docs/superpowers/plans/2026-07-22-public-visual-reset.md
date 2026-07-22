# Public Visual Reset Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Redesign the GilwellSyria public site into a very-wide, premium, bilingual nonprofit experience with a strong documentary-style hero and polished responsive grids.

**Architecture:** Keep the current Laravel Blade public frontend and CMS data model. Implement the visual reset through one generated public image asset, markup hooks in existing public Blade views, a rebuilt CSS layout system in `resources/css/app.css`, updated design documentation, and focused regression tests. Backend/admin behavior remains unchanged.

**Tech Stack:** Laravel 13, Blade, Vite, Tailwind CSS entry file with custom CSS layers, PHPUnit feature tests, Docker-backed PHP helper scripts in `scripts/dev-php`, npm/Vite build.

## Global Constraints

- Main wide container: `min(100% - responsive gutters, 1680px)`.
- Reading container: about `760px` to `860px`.
- Dense card grids: 5 columns on very wide screens, 4 columns on normal desktop, 2 columns on tablet, 1 column on mobile.
- Hero image direction: documentary-style nonprofit photography of young adults in a leadership training workshop in Syria or the Levant region, mixed group, outdoor or community-center setting, natural daylight, warm but realistic colors, mentors facilitating a small group activity, credible community-service atmosphere, no visible text, no logos, no flags, no exaggerated uniforms, no staged corporate stock look.
- No donation flow, donation CTA, or donation settings.
- No public contact form.
- No backend schema redesign.
- No decorative SVG/orb/gradient-blob visual system.
- Home H1 should be `GilwellSyria` or the active localized site name, not `Home`.
- Public URLs remain locale-prefixed: `/en` and `/ar`.
- Preserve equal-quality English LTR and Arabic RTL experiences.

---

## File Structure

- Create `public/images/gilwellsyria-hero-training.png`: generated documentary-style hero image used by the public home page.
- Modify `resources/views/public/home.blade.php`: replace logo-box hero markup, expose hero image CSS variable, add credibility strip, add wide grid class hooks, make H1 use site name.
- Modify `resources/views/public/partials/page-hero.blade.php`: add structural class hooks for stronger shared page heroes.
- Modify `resources/views/public/partials/media-frame.blade.php`: rename the empty media class hook to match the visual reset language.
- Modify `resources/views/public/partials/record-card.blade.php`: add optional compact/media/card class hooks without changing consumer data contracts.
- Modify `resources/views/public/partials/metric-card.blade.php`: add class hook for wide credibility-strip metric cells.
- Modify `resources/views/public/programs/index.blade.php`, `gallery/index.blade.php`, `news/index.blade.php`, `events/index.blade.php`, `impact.blade.php`, `partners.blade.php`, `contact.blade.php`: apply wide/listing/logo/contact grid modifiers.
- Modify `resources/css/app.css`: introduce wide layout tokens, editorial hero, responsive grid system, polished cards, page heroes, contact blocks, partner wall, RTL-safe rules.
- Modify `tests/Feature/PublicSiteTest.php`: add markup-level regression tests for the visual reset.
- Create `tests/Feature/PublicVisualCssTest.php`: assert CSS contains the layout tokens and class hooks that protect the visual reset.
- Modify `docs/design/brand-system.md` and `docs/design/stitch-prompts.md`: update durable design guidance to match the approved reset.
- Modify `AGENT_LOG.md`, `DECISIONS.md`, `LIVE_STATUS.md`: record execution and final acceptance.

## Task 1: Hero Asset And Durable Design Guidance

**Files:**
- Create: `public/images/gilwellsyria-hero-training.png`
- Modify: `docs/design/brand-system.md`
- Modify: `docs/design/stitch-prompts.md`
- Modify: `AGENT_LOG.md`
- Modify: `LIVE_STATUS.md`

**Interfaces:**
- Produces: `asset('images/gilwellsyria-hero-training.png')`, consumed by `resources/views/public/home.blade.php`.
- Produces: updated design guidance consumed by frontend implementers and future Stitch prompts.

- [ ] **Step 1: Generate the hero image asset**

Use the image generation tool with this prompt:

```text
Documentary-style nonprofit photography of young adults in a leadership training workshop in Syria or the Levant region, mixed group of men and women in modest everyday clothing, outdoor courtyard or community-center setting, natural daylight, warm but realistic colors, mentors facilitating a small group activity around notebooks and training materials, credible community-service atmosphere, premium editorial nonprofit website hero image, landscape composition with usable open space for headline overlay, no visible text, no logos, no flags, no exaggerated uniforms, no staged corporate stock look.
```

Save the generated image as:

```text
public/images/gilwellsyria-hero-training.png
```

If the image tool returns a generated local file path, copy that generated file to the path above. If the worker cannot access an image generation tool or the tool does not expose a local file path, stop Task 1 and submit the exact prompt above to Mastermind as the required human/tool handoff.

- [ ] **Step 2: Verify the image file**

Run:

```bash
test -f public/images/gilwellsyria-hero-training.png
file public/images/gilwellsyria-hero-training.png
identify public/images/gilwellsyria-hero-training.png
```

Expected:

```text
public/images/gilwellsyria-hero-training.png: PNG image data
```

Expected `identify` result: the image is landscape and at least `1600x900`.

- [ ] **Step 3: Update the brand system design doc**

Append this section to `docs/design/brand-system.md` after `## Usage Guidance For Frontend` if that heading exists, otherwise append it at the end:

```markdown
## Visual Reset Addendum

The accepted public visual reset uses a very-wide editorial layout for desktop.
Use a main wide container around `1680px`, responsive gutters with
`clamp(20px, 4vw, 72px)`, and denser grids that can reach five columns when
card content remains readable.

The home hero must use a documentary-style youth leadership or community
training image as the primary visual signal. The logo remains in the header and
footer, not as the hero artwork. Hero text should sit over a readable scrim or
solid treatment that belongs to the same image field, not inside a separate
floating card.

The homepage should prioritize premium donor and partner credibility. Use a
strong credibility strip near the hero, polished program cards, a calm partner
logo wall, and scan-friendly news, gallery, and event modules.

Keep v1 contact-only: no public contact form, no donation UI, and no donation
language.
```

- [ ] **Step 4: Update the Stitch prompts**

In `docs/design/stitch-prompts.md`, add this prompt near the top under the status/introduction area:

```markdown
## Recommended Visual Reset Prompt

Create a premium bilingual public homepage for GilwellSyria, a youth leadership
and community service nonprofit in Syria. Use a very-wide editorial layout with
content expanding up to roughly 1680px on desktop. The first viewport must have
a strong documentary-style hero image of youth leadership training in a Syrian
or Levant community setting, with natural daylight, realistic nonprofit
photography, no visible text, no logos, and no flags. Place the GilwellSyria
logo only in the header and footer, not as the hero artwork.

The hero headline should identify GilwellSyria directly, with clear CTAs for
Contact us, Partner with us, and Explore programs. Build credibility through a
wide impact metric strip, polished program cards, a calm partner logo wall, and
dense but readable gallery/news/events modules. Use pine green, navy, warm paper,
and disciplined gold accents. Support equal English LTR and Arabic RTL layouts.
Do not include donation UI or a public contact form.
```

- [ ] **Step 5: Run design-doc verification**

Run:

```bash
rg -n "Visual Reset Addendum|Recommended Visual Reset Prompt|1680px|documentary-style hero|no public contact form|no donation UI" docs/design docs/superpowers/specs docs/superpowers/plans
git diff --check
```

Expected: each required phrase appears at least once in docs, and `git diff --check` exits with no output.

- [ ] **Step 6: Commit Task 1**

Run:

```bash
git add public/images/gilwellsyria-hero-training.png docs/design/brand-system.md docs/design/stitch-prompts.md AGENT_LOG.md LIVE_STATUS.md
git commit -m "design: add public hero direction"
```

Expected: commit succeeds and includes only Task 1 files.

## Task 2: Home Hero Markup And Public Regression Tests

**Files:**
- Modify: `tests/Feature/PublicSiteTest.php`
- Modify: `resources/views/public/home.blade.php`
- Modify: `AGENT_LOG.md`
- Modify: `LIVE_STATUS.md`

**Interfaces:**
- Consumes: `public/images/gilwellsyria-hero-training.png` from Task 1.
- Produces: `.home-hero--editorial`, `.home-hero__inner`, `.credibility-strip`, `.section--program-feature`, `.section--partner-wall`, `.section--content-feed` markup hooks consumed by Task 3 CSS.

- [ ] **Step 1: Add failing home visual-structure test**

Add this method to `tests/Feature/PublicSiteTest.php` after `test_home_renders_locale_language_direction_and_seeded_cms_content()`:

```php
    public function test_home_uses_visual_reset_hero_and_wide_section_hooks(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/en')
            ->assertOk()
            ->assertSee('class="home-hero home-hero--editorial"', false)
            ->assertSee('images/gilwellsyria-hero-training.png')
            ->assertSee('<h1>GilwellSyria</h1>', false)
            ->assertDontSee('<h1>Home</h1>', false)
            ->assertSee('class="credibility-strip"', false)
            ->assertSee('class="section section--program-feature"', false)
            ->assertSee('class="section section--partner-wall"', false)
            ->assertSee('class="section section--content-feed"', false);

        $this->get('/ar')
            ->assertOk()
            ->assertSee('class="home-hero home-hero--editorial"', false)
            ->assertSee('<h1>جيلويل سوريا</h1>', false)
            ->assertDontSee('<h1>الرئيسية</h1>', false);
    }
```

- [ ] **Step 2: Run the targeted red test**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=home_uses_visual_reset
```

Expected: FAIL because the current home page still uses the old hero classes and H1.

- [ ] **Step 3: Replace the home page top variables**

In `resources/views/public/home.blade.php`, replace the opening `@php` block with:

```blade
@php
    $siteName = $field($settings, 'site_name', 'GilwellSyria');
    $title = $field($page, 'seo_title', $siteName);
    $heroTitle = $siteName;
    $heroSummary = $field($settings, 'tagline', $field($page, 'summary'));
    $heroBody = $field($page, 'body');
    $heroImage = asset('images/gilwellsyria-hero-training.png');
@endphp
```

- [ ] **Step 4: Replace the home hero section**

In `resources/views/public/home.blade.php`, replace the first `<section class="home-hero">...</section>` block with:

```blade
    <section class="home-hero home-hero--editorial" style="--hero-image: url('{{ $heroImage }}')">
        <div class="home-hero__inner">
            <div class="home-hero__content">
                <p class="eyebrow">{{ $labels['home'] }}</p>
                <h1>{{ $heroTitle }}</h1>
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

- [ ] **Step 5: Update the home section class hooks**

In `resources/views/public/home.blade.php`, make these exact class changes:

```blade
<section class="section section--compact">
```

becomes:

```blade
<section class="credibility-strip">
```

The first later programs section:

```blade
<section class="section">
```

becomes:

```blade
<section class="section section--program-feature">
```

The partners section:

```blade
<section class="section section--band">
```

becomes:

```blade
<section class="section section--partner-wall">
```

The gallery section:

```blade
<section class="section">
```

becomes:

```blade
<section class="section section--gallery-feature">
```

The news/events split section:

```blade
<section class="section section--split">
```

becomes:

```blade
<section class="section section--content-feed">
```

- [ ] **Step 6: Run the targeted green test**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=home_uses_visual_reset
```

Expected: PASS.

- [ ] **Step 7: Run the public site test file**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php
```

Expected: PASS.

- [ ] **Step 8: Commit Task 2**

Run:

```bash
git add tests/Feature/PublicSiteTest.php resources/views/public/home.blade.php AGENT_LOG.md LIVE_STATUS.md
git commit -m "feat: rebuild public home hero"
```

Expected: commit succeeds and includes only Task 2 files.

## Task 3: Wide CSS Layout System And Card Polish

**Files:**
- Create: `tests/Feature/PublicVisualCssTest.php`
- Modify: `resources/css/app.css`
- Modify: `AGENT_LOG.md`
- Modify: `LIVE_STATUS.md`

**Interfaces:**
- Consumes: markup hooks from Task 2.
- Produces: wide layout tokens, editorial hero styles, responsive grid behavior, polished card styles, and RTL-safe responsive layout consumed by all public views.

- [ ] **Step 1: Add failing CSS structure test**

Create `tests/Feature/PublicVisualCssTest.php` with:

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicVisualCssTest extends TestCase
{
    public function test_css_contains_wide_visual_reset_system(): void
    {
        $css = file_get_contents(resource_path('css/app.css'));

        $this->assertStringContainsString('--layout-wide: 1680px', $css);
        $this->assertStringContainsString('--layout-gutter: clamp(20px, 4vw, 72px)', $css);
        $this->assertStringContainsString('.home-hero--editorial', $css);
        $this->assertStringContainsString('background-image: var(--hero-image)', $css);
        $this->assertStringContainsString('.credibility-strip', $css);
        $this->assertStringContainsString('.card-grid--compact', $css);
        $this->assertStringContainsString('.logo-grid--wide', $css);
        $this->assertStringNotContainsString('linear-gradient', $css);
    }
}
```

- [ ] **Step 2: Run the targeted red test**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicVisualCssTest.php
```

Expected: FAIL because the new CSS tokens and classes do not exist yet.

- [ ] **Step 3: Add wide layout tokens**

In `resources/css/app.css`, inside `:root`, add these variables after `--shadow-soft`:

```css
        --layout-wide: 1680px;
        --layout-reading: 820px;
        --layout-gutter: clamp(20px, 4vw, 72px);
        --shadow-card: 0 16px 40px rgb(17 24 39 / 7%);
        --shadow-hero: 0 28px 80px rgb(17 24 39 / 18%);
```

- [ ] **Step 4: Replace fixed container widths**

In `resources/css/app.css`, replace each public `width: min(100% - 64px, 1180px);` for `.site-header__inner`, `.section`, `.home-hero`, and `.site-footer__inner` with:

```css
        width: min(100% - (var(--layout-gutter) * 2), var(--layout-wide));
```

Keep narrow reading elements such as `.rich-text`, `.lead`, and `.section__header` constrained separately.

- [ ] **Step 5: Replace the old home hero CSS**

Remove the old `.home-hero`, `.home-hero__content`, `.home-hero__visual`, and `.home-hero__visual img` blocks. Add this block in the components layer:

```css
    .home-hero--editorial {
        position: relative;
        isolation: isolate;
        display: grid;
        align-items: end;
        min-block-size: min(82svh, 820px);
        width: 100%;
        margin-inline: auto;
        padding-block: clamp(92px, 12vh, 164px) clamp(56px, 8vh, 96px);
        overflow: hidden;
        background-color: var(--color-pine-900);
        background-image: var(--hero-image);
        background-position: center;
        background-size: cover;
        box-shadow: var(--shadow-hero);
    }

    .home-hero--editorial::before {
        content: "";
        position: absolute;
        z-index: -1;
        inset: 0;
        background: rgb(17 24 39 / 48%);
    }

    .home-hero__inner {
        width: min(100% - (var(--layout-gutter) * 2), var(--layout-wide));
        margin-inline: auto;
    }

    .home-hero__content {
        max-inline-size: 780px;
        color: var(--color-white);
    }

    .home-hero__content .eyebrow,
    .home-hero__content h1,
    .home-hero__content .lead,
    .home-hero__content .rich-text {
        color: var(--color-white);
    }

    .home-hero__content h1 {
        max-inline-size: 900px;
        margin-block-end: 20px;
        font-size: clamp(3rem, 6vw, 6.5rem);
        line-height: 0.98;
    }

    .home-hero__content .lead {
        max-inline-size: 680px;
        color: rgb(255 255 255 / 88%);
        font-size: clamp(1.15rem, 1.5vw, 1.55rem);
        line-height: 1.55;
    }

    .home-hero__content .rich-text {
        max-inline-size: 700px;
        margin-block: 18px 30px;
        color: rgb(255 255 255 / 84%);
    }

    .home-hero__content .button--secondary {
        border-color: rgb(255 255 255 / 76%);
        background: rgb(255 255 255 / 92%);
        color: var(--color-pine-900);
    }

    .home-hero__content .button--text {
        color: var(--color-white);
    }
```

- [ ] **Step 6: Add wide grid and credibility CSS**

Add this block near the existing grid/card rules:

```css
    .credibility-strip {
        width: min(100% - (var(--layout-gutter) * 2), var(--layout-wide));
        margin-inline: auto;
        padding-block: clamp(32px, 5vw, 64px);
    }

    .credibility-strip .section__header {
        max-inline-size: var(--layout-reading);
    }

    .card-grid {
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr));
    }

    .card-grid--compact {
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr));
    }

    .metric-grid {
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 240px), 1fr));
    }

    .logo-grid,
    .logo-grid--wide {
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr));
    }

    @media (min-width: 1500px) {
        .card-grid--compact {
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }

        .section--program-feature .card-grid,
        .section--listing .card-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .logo-grid--wide {
            grid-template-columns: repeat(6, minmax(0, 1fr));
        }
    }
```

- [ ] **Step 7: Polish card, metric, partner, and page hero CSS**

Replace the current `.content-card`, `.metric-card`, `.partner-tile`, `.contact-block`, and `.page-hero` rules with:

```css
    .page-hero {
        width: min(100% - (var(--layout-gutter) * 2), var(--layout-wide));
        margin-inline: auto;
        margin-block: 0 40px;
        padding-block: clamp(56px, 8vw, 112px) clamp(28px, 5vw, 56px);
        border-block-end: 1px solid var(--color-border);
    }

    .page-hero__content {
        max-inline-size: var(--layout-reading);
    }

    .content-card,
    .metric-card,
    .partner-tile,
    .gallery-item,
    .contact-block {
        border: 1px solid var(--color-border);
        border-radius: 8px;
        background: var(--color-white);
        box-shadow: var(--shadow-card);
    }

    .content-card {
        display: grid;
        grid-template-rows: auto 1fr;
        overflow: hidden;
        min-block-size: 100%;
    }

    .content-card__body {
        display: flex;
        flex-direction: column;
        padding: clamp(18px, 2vw, 26px);
    }

    .content-card__body p {
        color: var(--color-slate);
        line-height: 1.65;
    }

    .content-card__body .meta {
        margin-block-start: auto;
        color: var(--color-pine-700);
        font-weight: 800;
    }

    .media-frame {
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: var(--color-paper);
    }

    .media-frame__empty {
        display: grid;
        place-items: center;
        inline-size: 100%;
        block-size: 100%;
        padding: 24px;
        border-block-start: 5px solid var(--color-gold-500);
        background: var(--color-paper);
        color: var(--color-pine-900);
        font-weight: 900;
        text-align: center;
    }

    .metric-card {
        padding: clamp(24px, 3vw, 36px);
        border-block-start: 5px solid var(--color-gold-500);
    }

    .metric-card__value {
        margin-block-end: 8px;
        color: var(--color-navy-800);
        font-size: clamp(2.25rem, 4vw, 4rem);
        font-weight: 900;
        line-height: 1;
    }

    .metric-card__value span {
        display: block;
        margin-block-start: 6px;
        color: var(--color-slate);
        font-size: 1rem;
        line-height: 1.35;
    }

    .partner-tile {
        display: grid;
        gap: 14px;
        align-content: start;
        padding: 18px;
    }

    .partner-tile .media-frame {
        aspect-ratio: 1;
        border: 1px solid var(--color-border);
        border-radius: 8px;
        background: var(--color-white);
    }

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
        gap: 20px;
    }

    .contact-block {
        display: grid;
        gap: 8px;
        padding: clamp(22px, 2.5vw, 32px);
        border-block-start: 5px solid var(--color-gold-500);
    }
```

Keep existing link, heading, and media image rules that are not replaced by this block.

- [ ] **Step 8: Update responsive rules**

Replace the mobile width override:

```css
    .site-header__inner,
    .home-hero,
    .section,
    .site-footer__inner {
        width: min(100% - 32px, 1180px);
    }
```

with:

```css
    .site-header__inner,
    .section,
    .credibility-strip,
    .page-hero,
    .site-footer__inner {
        width: min(100% - 32px, var(--layout-wide));
    }
```

Add this mobile hero rule inside `@media (max-width: 820px)`:

```css
    .home-hero--editorial {
        min-block-size: min(78svh, 680px);
        padding-block: 88px 48px;
        background-position: center;
    }
```

- [ ] **Step 9: Run targeted CSS test**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicVisualCssTest.php
```

Expected: PASS.

- [ ] **Step 10: Run build**

Run:

```bash
npm run build
```

Expected: PASS. The optional `fontaine` warning is acceptable.

- [ ] **Step 11: Commit Task 3**

Run:

```bash
git add tests/Feature/PublicVisualCssTest.php resources/css/app.css AGENT_LOG.md LIVE_STATUS.md
git commit -m "feat: add wide public visual system"
```

Expected: commit succeeds and includes only Task 3 files.

## Task 4: Listing Pages, Shared Partials, And Contact Polish

**Files:**
- Modify: `tests/Feature/PublicSiteTest.php`
- Modify: `resources/views/public/partials/page-hero.blade.php`
- Modify: `resources/views/public/partials/media-frame.blade.php`
- Modify: `resources/views/public/partials/record-card.blade.php`
- Modify: `resources/views/public/partials/metric-card.blade.php`
- Modify: `resources/views/public/programs/index.blade.php`
- Modify: `resources/views/public/gallery/index.blade.php`
- Modify: `resources/views/public/news/index.blade.php`
- Modify: `resources/views/public/events/index.blade.php`
- Modify: `resources/views/public/impact.blade.php`
- Modify: `resources/views/public/partners.blade.php`
- Modify: `resources/views/public/contact.blade.php`
- Modify: `AGENT_LOG.md`
- Modify: `LIVE_STATUS.md`

**Interfaces:**
- Consumes: CSS class hooks from Task 3.
- Produces: consistent `.section--listing`, `.card-grid--compact`, `.logo-grid--wide`, `.contact-grid--wide`, and `.page-hero--substantial` markup for page-level polish.

- [ ] **Step 1: Add failing visual hooks test for listing/contact pages**

Add this method to `tests/Feature/PublicSiteTest.php` before `test_contact_page_shows_details_only_without_forms_or_donation_language()`:

```php
    public function test_listing_and_contact_pages_use_visual_reset_hooks(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/en/programs')
            ->assertOk()
            ->assertSee('class="section section--listing"', false)
            ->assertSee('class="card-grid card-grid--featured"', false)
            ->assertSee('class="page-hero page-hero--substantial"', false);

        $this->get('/en/gallery')
            ->assertOk()
            ->assertSee('class="card-grid card-grid--compact"', false);

        $this->get('/en/news')
            ->assertOk()
            ->assertSee('class="card-grid card-grid--compact"', false);

        $this->get('/en/events')
            ->assertOk()
            ->assertSee('class="card-grid card-grid--compact"', false);

        $this->get('/en/partners')
            ->assertOk()
            ->assertSee('class="logo-grid logo-grid--wide"', false);

        $this->get('/en/contact')
            ->assertOk()
            ->assertSee('class="contact-grid contact-grid--wide"', false);
    }
```

- [ ] **Step 2: Run the targeted red test**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=listing_and_contact_pages_use_visual_reset_hooks
```

Expected: FAIL because the current markup lacks those class hooks.

- [ ] **Step 3: Update shared page hero partial**

In `resources/views/public/partials/page-hero.blade.php`, replace:

```blade
<header class="page-hero">
```

with:

```blade
<header class="page-hero page-hero--substantial">
```

- [ ] **Step 4: Update shared record card partial**

In `resources/views/public/partials/record-card.blade.php`, add this default variable guard after the existing defaults:

```blade
    if (! isset($cardClass)) {
        $cardClass = '';
    }
```

Then replace:

```blade
<article class="content-card">
```

with:

```blade
<article class="content-card {{ $cardClass }}">
```

- [ ] **Step 5: Update media and metric partial class hooks**

In `resources/views/public/partials/media-frame.blade.php`, change the empty-media `<div>` inside the `@else` branch to:

```blade
<div class="media-frame__empty" aria-hidden="true">
```

In `resources/views/public/partials/metric-card.blade.php`, replace:


```blade
<article class="metric-card">
```

with:

```blade
<article class="metric-card metric-card--proof">
```

- [ ] **Step 6: Update listing section and grid classes**

Make these replacements:

In `resources/views/public/programs/index.blade.php`:

```blade
<section class="section">
```

becomes:

```blade
<section class="section section--listing">
```

and:

```blade
<div class="card-grid">
```

becomes:

```blade
<div class="card-grid card-grid--featured">
```

In `resources/views/public/gallery/index.blade.php`, `news/index.blade.php`, and `events/index.blade.php`, replace:

```blade
<section class="section">
```

with:

```blade
<section class="section section--listing">
```

and replace:

```blade
<div class="card-grid">
```

with:

```blade
<div class="card-grid card-grid--compact">
```

- [ ] **Step 7: Update impact, partners, and contact classes**

In `resources/views/public/impact.blade.php`, replace the outer section with:

```blade
<section class="section section--impact-report">
```

In `resources/views/public/partners.blade.php`, replace:

```blade
<section class="section">
```

with:

```blade
<section class="section section--partner-wall">
```

Replace the partners card grid block:

```blade
<div class="card-grid">
```

with:

```blade
<div class="logo-grid logo-grid--wide">
```

In `resources/views/public/contact.blade.php`, replace:

```blade
<section class="section">
```

with:

```blade
<section class="section section--contact">
```

and:

```blade
<div class="contact-grid">
```

with:

```blade
<div class="contact-grid contact-grid--wide">
```

- [ ] **Step 8: Run targeted green test**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php --filter=listing_and_contact_pages_use_visual_reset_hooks
```

Expected: PASS.

- [ ] **Step 9: Run public tests**

Run:

```bash
scripts/dev-php artisan test tests/Feature/PublicSiteTest.php tests/Feature/PublicVisualCssTest.php
```

Expected: PASS.

- [ ] **Step 10: Commit Task 4**

Run:

```bash
git add tests/Feature/PublicSiteTest.php resources/views/public AGENT_LOG.md LIVE_STATUS.md
git commit -m "feat: polish public listing pages"
```

Expected: commit succeeds and includes only Task 4 files.

## Task 5: Final Visual Verification And Acceptance

**Files:**
- Modify: `AGENT_LOG.md`
- Modify: `DECISIONS.md`
- Modify: `LIVE_STATUS.md`

**Interfaces:**
- Consumes: all prior tasks.
- Produces: final verified visual reset commit state.

- [ ] **Step 1: Run full PHP tests**

Run:

```bash
scripts/dev-php artisan test
```

Expected:

```text
Tests:    34 passed
```

The exact assertion count may be higher than the previous `236` because this plan adds tests.

- [ ] **Step 2: Run production build**

Run:

```bash
npm run build
```

Expected: PASS. The optional `fontaine` warning is acceptable.

- [ ] **Step 3: Verify routes still cache**

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

- [ ] **Step 4: Reseed local dev database**

Run:

```bash
scripts/dev-php artisan migrate:fresh --seed
```

Expected: migrations complete and seeder prints:

```text
Seeded local CMS users: admin@gilwellsyria.local / password, editor@gilwellsyria.local / password
Seeded starter program: leadership-training
```

- [ ] **Step 5: Run HTTP smoke checks**

Run:

```bash
curl -I -s http://localhost:8000/ | sed -n '1,8p'
curl -s http://localhost:8000/en | rg -n "home-hero--editorial|GilwellSyria|Contact us|Leadership Training|Donate|donation|<form"
curl -s http://localhost:8000/ar | rg -n "home-hero--editorial|جيلويل سوريا|تواصل معنا|Donate|donation|<form"
curl -I -s http://localhost:8000/fr | sed -n '1,6p'
curl -s http://localhost:8000/admin/login | rg -n "Login|Sign in|Email address|Password"
```

Expected:

- `/` returns `302` with `Location: /en`.
- `/en` includes `home-hero--editorial`, `GilwellSyria`, `Contact us`, and `Leadership Training`, with no active `Donate`, `donation`, or public `<form` match.
- `/ar` includes `home-hero--editorial`, `جيلويل سوريا`, and `تواصل معنا`, with no active `Donate`, `donation`, or public `<form` match.
- `/fr` returns `404`.
- `/admin/login` includes login, sign-in, email, and password text.

- [ ] **Step 6: Capture visual evidence**

Run one of these command sets.

If Playwright browsers are installed:

```bash
npx playwright screenshot --viewport-size=1920,1080 http://localhost:8000/en /tmp/gilwell-visual-en-1920.png
npx playwright screenshot --viewport-size=1440,900 http://localhost:8000/en /tmp/gilwell-visual-en-1440.png
npx playwright screenshot --viewport-size=390,844 http://localhost:8000/ar /tmp/gilwell-visual-ar-390.png
```

If Playwright browsers are not installed and system Firefox is available:

```bash
firefox --headless --width 1920 --height 1080 --screenshot /tmp/gilwell-visual-en-1920.png http://localhost:8000/en
firefox --headless --width 1440 --height 900 --screenshot /tmp/gilwell-visual-en-1440.png http://localhost:8000/en
firefox --headless --width 390 --height 844 --screenshot /tmp/gilwell-visual-ar-390.png http://localhost:8000/ar
```

Expected visual checks:

- The 1920px home page no longer appears capped at the old 1180px width.
- Hero image fills the first viewport with readable text over it.
- A hint of the credibility strip appears below the hero on normal desktop.
- Grids expand to more columns on wide desktop.
- Arabic mobile view has no overlapping header, buttons, or hero text.

- [ ] **Step 7: Run forbidden-pattern and whitespace scans**

Run:

```bash
rg -n "Donate|donation|<form|linear-gradient|orb|blob" app database resources routes tests docs/design docs/superpowers README.md DECISIONS.md AGENT_LOG.md
git diff --check
git status --short
```

Expected:

- `Donate`, `donation`, and `<form` appear only in negative tests, docs that explicitly reject those features, or historical ledger entries.
- `linear-gradient`, `orb`, and `blob` do not appear in active public CSS or public views.
- `git diff --check` exits with no output.
- `git status --short` shows only intended final ledger updates before the final commit.

- [ ] **Step 8: Commit final acceptance ledgers**

Run:

```bash
git add AGENT_LOG.md DECISIONS.md LIVE_STATUS.md
git commit -m "docs: accept public visual reset"
```

Expected: commit succeeds if ledger files changed. If there are no ledger changes, record that in the final response and do not create an empty commit.

## Self-Review Notes

- Spec coverage: the plan covers hero image generation, wide layout, homepage hierarchy, cards/grids, page-level improvements, RTL checks, design docs/Stitch prompts, no donation/form scope, and final verification.
- Scope: one cohesive public visual reset. Backend schema and admin behavior are intentionally excluded.
- Type consistency: the plan defines the class hooks before CSS consumes them and uses existing Blade data helpers, existing labels, and existing public routes.
