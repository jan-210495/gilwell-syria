# Agent Log

Append entries in chronological order. Keep entries concise but specific enough for the Human Operator to watch the work.

## Entry Format

```text
YYYY-MM-DD HH:MM | Agent | Task ID | Action | Rationale | Files | Commands | Decisions | Assumptions | Blockers | Handoff | Next Action
```

## Watch Mode Requirements

Every meaningful-action entry must include every field in the format. Use
`none` when a category does not apply. Put durable decisions in `DECISIONS.md`
and blockers in `CONFLICTS.md`, then link their entries in the corresponding
fields here.

## Log

```text
2026-07-21 00:00 | Mastermind | none | Initialized workflow log | Establish the shared visibility ledger | AGENT_LOG.md | none | none | none | none | none | Await product goal
```
