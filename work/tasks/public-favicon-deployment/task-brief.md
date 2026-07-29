# Public Favicon Deployment

## Task

- Task ID: `public-favicon-deployment`
- Title: Add and deploy the GilwellSyria browser-tab icon
- Status: `assigned`
- Assigned Owner: Designer, then Front-End Builder
- Supporting Agents: QA Reviewer, Mastermind
- Created By: Mastermind
- Created Date: 2026-07-29

## Goal

Show the existing GilwellSyria logo as the browser-tab icon on every English
and Arabic public page, then publish the verified branch and update the running
TrueNAS deployment.

## Scope

- Replace the empty `public/favicon.ico` with a valid multi-resolution ICO
  derived from the existing transparent brand mark.
- Add an explicit icon link to the shared public layout.
- Add regression coverage for the icon file and rendered link.
- Commit and push the final public visual-reset branch.
- Update the TrueNAS app from the pushed branch inside tmux session `codex`,
  restart it, and verify LAN and public HTTPS responses.
- Update the home-server deployment record with the deployed commit.

## Out Of Scope

- Redesigning the logo.
- Adding a web app manifest or installable PWA behavior.
- Changing CMS, database, routes, or public-page content.

## File Ownership

| Path / Area | Owner | Allowed Actions |
| --- | --- | --- |
| `work/tasks/public-favicon-deployment/design-brief.md` | Designer | Create |
| `public/favicon.ico` | Front-End Builder | Replace empty file with generated ICO |
| `resources/views/public/layout.blade.php` | Front-End Builder | Add icon metadata only |
| `tests/Feature/PublicAssetTest.php`, `tests/Feature/PublicSiteTest.php` | Front-End Builder | Add focused regression tests |
| `work/tasks/public-favicon-deployment/frontend-handoff.md` | Front-End Builder | Create |
| `work/tasks/public-favicon-deployment/qa-report.md` | QA Reviewer | Create |
| `/home/jabboud/projects/homeserver/docs/gilwellsyria-deployment-2026-07-29.md` | Mastermind | Append deployed commit/update evidence |

## Inputs

- `public/images/gilwellsyria-logo-transparent.png`
- Human Operator instruction to use the logo as a `.ico` browser-tab icon.
- Final branch `public-visual-reset`.

## Required Outputs

- Valid `public/favicon.ico` containing 16x16, 32x32, and 48x48 frames.
- Shared layout includes an explicit versioned `rel="icon"` reference.
- Focused and relevant public tests pass.
- Branch pushed and TrueNAS deployment refreshed from the pushed revision.

## Verification Required

- Expected failing tests before implementation.
- ICO MIME/type, dimensions, and non-empty checks.
- Public layout response contains the icon link for `/en` and `/ar`.
- Browser request for `/favicon.ico` returns HTTP 200 and `image/x-icon` or
  equivalent icon content type.
- Relevant PHP tests, production asset build, and `git diff --check` pass.
- LAN and public HTTPS pages and favicon return HTTP 200 after deployment.

## Handoff Required

Front-End Builder records exact files, test results, icon metadata, and commit
scope. QA independently verifies before Mastermind accepts and deploys.

## Mastermind Acceptance Criteria

- The favicon is the existing GilwellSyria logo, not a generic placeholder.
- The browser can discover it explicitly on both locales.
- No public visual or functional regressions are introduced.
- Git and TrueNAS run the same verified commit.
- Home-server documentation records the deployed revision.

## Watch Mode

- Action: Created and assigned the favicon task.
- Rationale: The current favicon file is empty and the layout does not link it.
- Files Changed: This task brief and coordination ledgers.
- Commands Run: `file`, `identify`, `sha256sum`, source and test inspection.
- Decisions: D-015 records use of the existing brand mark as the favicon.
- Assumptions: Existing dirty public visual-reset files are the Human Operator's final approved preview and must be preserved.
- Blockers: None.
- Handoff: Designer defines the compact asset contract, then Front-End Builder implements test-first.
- Next Action: Designer writes `design-brief.md`.
