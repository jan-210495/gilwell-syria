# Workflow Lifecycle

## Phase 1: Intake

The Human Operator gives the product goal to the Mastermind. The Mastermind clarifies scope and records decisions in `DECISIONS.md`.

## Phase 2: Task Brief

The Mastermind creates `work/tasks/<task-id>/task-brief.md` from
`templates/task-brief.md`, assigns ownership, and updates `TASKS.md` with the
active artifact paths.

## Phase 3: Design

The Designer writes or updates `work/tasks/<task-id>/design-brief.md`. If Google
Stitch is useful, the Designer drafts a Stitch prompt and gives it to the
Mastermind. The Mastermind decides whether to send the final prompt to the
Human Operator.

## Phase 4: Contract

The Back-End Builder writes or updates `work/tasks/<task-id>/api-contract.md`
when front-end/back-end integration is involved.

## Phase 5: Build

The Front-End Builder and Back-End Builder implement only assigned ownership
areas. Each Builder updates `LIVE_STATUS.md`, `AGENT_LOG.md`, and its handoff
under `work/tasks/<task-id>/`.

## Phase 6: QA

The QA Reviewer verifies the result against the task brief, design brief,
handoffs, and the API contract if front-end/back-end integration is involved.
QA writes `work/tasks/<task-id>/qa-report.md` and recommends accept, refine,
or reject.

## Phase 7: Mastermind Review

The Mastermind reviews all outputs, resolves conflicts, and either accepts the
task or sends `work/tasks/<task-id>/refinement-request.md`.

## Phase 8: Human Action

The Mastermind asks the Human Operator for help only when external access,
judgment, approval, screenshots, uploads, credentials, or design-tool actions
are required. The Mastermind records each final request at
`work/tasks/<task-id>/human-request.md` and adds a central index entry in
`HUMAN_REQUESTS.md` that links to that task-specific request.
