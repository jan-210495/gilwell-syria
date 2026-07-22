# GilwellSyria Brand System

Status: Draft for Mastermind review  
Owner: Designer  
Task ID: v1-brand-design  
Date: 2026-07-21

## Brand Position

GilwellSyria should feel established, trustworthy, service-minded, and rooted
in the outdoor/scout training tradition. The public site is primarily for
donors, partners, families, trainees, and community stakeholders, so the design
must favor evidence, clarity, and calm confidence over campaign-style spectacle.

Use the existing logo at `assets/gilwellsyria-logo.jpeg` as the source brand
mark. The logo carries five values: loyalty, merit, discipline, honor, and
tenacity. The public interface should reference those colors as accents, not as
competing primary colors.

## Logo Usage

- Use the full square logo without cropping, recoloring, stretching, rotating,
  or mirroring.
- Keep the logo on white, warm off-white, or very light neutral backgrounds.
- Minimum display sizes: 56px in compact navigation, 88px in page headers, 120px
  in footer or institutional panels.
- Leave clear space equal to at least 20 percent of the displayed logo width.
- Do not place the logo on busy photos or over color blocks unless it is inside
  a simple white/light surface.
- The logo text remains English inside the image. Do not flip the image for RTL.

## Color Palette

The palette is derived from the logo and tuned for accessible UI use.

| Token | Hex | Role | Usage |
| --- | --- | --- | --- |
| Pine 900 | `#1F3518` | Primary brand | Headers, footer, primary navigation, primary CTA backgrounds |
| Pine 700 | `#3E5F2E` | Secondary green | Section markers, badges, active states, subdued surfaces |
| Gold 500 | `#DCA84A` | Heritage accent | Dividers, icons, small fills, stat accents; pair with dark text |
| Honor Yellow | `#F4C70D` | High-energy accent | Rare highlights, event labels, value markers; never body text |
| Navy 800 | `#042863` | Trust and links | Text links, donor/partner credibility panels, secondary buttons |
| Loyalty Red | `#B22E26` | Alert and urgency | Important notices, deadline labels, destructive/error accents |
| Merit Purple | `#6B0F68` | Program distinction | Merit/training category accents, not broad backgrounds |
| Ink | `#111827` | Primary text | Body text, headings on light surfaces |
| Slate | `#4B5563` | Secondary text | Metadata, captions, helper text |
| Border | `#D7D9D4` | Borders | Rules, card borders, table dividers |
| Warm Paper | `#F8F7F3` | Page background | Public pages and calm section bands |
| White | `#FFFFFF` | Surface | Cards, dropdowns, contact-detail blocks, logo backgrounds |

Contrast guidance:

- White on Pine 900, Navy 800, Loyalty Red, or Merit Purple passes WCAG AA for
  normal text.
- Ink on Gold 500 or Honor Yellow passes WCAG AA.
- Gold 500 and Honor Yellow do not pass on white as text. Use them as borders,
  icons, fills behind dark text, or decorative accents only.
- Do not rely on the five value colors alone to identify content categories;
  pair color with labels, icons, or headings.

Suggested usage ratio:

- 55 percent neutral surfaces and whitespace.
- 25 percent Pine and deep institutional greens.
- 10 percent Navy for trust/link moments.
- 10 percent combined red, purple, gold, and yellow accents.

## Typography

Recommended public font pairing:

- Latin: `Source Sans 3`, then `Inter`, then system sans.
- Arabic: `Noto Sans Arabic`, then `Tahoma`, then system sans.
- Optional display use: `Noto Kufi Arabic` for Arabic page titles if available,
  but keep body copy in `Noto Sans Arabic` for readability.

Implementation notes:

- Use `font-display: swap` for any self-hosted webfont.
- Apply language-aware font stacks with `:lang(en)` and `:lang(ar)`.
- Do not use all-caps styling for Arabic text.
- Do not add letter spacing to Arabic text. Keep letter spacing at `0`.
- Arabic line-height should be slightly more generous than English, especially
  in body text and labels.

Type scale:

| Role | Desktop | Mobile | Notes |
| --- | --- | --- | --- |
| Page H1 | 44px / 52px | 34px / 42px | Use for page identity only |
| H2 | 32px / 40px | 26px / 34px | Section titles |
| H3 | 24px / 32px | 22px / 30px | Cards and content groups |
| Body | 18px / 30px | 16px / 28px | Public content, stories, program summaries |
| UI text | 15px / 22px | 15px / 22px | Navigation, buttons, tabs |
| Caption | 14px / 20px | 14px / 20px | Dates, labels, metadata |

## Spacing And Layout

- Use an 8px spacing system.
- Page gutters: 16px mobile, 24px tablet, 32px desktop.
- Main content max width: 1180px.
- Reading content max width: 720px per language column.
- Section padding: 40px mobile, 56px tablet, 72px desktop.
- Cards should use 8px radius or less, a visible border, and restrained shadow.
- Do not nest cards inside cards.
- Prefer full-width bands and unframed layouts for page sections.
- Use stable dimensions for repeated items such as cards, logo grids, gallery
  thumbnails, counters, and event rows to avoid layout shift.

Public page rhythm:

1. Clear page identity and primary action.
2. Short credibility proof: numbers, partner logos, or latest activity.
3. Content modules with direct links to deeper pages.
4. Contact or partnership inquiry path near the end.

## Module Direction

Home:

- First viewport should identify GilwellSyria, show the logo or a real program
  image, and provide primary actions for contacting GilwellSyria, partnership
  inquiry, and exploring programs.
- Include concise credibility proof near the top: impact numbers, partner count,
  training participation, or recent program evidence when CMS data exists.

About:

- Lead with mission, heritage, and operating credibility.
- Use a timeline or milestone list if content exists.
- Keep governance and organizational trust content easy to scan.

