# Tasks

The Mastermind owns this file. Other agents may update only their assigned task sections unless instructed otherwise.

## Status Values

- `proposed`: described but not assigned
- `assigned`: owner selected
- `in_progress`: owner is actively working
- `blocked`: owner needs Mastermind action
- `review`: ready for QA or Mastermind review
- `refine`: sent back for revision
- `accepted`: accepted by Mastermind
- `rejected`: closed without acceptance

## Active Tasks

| Task ID | Status | Owner | Title | Files / Area | Active Artifacts | Next Action |
| --- | --- | --- | --- | --- | --- | --- |
| none | accepted | Mastermind | No active task | none | none | Create a task brief when work begins |

## Per-Task Artifacts

Each task stores its coordination artifacts in `work/tasks/<task-id>/`. Use
the matching template to create only the artifacts the task needs:

- `task-brief.md`
- `design-brief.md`
- `api-contract.md`
- `frontend-handoff.md`
- `backend-handoff.md`
- `qa-report.md`
- `refinement-request.md`
- `human-request.md`

Every active task row must list its current artifact paths in `Active
Artifacts`, including `work/tasks/<task-id>/task-brief.md`. Update the row
when an artifact is created, superseded, or no longer active.

## Task Protocol

1. Mastermind creates `work/tasks/<task-id>/task-brief.md` and creates or updates a task row with its active artifact paths.
2. Assigned owner updates status before starting.
3. Assigned owner logs progress in `AGENT_LOG.md`.
4. Assigned owner updates status to `review` when complete.
5. QA reviews when assigned.
6. Mastermind changes status to `accepted`, `refine`, or `rejected`.
