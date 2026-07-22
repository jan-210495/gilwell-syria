# GilwellSyria Public Visual Reset Design

Status: Approved direction, awaiting implementation plan  
Owner: Mastermind  
Date: 2026-07-22  
Scope: Public frontend visual reset, design docs, Stitch prompts, and image strategy

## Context

The first working Laravel/Livewire/Filament foundation is technically sound,
but the public UI is not visually strong enough. The current frontend feels
narrow and plain on desktop because most containers are capped at `1180px`,
homepage grids are fixed at three or four columns, and the hero uses the logo as
a framed visual block instead of creating a credible first impression.

The user approved a full visual reset with these priorities:

- Premium donor and partner credibility first.
- Modern youth and community energy second.
- A good hero using a documentary-style generated training/community image.
- Very-wide desktop layout rather than the current narrow frame.
- No donation UI and no public contact form in v1.

## Goals

- Make the home page look like a polished public nonprofit site, not a basic CMS
  scaffold.
- Stretch desktop layouts to a very-wide content system around `1600px` to
  `1720px` where the content supports it.
- Replace the current logo-box hero with a strong documentary-style hero.
- Improve hierarchy, card quality, section rhythm, grid behavior, and bilingual
  polish.
- Keep the existing CMS models, routes, public content filtering, and admin
  behavior intact unless a small seed image path update is needed.
- Preserve equal-quality English LTR and Arabic RTL experiences.

## Non-Goals

- No donation flow, donation CTA, or donation settings.
- No public contact form.
- No backend schema redesign.
- No new public routes beyond existing `/en` and `/ar` page structure.
- No decorative SVG/orb/gradient-blob visual system.
- No logo redesign.

## Visual Direction

The redesign should feel established, editorial, and partner-ready. It should
use the existing logo-derived palette, but reduce the flat "green plus white
cards" feel. Pine and navy should carry institutional weight, gold should be a
disciplined accent, and red or purple should appear only as small category cues
when useful.

The public site should use more confident white space and stronger content
hierarchy. Page sections can use full-width bands or unframed layouts, but
individual repeated items such as programs, news, albums, partners, events, and
metrics can remain cards with a maximum `8px` radius.

## Layout System

Introduce a wider layout scale:

- Main wide container: `min(100% - responsive gutters, 1680px)`.
- Reading container: about `760px` to `860px`.
- Dense card grids: 5 columns on very wide screens, 4 columns on normal desktop,
  2 columns on tablet, 1 column on mobile.
- Editorial feature areas: 2 to 3 columns depending on content.
- Gutters: use responsive CSS such as `clamp(20px, 4vw, 72px)`.

Avoid locking every section to the same narrow max width. Sections should choose
the width that matches their job:

- Hero and credibility strips use the wide container.
- Reading-heavy pages use a narrower content measure inside the wide shell.
- Listing pages and logo walls use the wide container.
- Detail pages can combine a wide media area with a narrower body column.

## Home Hero

The home hero is the highest priority.

Replace the current split logo-box hero with a wide editorial hero that uses a
documentary-style image as the primary visual signal. The hero should not place
the main content inside a card and should not use a detached side-by-side image
panel. Use the image as a full-bleed or near-full-bleed background area, with
headline and actions sitting on a readable solid/scrim treatment that remains
part of the same hero field.

The first viewport must clearly identify the organization:

- Home H1 should be `GilwellSyria` or the active localized site name, not
  `Home`.
- Supporting copy should use the CMS tagline and home summary/body if present.
- Primary CTA: `Contact us`.
- Secondary CTA: `Partner with us`.
- Tertiary CTA: `Explore programs`.
- The logo remains in the header and footer; it is not the hero artwork.
- The hero should leave a hint of the next section visible on common desktop and
  mobile viewports.

Hero image direction:

```text
Documentary-style nonprofit photography of young adults in a leadership training
workshop in Syria or the Levant region, mixed group, outdoor or community-center
setting, natural daylight, warm but realistic colors, mentors facilitating a
small group activity, credible community-service atmosphere, no visible text, no
logos, no flags, no exaggerated uniforms, no staged corporate stock look.
```