Programs:

- Use structured cards with audience, duration/status, location, and outcome.
- Provide category accents from the logo values, but keep card text neutral.

Impact:

- Use metrics, short stories, map/location references, and partner proof.
- Show methodology notes or reporting periods near impact numbers.

Partners:

- Use a clean logo wall with equal logo boxes and partner descriptions below
  when available.
- Distinguish strategic partners, donors, and community partners if CMS supports
  those categories.

Gallery albums:

- Use album cards with a consistent aspect ratio.
- Show album title, location/date, and photo count.
- Avoid masonry in v1 unless all thumbnails have reliable dimensions.

News:

- Use article cards with date, category, title, excerpt, and image when present.
- Keep list pages dense enough for scanning.

Events and Training:

- Use event rows or cards with date, location, registration state, and audience.
- Provide visible states: upcoming, registration open, full, cancelled, past.

Contact:

- Show contact details only for v1: phone, email, location, social channels,
  office or service area, and clear next steps for general and partnership
  inquiries.
- Do not include a public contact form in v1.
- If a direct channel is unavailable, show a clear fallback path instead of an
  empty field.

## Component Guidance

Navigation:

- Desktop: logo, main links, language switch, and one primary CTA labeled
  `Contact us`.
- Mobile: compact header, menu button, language switch, and full-screen or
  drawer navigation with large targets.
- Keep the active page state visible through text weight plus a border or fill.

Buttons:

- Primary: Pine 900 background, white text.
- Secondary: white background, Pine 900 text, Pine border.
- Tertiary: text link with Navy 800 and underline on hover/focus.
- Destructive or urgent: Loyalty Red background with white text.
- Minimum hit target: 44px by 44px.

Cards:

- Use cards for repeated items only: programs, articles, events, albums,
  partners, and metrics.
- Standard anatomy: media/icon, label, title, short summary, metadata, action.
- Empty media state should use a simple Pine or Warm Paper placeholder, not a
  decorative illustration.

Future Forms:

- V1 public UI does not include a contact form. Keep these rules only for future
  CMS, community, registration, or contact-form readiness.
- Labels are always visible.
- Required fields use text plus an indicator, not color alone.
- Validation messages appear near the field and in an accessible summary when
  needed.
- Success state should confirm the next expected response time if known.

Tables and lists:

- Favor list rows over dense tables for public pages.
- If tables are used for schedules or training details, support horizontal
  overflow on small screens and keep row headers visible.

Media:

- Use real program, training, venue, partner, and community images.
- Avoid dark, blurred, generic, or stock-like hero imagery.
- Always provide editorial alt text or mark decorative images as empty alt.

## RTL And Bilingual Notes

- Public URLs are locale-prefixed: `/en` and `/ar`.
- Use `dir="rtl"` and `lang="ar"` for Arabic pages; use `dir="ltr"` and
  `lang="en"` for English pages.
- Build with CSS logical properties: `margin-inline`, `padding-inline`,
  `border-inline`, `inset-inline`, `text-align: start`, and `text-align: end`.
- Mirror navigation order, directional icons, breadcrumbs, arrows, and carousel
  controls in RTL.
- Do not mirror the logo, photographs, partner marks, or numeric data charts
  unless the chart axis meaning requires RTL layout.
- Keep brand names such as `GilwellSyria` isolated as LTR text inside Arabic
  copy when needed.
- Arabic and English content should have equal hierarchy. Avoid treating Arabic
  as a compressed translation layer.
- Dates, numbers, and address formatting should use the active locale.

## Accessibility Notes

The v1 public site must meet WCAG AA.

- Provide skip links, semantic landmarks, visible headings, and one H1 per page.
- Ensure all interactive elements are keyboard reachable and have visible focus
  states.
- Use focus rings with at least 2px thickness and strong contrast, such as Gold
  500 outside dark controls or Navy 800 on light surfaces.
- Respect reduced-motion preferences. Animation should be short, purposeful, and
  nonessential.
- Do not place text directly over busy images. If image overlays are needed, use
  a strong Pine or Ink overlay that preserves contrast.
- Preserve 200 percent browser zoom usability without horizontal page scrolling.
- Use descriptive link text. Avoid repeated "Read more" links without context.
- Provide captions or context for impact numbers so they are not misleading.
- Gallery media needs alt text or a clear album-level description.
- Future CMS, community, registration, or contact forms need labels,
  field-level errors, summary errors, and success confirmation.

## Usage Guidance For Frontend

- Define the palette as shared design tokens or CSS custom properties before
  building page components.
- Prefer token names over raw hex values in components.
- Build public components with both LTR and RTL examples before finalizing.
- Start with the reusable shell: header, footer, locale switcher, page hero,
  content section, card grid, listing row, alert, pagination, and contact-detail
  block.
- Each public module should have loading, empty, error, and populated states.
- Use the CMS content as the source of truth. Avoid hard-coded public content
  except placeholders required for development.
- Keep page templates content-first. The design should still work when a record
  lacks an image, excerpt, or optional metadata.
- Treat donor/partner credibility as a first-class pattern: show source dates,
  partner context, impact periods, and clear contact paths.
- Do not introduce new logos, mascot graphics, generated imagery, or decorative
  SVG scenes for v1 unless Mastermind explicitly approves them.

## Visual Reset Addendum

The accepted public visual reset uses a very-wide editorial layout for desktop.
Use the main wide container constraint `min(100% - responsive gutters, 1680px)`
with responsive gutters of `clamp(20px, 4vw, 72px)`. Keep reading content in a
reading container about `760px` to `860px`. Use dense grids with 5 columns at
very wide widths, 4 columns at normal desktop widths, 2 columns at tablet
widths, and 1 column on mobile.

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
