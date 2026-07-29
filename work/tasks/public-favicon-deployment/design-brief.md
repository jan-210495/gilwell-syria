# Design Brief

## Task

- Task ID: `public-favicon-deployment`
- Designer: Designer
- Date: 2026-07-29
- Governing decision: D-015

## Product Intent

Give every GilwellSyria public browser tab a recognizable brand identity by
deriving a compact favicon from the approved transparent logo. This is an
asset-format derivative, not a logo redesign: the five-corner silhouette,
central medallion, colors, orientation, and proportions remain unchanged.

## Primary User Flow

1. A visitor opens any English or Arabic public route.
2. The shared layout declares the same versioned favicon for both locales.
3. The browser requests the ICO and displays the GilwellSyria mark in the tab,
   bookmark, or browser history surface that supports favicons.

No visible page control, interaction, route, or localized copy changes.

## Asset Contract

### Source And Geometry

- Use only `public/images/gilwellsyria-logo-transparent.png` as the visual
  source. Do not use image generation or substitute another logo file.
- Preserve the complete five-corner logo. Do not isolate the central medallion,
  redraw the mark, simplify shapes, replace lettering, recolor, rotate, skew,
  stretch, add effects, or change the relationship between logo elements.
- Exclude only the two detached white source-canvas artifacts at the extreme
  edges: the vertical 1-pixel line at `x=1078` and the horizontal 2-pixel line
  at `y=1078`. They are outside the connected five-corner silhouette and must
  not appear in any ICO frame. Do not retouch pixels within the logo itself.
- Crop to the logical mark envelope, preserving its aspect ratio, then center
  it on a square transparent canvas. The centered mark must occupy no more than
  87.5% of frame width or height, leaving at least 1 transparent pixel on every
  side at 16x16, 2 pixels at 32x32, and 3 pixels at 48x48.
- Resize from the cleaned high-resolution source independently for each target
  frame with a high-quality downsampling filter. Never upscale one favicon
  frame to create another.

### Background And Frames

- Use a fully transparent background. The logo already has a closed,
  multicolor silhouette and light edge detail; a white or colored tile would
  introduce an unapproved shape and is not needed for recognition.
- Preserve alpha through conversion. Edges must not have a white, black, or
  gray rectangular matte when viewed on both light and dark browser chrome.
- Write one non-empty `public/favicon.ico` containing exactly three square,
  32-bit RGBA frames: 16x16, 32x32, and 48x48. Do not include a 256x256 frame,
  animated content, SVG, PNG fallback link, Apple touch icon, or web manifest.
- At 16x16, internal words are allowed to become unreadable; recognition comes
  from the five colored corners and central gold/green medallion. Do not alter
  the logo to force tiny lettering to read.

## Shared Layout Contract

Add one explicit icon declaration in the shared public `<head>`, before the
Vite assets, so it applies unchanged to `/en`, `/ar`, and all locale child
pages:

```blade
<link rel="icon" type="image/x-icon" sizes="16x16 32x32 48x48" href="{{ asset('favicon.ico') }}?v=20260729">
```

The `v=20260729` query is the required first-deployment cache token. A future
favicon replacement must change this token in the same commit as the asset.
Do not rely only on the browser's implicit `/favicon.ico` discovery.

## Components

| Component | Purpose | States | Notes |
| --- | --- | --- | --- |
| Multi-frame ICO | Supply appropriate raster sizes to browsers | 16x16, 32x32, 48x48 | Same complete logo geometry in every frame |
| Shared head link | Make browser discovery explicit | English, Arabic, nested public routes | One locale-neutral declaration with cache token |

## Responsive Behavior

Favicons are browser-chrome assets and do not participate in page layout. The
same file and link must be returned at mobile and desktop widths, in LTR and
RTL, with no viewport-specific variant.

## Visual Rules

- Keep the original green, gold, red, blue, purple, and yellow relationships.
- Keep the five-corner silhouette upright and optically centered.
- Maintain transparent breathing room; no edge may touch or clip the frame.
- Accept natural raster reduction of fine lettering, but reject merged outer
  wedges, a missing center emblem, detached edge lines, halos, or a solid tile.

## Copy Tone

No copy is introduced. The favicon contains only lettering already embedded in
the approved logo artwork.

## Accessibility And Brand Notes

- A favicon is decorative document metadata, so the `<link>` receives no
  `alt`, `aria-label`, `title`, or hidden explanatory text.
