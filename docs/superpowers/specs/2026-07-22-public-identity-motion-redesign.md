# GilwellSyria Public Identity Motion Redesign

Status: Approved direction, awaiting implementation plan  
Owner: Mastermind  
Date: 2026-07-22  
Scope: Public frontend identity, hero, navigation, motion, and interaction pass

## Context

The current `public-visual-reset` branch is stable and reviewed, but it still
feels too institutional. The page is wide and functional, yet the header,
buttons, cards, and hero do not feel alive enough for a premium youth
leadership organization.

The user specifically rejected these qualities:

- Government-website feeling.
- Boxed logo treatment in the header.
- Static navbar with no personality.
- Buttons and cards that do not react to hover.
- Mobile navigation as a horizontal scrolling bar.
- A generic single-photo hero.

The user approved using the Arena concept as inspiration only. The next
revision should borrow the qualities that worked there: cinematic identity,
transparent-feeling brand treatment, tactile motion, value-based hero panels,
and proper burger navigation. Do not copy the React codebase or convert the
Laravel public site to React.

## Source Assets

The user generated five realistic vertical scout-panel images and placed them
under:

```text
public/images/hero-corners/
```

Use these source filenames:

```text
merit.png
discipline.png
honor.png
tenacity.png
loyalty.png
```

Current source files are `941x1672` PNGs and roughly `2.0MB` to `2.3MB` each.
They should be optimized during implementation into WebP delivery assets before
being served publicly.

Visual constraints for these images:

- Young adults should wear scout neckerchiefs/scarves around the neck.
- No women wearing scarves or head coverings on their heads.
- No hijabs or headscarves.
- No visible text, logos, flags, or political symbols.
- No exaggerated uniforms.
- No fantasy styling or corporate stock-photo look.

The current generated set passes visual inspection for the implementation plan.

## Goals

- Replace the generic single-photo homepage hero with a five-corner identity
  hero that feels specific to GilwellSyria.
- Make the site feel alive through restrained, accessible motion.
- Replace mobile horizontal nav scrolling with a proper burger menu.
- Remove the boxed-logo feeling from the header and footer.
- Add meaningful hover, focus, and press states to nav links, buttons, cards,
  metrics, and partner tiles.
- Preserve the stable Laravel/Blade/CSS architecture and the CMS-driven content.
- Preserve equal-quality English LTR and Arabic RTL behavior.

## Non-Goals

- Do not copy the Arena React implementation.
- Do not convert the site to React.
- Do not redesign the backend, CMS schema, or admin.
- Do not add donation UI, donation settings, or a public contact form.
- Do not use decorative orb/blob background systems.
- Do not create a new logo from scratch.

## Recommended Approach

Build a **five-corner cinematic hero** as the new first viewport.

The hero should use five vertical panels:

1. Merit - violet.
2. Discipline - alpine green.
3. Honor - yellow/gold.
4. Tenacity - blue.
5. Loyalty - red.

Default state is quiet and image-led. Value names and meanings should be
present in a subtle form or discoverable through interaction, then become
prominent on hover/focus. This keeps the first impression cinematic instead of
turning the hero into a labeled infographic.

On desktop and larger tablets:

- The five panels sit side by side.
- Hover/focus expands the active panel and slightly dims the others.
- The active panel reveals its value name, short meaning, color hairline, and
  a controlled motion treatment.
- Keyboard focus must trigger the same state as hover.
- The hero still contains a clear organization headline and CTAs.

On mobile:

- Do not depend on hover.
- Use stacked/tappable panels or a compact value selector.
- Keep the main headline and CTAs visible without overlap.
- Values should be discoverable without forcing horizontal page scrolling.

## Hero Content

The first viewport must keep the organization clear:

- H1: `GilwellSyria` or active localized site name.
- Supporting line: CMS tagline and home summary/body when present.
- Primary CTA: `Contact us`.
- Secondary CTA: `Partner with us`.
- Tertiary CTA: `Explore programs`.

The value names should appear mainly on hover/focus, not as heavy labels in the
default state.

Suggested value copy:

- Merit: Earned growth through skill, service, and recognition.
- Discipline: Focused training, structure, and reliable practice.
- Honor: Dignified service and responsibility to others.
- Tenacity: Perseverance through challenge and teamwork.
- Loyalty: Belonging, trust, and shared commitment.

Arabic copy should be concise and equal in quality, not a compressed afterthought.

## Header And Brand Treatment

The current header logo appears like an image trapped inside a white box. The
next revision should make the brand feel integrated:

- Create and use a transparent brand-mark derivative for the header so the
  logo no longer appears trapped inside a white tile. The derivative must be
  based on the existing approved logo and must not introduce a new unrelated
  symbol.
- Keep the original JPEG available as a fallback/source asset, but do not use a
  boxed white logo tile in the public header.
- Use a stronger wordmark treatment: `Gilwell` plus an accented `Syria`, or
  localized equivalent where appropriate.
- On desktop, the header starts as a transparent/dark overlay on the hero and
  becomes a paper/backdrop surface after scroll using small vanilla JavaScript.
- Desktop nav should use animated underline/sweep states and active-page
  feedback.

## Mobile Navigation

The mobile nav must be a burger menu, not a horizontal scrolling navbar.

Requirements:

