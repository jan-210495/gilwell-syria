# Front-End Handoff

## Task

- Task ID: navbar-hero-interaction-fix
- Owner: Front-End Builder
- Date: 2026-07-23

## Implementation Summary

Implemented all four user-reported fixes for navbar visibility and hero interaction zones.

### Navbar: Transparent/opaque state by page

**Problem:** Header was always transparent with white text. On non-home pages with white backgrounds, the header content was invisible.

**Implementation:**
- Added `has-dark-hero` body class passed from the homepage route (`routes/web.php`)
- CSS: `.site-header` defaults to opaque (ink text, paper background, border, shadow, backdrop-filter)
- CSS: `.has-dark-hero .site-header` overrides to transparent (white text, no background, no border)
- CSS: `.has-dark-hero .site-header.is-scrolled` and `.site-header.is-menu-open` transition to opaque
- CSS: Brand text and logo shadow adapt between opaque and transparent states
- CSS: Mobile breakpoint also respects `has-dark-hero` distinction

### Navbar: Hover underline cleanup

**Problem:** Nav underline animation didn't reset cleanly, leaving artifacts.

**Implementation:**
- Changed `border-block-end-color` from gold to transparent — only the animated `::after` underline shows
- `is-active` links use `transition: none` so underline is always visible without flicker
- Hover/focus underlines animate in with `::after` transform, animate out smoothly on leave

### Hero: Nav blocker overlay

**Problem:** Hovering the logo area triggered both logo tilt AND hero panel expansion underneath.

**Implementation:**
- Added `hero-corners__nav-blocker` overlay covering top 30% of hero (z-index: 3)
- This transparent div blocks pointer events from reaching the hero panels in the navbar zone
- The home-hero__inner (GilwellSyria text + CTAs) sits at z-index: 4, above everything

### Hero: Middle-third hover zone

**Problem:** Hero panels expanded on hover anywhere, including top third (navbar area) and bottom third (content area).

**Implementation:**
- Added `hero-corner-panel__hover-zone` inside each panel covering middle third (top 30% to bottom 35%)
- Panel expansion controlled by JavaScript `is-expanded` class (not CSS `:hover`)
- Hover zone `mouseenter`/`mouseleave` events toggle `is-expanded` on parent panel
- Keyboard focus on panel button also toggles `is-expanded`
- CSS `:hover` rules replaced with `.is-expanded` class rules
- Mobile breakpoint: hover zones hidden, panels always show value text, no expansion behavior

### Hero: Centered value text in expanded panels

**Problem:** Corner name and sentence appeared at the bottom of expanded panels, under the GilwellSyria heading and CTA buttons.

**Implementation:**
- Changed `.hero-corner-panel__button` from `align-items: flex-end` to `align-items: center; justify-content: center`
- Value text now appears in the **center** of the panel when expanded
- On mobile, button reverts to `align-items: flex-end` (bottom-aligned, matching stacked panel layout)

### Non-home page content offset

- Added 94px top padding offset on `.page-hero` and `.section` for non-home pages so fixed header doesn't overlap content

## Files Changed

- `resources/css/app.css` — Header transparency rules, hover zone CSS, hero panel layout, nav underline cleanup, content offset
- `resources/js/app.js` — Hero panel expansion via hover zones, header scroll logic respects `has-dark-hero`
- `resources/views/public/home.blade.php` — Added nav blocker and hover zones in hero markup
- `resources/views/public/layout.blade.php` — Body class and header class based on `$headerMode` variable
- `routes/web.php` — Homepage passes `'has-dark-hero'` as `$headerMode`, other pages pass empty string

## Commands Run and Results

- `npm run build`: PASSED (after temporarily disabling Bunny font plugin for sandbox network constraints; vite.config.js restored)
- `git diff --check`: PASSED (no whitespace errors)

## Known Risks

- The `$headerMode` variable is passed through the `$publicView` closure. All existing routes continue to work with the default empty string. The homepage is the only route that explicitly passes `'has-dark-hero'`.
- The `hero-corners__nav-blocker` is a transparent overlay. It does not interfere with pointer events on the header (which sits above it at z-index: 30) or on the home-hero__inner content (z-index: 4).
- Mobile behavior unchanged: panels show value text always, no hover-zone expansion.

## Screenshots Needed from Human Operator

Visual verification needed:
- Desktop `/en` homepage: transparent header over dark hero, panels expand from middle only, text centered
- Desktop `/en/about`: opaque header with dark text, content offset below header
- Desktop hover over logo: logo tilts, panels stay still
- Desktop hover over nav links: underline animates in and out cleanly
- Mobile `/en`: burger menu with header colors matching the state

## Requested Next Action

QA Reviewer should verify the implementation against the acceptance criteria and run all available checks.