- The favicon must not be the sole carrier of page status, language, errors, or
  navigation meaning. Existing titles and visible branding remain unchanged.
- Use the identical brand mark for English and Arabic; do not mirror it in RTL.
- No motion, flashing, theme-dependent recoloring, or user preference handling
  is appropriate for this asset.

## Exact Visual QA Checks

1. Confirm `public/favicon.ico` is non-empty and reports an ICO/icon MIME or
   file type. `identify public/favicon.ico` must list exactly 16x16, 32x32, and
   48x48 frames, with no additional dimensions.
2. Render every frame enlarged with nearest-neighbor scaling on both `#FFFFFF`
   and `#1A1A1A` backgrounds. All frames must show transparent outer padding,
   no rectangular matte, no clipped corner, and no detached line at the right
   or bottom edge.
3. At 16x16, verify a centered multicolor five-corner silhouette and distinct
   green/gold center. Do not fail the frame because embedded words are not
   readable.
4. At 32x32 and 48x48, verify all five colored outer wedges remain distinct,
   the central circular medallion is recognizable, the fleur-de-lis remains
   centered, and the logo is neither stretched nor rotated.
5. Compare frame silhouettes side by side: padding and centering must remain
   visually proportional, with no per-size crop or redraw.
6. In current Chrome/Chromium and Firefox, open `/en`, `/ar`, `/en/about`, and
   `/ar/about` using a fresh profile or after clearing favicon cache. Each tab
   must display the GilwellSyria mark on both light and dark browser themes.
7. Inspect each rendered response and confirm exactly one matching versioned
   icon link appears in `<head>`. Confirm its request returns HTTP 200 with
   `image/x-icon` or an equivalent icon content type and a non-zero body.
8. Confirm the favicon link changes no page geometry, causes no console error,
   and does not alter titles, locale direction, header branding, or navigation.
9. Repeat the served-asset and tab checks against both LAN and public HTTPS
   deployment URLs after release; the deployed ICO and layout token must match
   the verified Git revision.

## Rejected Options

- Central-medallion-only crop: changes the approved complete-logo geometry.
- New monogram, symbol, generated icon, or text-only tile: violates D-015.
- Opaque white or brand-color square: unnecessary and visually heavy in tabs.
- A single-resolution ICO: leaves browser scaling behavior uncontrolled.
- Implicit discovery only, unversioned URL, SVG/PWA manifest expansion, or
  locale-specific variants: outside the task and less deterministic.

## Assets Or External Inputs

- Source: `public/images/gilwellsyria-logo-transparent.png`
- Output contract: `public/favicon.ico`
- Governing task: `work/tasks/public-favicon-deployment/task-brief.md`
- Governing decision: D-015 in `DECISIONS.md`
- External design tool or Human Operator asset input: none

## Open Questions For Mastermind

None. The task brief and D-015 resolve the asset, format, locale, and discovery
direction.

## Build Acceptance Notes

- Front-End Builder implements test-first and changes only the assigned favicon,
  shared-layout metadata, focused tests, and handoff artifact.
- Automated checks must cover non-empty file status, exact ICO dimensions, and
  the exact versioned link on both `/en` and `/ar`.
- QA independently performs the visual checks above; passing file metadata
  alone is insufficient because tiny-frame clipping and matte artifacts are
  visual defects.
- No logo redesign, generated image, Blade content change, CSS change, route
  change, or manifest work is accepted under this contract.

## Watch Mode

- Action: Defined the implementation-ready logo-derived favicon contract.
- Rationale: Make browser identity reproducible and visually reviewable while
  preserving the approved brand mark and public-site behavior.
- Files Changed: `work/tasks/public-favicon-deployment/design-brief.md`, Designer
  row in `LIVE_STATUS.md`, append-only Designer entries in `AGENT_LOG.md`.
- Commands Run: Required read-order inspection; `file`, `identify`, `sha256sum`,
  `view_image`, connected-component inspection, focused `rg`, `git diff`, and
  `git status` checks.
- Decisions: D-015 implemented; no new durable decision added.
- Assumptions: Detached extreme-edge white lines are source-canvas artifacts,
  while every connected part of the five-corner silhouette is protected logo
  geometry.
- Blockers: None.
- Handoff: Mastermind receives this brief for Front-End Builder assignment.
- Next Action: Mastermind reviews the contract and assigns test-first
  implementation to Front-End Builder.
