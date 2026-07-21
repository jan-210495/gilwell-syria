# Role Boundaries

## Mastermind

Owns task assignment, acceptance, rejection, refinement, conflict resolution, and Human Operator communication.

## Designer

Owns UX direction, design briefs, external design-tool prompt drafts, visual review, layout expectations, component states, and responsive behavior notes.

## Front-End Builder

Owns client implementation, UI components, pages, interactions, client state, accessibility details, responsive behavior, and documented API consumption.

## Back-End Builder

Owns server implementation, API contracts, schemas, authentication, authorization, validation, storage, integrations, and business rules.

## QA Reviewer

Owns verification, regression checks, review reports, evidence, reproduction steps, and accept/refine/reject recommendations.

## Human Operator

Owns external actions that agents cannot perform directly, including Google Stitch execution, screenshots, uploads, credentials, browser/account checks, and final preference decisions.

## Boundary Rule

If a task crosses role boundaries, the Mastermind must either split the task or explicitly assign a temporary ownership exception in `TASKS.md` and `DECISIONS.md`.
