# Decisions

Record decisions that affect product behavior, design direction, API contracts, architecture, workflow, or human involvement.

## Decision Format

```text
YYYY-MM-DD | Decision ID | Owner | Scope | Decision | Rationale | Rejected Options | Impact
```

## Final Verification Evidence

2026-07-22 20:31: after the recorded completion/review of Tasks 1-4, final
verification passed: `scripts/dev-php artisan test` 55 tests/594 assertions;
`npm run build` with only the optional `fontaine` warning; route cache and clear;
fresh seed with the local admin/editor users and `leadership-training`; `/` 302
to `/en`, `/en` and `/ar` required hooks with no public donation/form matches,
`/fr` 404, and `/admin/login` fields. Screenshot evidence is
`/tmp/gilwell-identity-en-1440.png` (1440x900),
`/tmp/gilwell-identity-en-1920.png` (1920x1080),
`/tmp/gilwell-identity-en-390.png` (390x844), and
`/tmp/gilwell-identity-ar-390.png` (390x844). Forbidden-pattern matches remain
limited to negative tests, historical ledgers, or rejecting docs; no public
mobile `overflow-x: auto`; `git diff --check` passed.

## Accepted Decisions

```text
2026-07-21 | D-001 | Mastermind | Workflow | Use separate Codex CLI sessions coordinated through repo files | This keeps the workflow reusable outside a single chat session | Built-in subagents as the primary model | All role prompts assume shared files
2026-07-21 | D-002 | Mastermind | Workflow | Use five working roles plus Human Operator | The user wants Designer, Front-End Builder, Back-End Builder, QA, and Mastermind separation | One generic Builder role | Prompts and ownership rules use specialist roles
2026-07-21 | D-003 | Mastermind | Human routing | Only Mastermind contacts the Human Operator | Human attention should be used only for final external missions | Agents speaking to the human directly | Specialist agents submit proposed human requests to Mastermind
2026-07-21 | D-004 | Designer | Brand direction | Use the existing GilwellSyria logo as the fixed brand mark and build v1 public colors from a restrained logo-derived palette led by pine green, gold, and navy | The logo already carries the organization identity and values; controlled color use supports donor and partner credibility | New logo, generic scout theme, equal-weight rainbow palette | Frontend should implement tokens and usage rules from docs/design/brand-system.md
2026-07-21 | D-005 | Designer | Bilingual accessibility | Design v1 public pages as equal-quality English LTR and Arabic RTL experiences with logical layout properties, unmirrored logo/media, Arabic-aware typography, and WCAG AA contrast | The product brief requires bilingual public modules and WCAG AA; RTL quality must be a first-class build constraint | English-first layouts with compressed translations, mirrored logo, color-only meaning | Frontend should verify public components in both /en and /ar states before review
2026-07-21 | D-006 | Mastermind | V1 CTA and contact scope | V1 primary CTA is Contact us; partnership actions route to inquiry/contact details; no online donation UI or public contact form is included in v1 | Mastermind review locked donor/partner focus to credibility and partnership inquiry rather than transaction or form workflows | Donate CTA, online donation flow, public contact form | Frontend and Stitch prompts should model contact details, office/service area, social channels, and clear next steps only
2026-07-21 | D-007 | Back-End Builder | CMS backend architecture | Store English and Arabic CMS fields on each record, use a shared draft/pending_review/published/archived workflow with published_at, and expose v1 media as string paths | This matches the bilingual public-site requirement while keeping v1 backend/admin scope practical and testable | Translation tables, full media-library integration, external role package | Frontend can query same-record bilingual fields and publishable models can use the published scope for public content
2026-07-21 | D-008 | Back-End Builder | Site settings contact scope | Use partnership_email in site_settings and omit donation_url from v1 backend/admin settings | This aligns backend data with D-006: Contact us and Partner with us should route to contact details, not donation UI | donation_url, donate-specific settings field | Frontend can consume contact_email and partnership_email for v1 contact/partner CTAs
2026-07-21 | D-009 | Front-End Builder | Public frontend architecture | Implement the v1 public site as locale-prefixed Blade routes that query CMS models through published scope and select bilingual fields at render time | This fits frontend ownership boundaries, uses the committed CMS schema directly, and keeps v1 public behavior explicit and testable | New app controllers, translation tables, hard-coded public content, unprefixed public routes | Public pages live under /en and /ar, invalid locales 404, and public views only receive published CMS records
2026-07-22 | D-010 | Back-End Builder | CMS admin authorization | Enforce CMS admin CRUD through a shared Filament CMS resource base and enforce publish timestamp/status normalization in the publishable model trait | Filament UI visibility alone is not sufficient; centralized Resource can* methods and model save hooks protect direct admin actions and keep publish state consistent | UI-only action visibility, per-model policy boilerplate | Admins can manage all CMS records; editors can create and edit draft publishable records, save only draft or pending_review status, edit SiteSetting, and cannot delete
2026-07-22 | D-011 | Mastermind | Public visual reset | Redesign the public site around a very-wide editorial layout, documentary-style hero image, denser desktop grids, and premium donor/partner credibility | The first implementation is technically sound but visually weak, narrow on wide screens, and lacks a strong hero | Keep current 1180px layout, logo-box hero, basic equal card grid, donation/form-oriented public flows | Frontend implementation plan should update public CSS/views, design docs, Stitch prompts, and one generated hero image while preserving CMS/backend behavior
2026-07-22 | D-012 | Mastermind | Public visual reset acceptance | Accept the visual reset branch after final verification and a focused desktop framing fix | Final checks passed for PHP tests, production build, route cache, seeded content, locale smoke checks, active public forbidden-pattern scans, and visual evidence at 1920 desktop, 1440 desktop, and 390 Arabic mobile | Accepting the first Task 5 screenshot with hidden credibility strip | The public visual reset can proceed to whole-branch review and integration choice
2026-07-22 | D-013 | Mastermind | Public identity motion revision | Replace the generic single-photo hero with a five-corner cinematic identity hero, add real hover/focus/press motion, remove boxed logo treatment, and replace mobile horizontal nav with a burger menu | The stable visual reset is technically good but still feels institutional, static, and generic; the user approved using the Arena concept as inspiration without copying it | Keep the current single-photo hero, horizontal mobile nav, static buttons/cards, boxed logo header | Next implementation plan should use the five generated scout-panel assets in public/images/hero-corners and stay in Laravel Blade/CSS/vanilla JS
2026-07-22 | D-014 | Mastermind | Public identity motion implementation | Accept the five-corner identity hero, transparent brand treatment, accessible burger menu, and tactile motion system as the next public visual baseline | Final verification confirmed the site no longer feels like a static government page and preserves tests, build, routing, bilingual behavior, and no donation/form boundaries | Keep single-photo hero, boxed logo header, horizontal mobile nav, static buttons/cards | Future public design work should build on the five-corner hero and motion tokens rather than reintroducing static CMS-scaffold styling
2026-07-29 | D-015 | Mastermind | Browser identity | Use the existing transparent GilwellSyria brand mark as a multi-resolution ICO favicon and link it explicitly from the shared public layout | The current favicon is an empty file, so browsers display a generic tab icon despite the established brand mark | Generic browser icon, a new symbol, or a text-only favicon | All bilingual public pages expose the same logo-derived browser-tab identity
```
