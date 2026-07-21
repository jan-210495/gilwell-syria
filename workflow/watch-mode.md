# Watch Mode

Watch Mode lets the Human Operator observe what agents are doing without becoming the coordinator.

## Visibility Boundary

Agents cannot expose hidden private reasoning. Agents must expose visible working notes: actions, rationale, tradeoffs, assumptions, commands, file changes, blockers, decisions, and handoffs.

## Required Updates

Every active agent updates:

- `LIVE_STATUS.md` when starting, pausing, blocking, reviewing, or finishing.
- `AGENT_LOG.md` for meaningful actions, using its required fields for action,
  rationale, files, commands, decisions, assumptions, blockers, handoff, and
  next action.
- `DECISIONS.md` for durable product, design, API, architecture, or workflow decisions.
- `CONFLICTS.md` for ownership conflicts and blockers.

## Code Visibility

Agents must list every changed file and summarize changed blocks in their handoff. Exact line-level changes are inspected through git diff, patch files, or commits.

## Decision Visibility

When making a decision, record:

- decision
- rationale
- rejected options
- impact
- owner

## Human View

The Human Operator should be able to open the repo and inspect:

- what every agent is working on
- what changed
- why decisions were made
- which tasks are blocked
- what was accepted or rejected
- what external action is requested
