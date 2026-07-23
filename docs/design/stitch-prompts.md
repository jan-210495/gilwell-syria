# Google Stitch Prompt Drafts

Status: Drafts for Mastermind review only  
Owner: Designer  
Task ID: v1-brand-design  
Date: 2026-07-21

These prompts are candidates for Mastermind review. Only the Mastermind may
decide whether to deliver a final prompt to the Human Operator or request an
external Google Stitch run.

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

## Recommended Visual Reset Prompt

Create a premium bilingual public homepage for GilwellSyria, a youth leadership
and community service nonprofit in Syria. Use the very-wide container constraint
`min(100% - responsive gutters, 1680px)` with responsive gutters, and keep
reading content in a reading container about `760px` to `860px`. Use dense grids
with 5 columns at very wide widths, 4 columns at normal desktop widths, 2
columns at tablet widths, and 1 column on mobile. The first viewport must have a
strong documentary-style hero image of youth leadership training in a Syrian or
Levant community setting, with natural daylight, realistic nonprofit photography,
no visible text, no logos, and no flags. Place the GilwellSyria logo only in the
header and footer, not as the hero artwork.

The hero headline should identify GilwellSyria directly, with clear CTAs for
Contact us, Partner with us, and Explore programs. Build credibility through a
wide impact metric strip, polished program cards, a calm partner logo wall, and
dense but readable gallery/news/events modules. Use pine green, navy, warm paper,
and disciplined gold accents. Support equal English LTR and Arabic RTL layouts.
Do not include donation UI or a public contact form.

## Shared Prompt Context

Attachment expected: `assets/gilwellsyria-logo.jpeg`.

Brand direction: GilwellSyria is an established nonprofit inspired by
Gilwell World and Gilwell Park, serving a bilingual English/Arabic audience.
The public site must feel credible for donors and partners while still rooted
in scout training, outdoor service, and community impact.

Required public modules: Home, About, Programs, Impact, Partners, Gallery
albums, News, Events/Training, and Contact.

Accessibility target: WCAG AA, responsive desktop/mobile, and equal English/RTL
Arabic design quality.

## Draft Prompt A: Public Home And Brand System

```text
Create a high-fidelity responsive website concept for GilwellSyria, an
established nonprofit inspired by Gilwell World and Gilwell Park. Use the
attached GilwellSyria logo as the only brand mark. Do not create a new logo.

Design the Home page in desktop and mobile views, plus a compact brand system
panel showing colors, typography, buttons, cards, alerts, navigation states,
and contact-detail blocks.

The visual direction should be institutional, warm, field-service oriented, and
donor/partner credible. Avoid startup SaaS styling, childish scout imagery,
generic stock-photo atmosphere, oversized marketing cards, and decorative
gradient blobs.

Use a logo-derived palette:
- deep pine green as the main brand color
- heritage gold as a restrained accent
- navy for trust and links
- red, purple, green, and yellow from the logo only as controlled value accents
- warm off-white backgrounds and clean white content surfaces

Design requirements:
- First viewport clearly identifies GilwellSyria and shows the logo or a real
  program/training image area.
- Include primary actions for Contact us, Partner with us, and Explore
  Programs. Do not include online donation UI.
- Show early credibility proof: impact numbers, recent activity, or partner
  evidence.
- Include sections for Programs, Impact, Partners, News, Events/Training,
  Gallery albums, and Contact.
- Keep the layout content-first, calm, and easy to scan.
- Use cards only for repeated items, with 8px radius or less.
- Include visible keyboard focus styles and accessible contrast.
- Include an English/LTR version and an Arabic/RTL version of the header and
  Home page.
- Do not mirror the logo in RTL.
- Use realistic placeholder content, not lorem ipsum.

Output should prioritize layout clarity, component consistency, bilingual
behavior, and a buildable Tailwind-style structure.
```

## Draft Prompt B: Public Module Templates

```text
Create responsive public page templates for GilwellSyria using the attached
logo and the established nonprofit brand direction. Produce desktop and mobile
views for these modules:

1. About
2. Programs listing and program detail
3. Impact
4. Partners
5. Gallery albums and album detail
6. News listing and article detail
7. Events/Training listing and event detail
8. Contact

Design for a bilingual English/Arabic Laravel public site with locale-prefixed
routes. Include both LTR and RTL examples for at least the About page, Programs
listing, Events/Training listing, and Contact details page.

Use this style:
- deep pine green, navy, gold, and restrained logo-value accents
- warm off-white page background
- white content surfaces with subtle borders
- readable nonprofit typography with generous Arabic line height
- structured, evidence-oriented content

Component requirements:
- reusable public header, footer, language switcher, page hero, section header,
  card grid, list row, metric block, partner logo grid, gallery album card,
  news card, event/training card, pagination, alert, contact-detail block, and
  partnership inquiry callout
- states for empty image, missing excerpt, registration open, full, cancelled,
  past event, missing contact channel, and loading
- accessible focus states and WCAG AA color contrast
- mobile layouts that avoid text overlap and preserve 44px touch targets
- Contact is details-only in v1: show phone, email, location, social channels,
  office/service area, and clear next steps. Do not design a public contact
  form or donation flow.

Avoid decorative illustrations, fake new logos, heavy shadows, dark blurred
heroes, one-color green monotony, and card-inside-card layouts. Use realistic
content examples grounded in community programs, scout training, partners,
impact reporting, news, and events.
```

## Draft Prompt C: RTL And Accessibility Validation Pass

```text
Review and refine the GilwellSyria public website concept for Arabic RTL and
WCAG AA accessibility. Use the attached logo unchanged.

Create side-by-side desktop and mobile examples for:
- English Home and Arabic Home
- English Programs listing and Arabic Programs listing
- English Events/Training listing and Arabic Events/Training listing
- English Contact and Arabic Contact

Focus on implementation-ready details:
- mirrored layout flow using RTL conventions
- unmirrored logo and photographs
- language switcher behavior
- Arabic typography with comfortable line height
- no all-caps treatment for Arabic
- text alignment using start/end logic
- locale-aware date, number, and address examples
- visible keyboard focus states
- contact channel labels, office/service area, social links, and clear next
  steps for inquiries
- future form-readiness notes only if needed; do not include a public contact
  form in v1
- sufficient contrast for buttons, links, captions, and badges
- no text overlap at mobile widths

Keep the brand mature, nonprofit, and field-service oriented. Use the deep pine
green and navy for structure, gold for emphasis, and the other logo colors only
as small category/value accents.
```

## Mastermind Review Notes

- Prompt A is the best first Stitch run because it establishes the public Home
  page and reusable brand system together without requesting donation UI.
- Prompt B should follow if the Mastermind wants page-template coverage before
  frontend implementation starts.
- Prompt C should be used as a refinement prompt after Stitch produces an
  initial direction, especially if Arabic/RTL quality is weak.
- No prompt asks Stitch to generate production code or new image assets.
- No prompt should be delivered externally until the Mastermind reviews wording,
  confirms contact and partnership CTA labels, and decides whether the Human
  Operator should run Google Stitch.