During implementation, generate one image asset from this direction and store it
under `public/images/`. Prefer a landscape crop that works for wide desktop and
can be safely center-cropped on mobile.

## Homepage Sections

The homepage should have clearer hierarchy and fewer same-looking modules.

Recommended order:

1. Hero with documentary image and CTAs.
2. Credibility strip with impact metrics, partner proof, or latest activity.
3. Programs feature area with stronger program cards.
4. Impact/story band with numbers and one evidence-led narrative when content
   exists.
5. Partner logo wall.
6. Gallery/news/events modules with denser scan-friendly cards or rows.
7. Contact/partnership closeout with details-only next steps.

Impact metrics should feel like proof, not generic cards. Use larger numbers,
tighter labels, and short explanatory text. Partner logos should sit in a clean
wide logo wall with consistent boxes.

## Cards And Grids

Cards should look editorial and stable:

- Stronger image area or intentional empty-media treatment.
- Consistent aspect ratios.
- Metadata above title or below summary depending on module.
- Clear action link with descriptive text.
- Subtle border and minimal shadow.
- Stable heights so grid rows do not jitter.

Use cards for repeated items only. Do not wrap page sections in card-like
containers and do not nest cards.

Very-wide grid behavior:

- Program cards: up to 4 columns unless content becomes too thin.
- Gallery and compact media cards: up to 5 columns.
- News/event list modules: use either 3-column cards or compact rows inside a
  2-column editorial split.
- Metrics: use a wide strip, up to 4 or 5 metric cells.
- Partner tiles: up to 6 columns with equal logo boxes.

## Page-Level Improvements

Shared page heroes should be more substantial than the current narrow text block:

- Wider shell with stronger title treatment.
- Optional compact media/brand accent when relevant.
- Better spacing between hero, content, and listing grid.
- Keep text line lengths readable even inside wide layouts.

Listing pages should use the wide grid system. Detail pages should avoid feeling
like plain articles by giving media, metadata, and body content distinct zones.

The contact page remains details-only. It should feel useful and credible with
clear cards for general email, partnership email, phone/WhatsApp, address,
office hours, and social channels.

## RTL And Bilingual Requirements

The redesign must work equally in `/en` and `/ar`.

- Keep `lang` and `dir` on the root HTML element.
- Use logical CSS properties for gutters, spacing, alignment, and borders.
- Do not mirror the logo or documentary photos.
- Mirror directional affordances only if arrows are introduced.
- Arabic text needs comfortable line-height and must not be compressed into
  smaller boxes than English.
- Wide grids should collapse predictably in both directions.

## Design Docs And Stitch Prompts

Update `docs/design/brand-system.md` and `docs/design/stitch-prompts.md` during
implementation so future agents and Google Stitch prompts reflect the new
direction:

- Very-wide editorial layout.
- Documentary hero image.
- Premium donor/partner credibility.
- Strong homepage hierarchy.
- Denser wide-screen grids.
- Details-only contact page.
- No donation UI and no public contact form.

## Verification

Implementation is not complete until these checks pass:

- `scripts/dev-php artisan test`
- `npm run build`
- `git diff --check`
- `scripts/dev-php artisan route:cache && scripts/dev-php artisan route:clear`
- HTTP smoke checks for `/`, `/en`, `/ar`, `/fr`, and `/admin/login`
- Visual screenshot checks or browser inspection for `/en` and `/ar` on:
  - very wide desktop around `1920px`
  - normal desktop around `1440px`
  - mobile around `390px`
- Scan public/code/design files for forbidden v1 patterns:
  - `Donate`
  - `donation`
  - public `<form` markup
- Confirm no active `linear-gradient` or decorative orb/blob background system
  is introduced.
- Confirm wide grids visibly expand beyond the old `1180px` layout.

## Open Implementation Notes

- If browser screenshot tooling is unavailable, use the installed system browser
  headlessly or inspect manually through the running dev server.
- Generated image output should be treated as replaceable content. Real program
  photography should replace it when available.
- Keep the implementation tightly scoped to public visual quality unless a
  small seed image-path update is needed to wire the hero asset.
