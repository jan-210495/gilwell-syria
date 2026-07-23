# Task Brief

## Task

Only the Mastermind creates and assigns tasks.

- Task ID: navbar-hero-interaction-fix
- Title: Navbar visibility and hero interaction zone fixes
- Status: accepted
- Assigned Owner: Front-End Builder
- Supporting Agents: QA Reviewer
- Created By: Mastermind
- Created Date: 2026-07-23

## Goal

Fix three user-reported interaction problems on the public site:

1. **Navbar invisible on non-home pages** — The transparent navbar with white text disappears against the white page background on About, Programs, Impact, Partners, Gallery, News, Events, and Contact pages.

2. **Logo hover conflicts with hero panel hover** — Hovering over the brand logo at the top of the hero triggers both the logo tilt animation AND the hero corner panel expansion underneath, creating overlapping visual motion.

3. **Hero panel hover zone and text placement** — The hero panels react to hover in the top third (navbar zone) and the corner name/sentence text appears at the bottom of the expanded panel (under the GilwellSyria heading and CTAs), making it barely visible. The user wants panels to only react in the middle third, and the text to appear in the center of the expanded panel.

4. **Nav hover underline cleanup** — The last hover underline effect on nav links is not properly removed, leaving a visual artifact.

## Scope

- Header component: transparency state, text/logo color adaptation, hover underline animation
- Hero section: interaction zone boundaries, panel expansion trigger area, value text positioning
- Route data: header-mode context variable for page-specific header behavior
- JavaScript: hero panel expansion via hover zones instead of CSS hover
- CSS: conditional header styling based on has-dark-hero body class

## Out Of Scope

- No backend, CMS, migration, or Filament changes
- No new pages, routes, or content
- No hero image or asset changes
- No footer changes
- No donation UI or form changes

## File Ownership

| Path / Area | Owner | Allowed Actions |
| --- | --- | --- |
| resources/css/app.css | Front-End Builder | Modify header, hero, nav styles |
| resources/js/app.js | Front-End Builder | Modify hero panel expansion, header scroll logic |
| resources/views/public/home.blade.php | Front-End Builder | Add nav blocker, hover zone markup |
| resources/views/public/layout.blade.php | Front-End Builder | Add header-mode body/header class logic |
| routes/web.php | Front-End Builder | Add headerMode parameter to homepage route |
| tests/Feature/ | QA Reviewer | Verify, do not modify unless assigned fix |
| TASKS.md, LIVE_STATUS.md, AGENT_LOG.md, DECISIONS.md | Mastermind / assigned owner | Coordination ledgers |

## Inputs

- The public-visual-reset branch implementation (hero corner panels, transparent header, burger menu)
- User-reported visual inspection findings from running the site locally
- Existing brand system docs (docs/design/brand-system.md)

## Required Outputs

- Fixed header visibility on all public pages
- Hero panels that only expand from the middle third hover zone
- Corner value text centered in expanded panels
- Clean nav underline animation without lingering artifacts
- No conflict between logo hover and hero panel hover

## Verification Required

- `npm run build` passes
- `git diff --check` passes
- Visual check: header visible on /en/about, /en/programs, etc. (ink text on paper background)
- Visual check: header transparent on /en (white text on dark hero, becomes opaque on scroll)
- Visual check: logo tilt does NOT trigger hero panel expansion
- Visual check: hero panels only expand when hovering middle third
- Visual check: corner name and sentence appear in the center of expanded panel
- Visual check: nav underline animation resets cleanly on mouse leave
- `rg Donate|donation|<form` on public surface returns only negative test assertions

## Handoff Required

- Front-End Builder → QA Reviewer: implementation commit, file list, behavior summary
- QA Reviewer → Mastermind: QA report, verification results, recommendation

## Mastermind Acceptance Criteria

- Header is opaque with dark text on all non-home pages
- Header is transparent with white text on homepage, transitions to opaque on scroll
- Logo tilt animation does not trigger hero panel expansion
- Hero panels only expand from hover in the middle third (between navbar and hero content)
- Corner value name and sentence appear centered in expanded panel
- Nav underline animation resets cleanly without lingering state
- All existing tests still pass
- Production build succeeds

## Watch Mode

- Action: Create task brief for user-reported interaction fixes
- Rationale: User inspected the site locally and reported specific navbar and hero problems that need front-end fixes
- Files Changed: work/tasks/navbar-hero-interaction-fix/task-brief.md (new)
- Commands Run: None
- Decisions: None — brief records the user's requirements directly
- Assumptions: The public-visual-reset branch code is the baseline; fixes are additive, not replacing the hero design
- Blockers: None
- Handoff: Front-End Builder receives this brief for implementation
- Next Action: Front-End Builder reads brief and implements fixes
