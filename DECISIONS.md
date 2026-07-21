# Decisions

Record decisions that affect product behavior, design direction, API contracts, architecture, workflow, or human involvement.

## Decision Format

```text
YYYY-MM-DD | Decision ID | Owner | Scope | Decision | Rationale | Rejected Options | Impact
```

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
```
