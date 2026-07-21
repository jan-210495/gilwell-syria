# Conflicts

Use this file for ownership conflicts, blocked coordination, incompatible decisions, or unclear task instructions.

## Conflict Format

```text
YYYY-MM-DD HH:MM | Conflict ID | Raised By | Task ID | Area | Problem | Needed Decision | Status
```

## Open Conflicts

```text
none | C-000 | Mastermind | none | none | No current conflicts | none | closed
```

## Resolution Rules

- The agent that finds a conflict logs it here.
- The agent updates `LIVE_STATUS.md` to `blocked` when the conflict prevents progress.
- Only Mastermind resolves or reassigns the conflict.
- Mastermind appends the decision to `DECISIONS.md` when the resolution changes project behavior.