- Visible burger button at mobile/tablet breakpoints.
- `aria-expanded`, `aria-controls`, and a labelled nav panel.
- Tapping the burger toggles the panel.
- Keyboard focus works.
- Panel links are large, readable, and stacked vertically.
- Links include all current public nav destinations.
- Language switch and contact CTA remain easy to reach.
- No body-breaking horizontal scroll.
- Menu closes after any panel link activation.
- Respect RTL layout and Arabic labels.

Use a small vanilla JavaScript controller in `resources/js/app.js`; do not add a
frontend framework.

## Motion And Interaction System

Motion should make the page feel alive, not busy.

Add these interaction families:

- Button hover/press: lift, color shift, subtle shadow, icon or underline motion.
- Nav hover: underline sweep or color bar animation.
- Card hover: slight lift, border/accent reveal, image scale within frame.
- Metric hover: accent line growth or count/number emphasis.
- Partner hover: logo tile lift and clearer border/accent.
- Hero panel hover/focus: expansion, color accent, image scale, value reveal.
- Scroll reveal: sections/cards fade and rise in as they enter the viewport.

Constraints:

- Respect `prefers-reduced-motion`.
- Keep transitions under control: around `180ms` to `900ms` depending on effect.
- Avoid constant decorative animation except slow hero image motion.
- No page elements should shift layout unexpectedly.
- Hover states must have matching focus-visible states for keyboard users.

## Visual Style

Use Arena as inspiration for craft, not source code.

Keep the palette anchored in:

- Pine/deep green.
- Warm paper.
- Navy/ink.
- Disciplined gold.
- Five value accents only where meaningful:
  - Merit violet.
  - Discipline alpine green.
  - Honor yellow/gold.
  - Tenacity blue.
  - Loyalty red.

The site should not become a rainbow interface. The five colors belong mostly to
the hero and value accents.

Typography should feel more editorial:

- Use a stronger display treatment for the wordmark, hero, and major section
  headings with existing CSS font stacks or a Vite-supported local/imported
  font strategy chosen in the implementation plan.
- Do not shrink Arabic; give it equal optical weight and line-height.
- Avoid negative letter spacing.

## Implementation Boundaries

Stay inside the public frontend surface:

- `resources/views/public/layout.blade.php`
- `resources/views/public/home.blade.php`
- shared public partials if needed for card/button hooks
- `resources/css/app.css`
- `resources/js/app.js`
- `public/images/hero-corners/*`
- public feature/CSS tests
- design docs and ledgers

Avoid backend/admin/schema/routes changes unless a test uncovers a direct public
rendering issue.

## Asset Optimization

Do not serve the five source PNGs directly as the main hero payload.

Implementation should:

- Generate optimized WebP versions for each panel.
- Use WebP first with PNG fallback for browsers that cannot use WebP.
- Keep source PNGs as source assets unless replacement is requested.
- Avoid delivering all five `2MB+` PNGs to first viewport users.
- Validate generated file sizes and dimensions.

Required optimized output path:

```text
public/images/hero-corners/optimized/
```

Required optimized filenames:

```text
merit.webp
discipline.webp
honor.webp
tenacity.webp
loyalty.webp
```

## Testing Requirements

Add focused tests before implementation:

- Home renders five hero-corner panels with the five required value keys.
- Home references optimized hero-corner assets, not only PNG source files.
- Mobile nav includes a burger button with accessible attributes.
- CSS contains hero panel expansion/focus contract.
- CSS contains button/card/nav motion contracts.
- CSS contains `prefers-reduced-motion` protections.
- Public pages still contain no donation/form UI.

## Verification Requirements

Implementation is not complete until these pass:

- `scripts/dev-php artisan test tests/Feature/PublicSiteTest.php tests/Feature/PublicVisualCssTest.php`
- `scripts/dev-php artisan test`
- `npm run build`
- `git diff --check`
- Active public scans for:
  - `Donate`
  - `donation`
  - `<form`
  - decorative orb/blob backgrounds
- HTTP smoke checks for `/`, `/en`, `/ar`, `/fr`, and `/admin/login`.
- Browser visual checks or screenshots for:
  - English desktop around `1440x900`.
  - English wide desktop around `1920x1080`.
  - English mobile around `390x844`.
  - Arabic mobile around `390x844`.

Visual acceptance:

- Header no longer looks like a government navbar.
- Logo no longer appears trapped in a white box.
- Mobile nav is a burger menu, not horizontal scrolling nav.
- Hero is clearly a five-corner Gilwell identity experience.
- Hero default state is cinematic and quiet.
- Hover/focus states reveal value names and meanings.
- Buttons and cards react visibly on hover/focus.
- No overlapping text or controls in English or Arabic mobile.

## Risks And Mitigations

- **Risk:** Five images make the first viewport too heavy.  
  **Mitigation:** optimize to WebP, verify sizes, and load only the hero-panel
  assets needed for the first viewport behavior.

- **Risk:** Motion becomes busy or inaccessible.  
  **Mitigation:** centralize transition tokens and enforce
  `prefers-reduced-motion`.

- **Risk:** Burger menu adds brittle JavaScript.  
  **Mitigation:** use a small vanilla controller with HTML attributes as the
  source of state.

- **Risk:** Five-color hero becomes visually noisy.  
  **Mitigation:** keep default state image-led and use value colors as subtle
  accents until hover/focus.
