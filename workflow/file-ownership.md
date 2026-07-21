# File Ownership

## Claiming Files

Before editing, an agent checks `TASKS.md`, `LIVE_STATUS.md`, and `CONFLICTS.md`.

The Mastermind assigns file ownership in the task brief. Agents may edit only
assigned files or areas. Task-specific coordination artifacts live in
`work/tasks/<task-id>/`.

## Conflict Handling

If two agents need the same file:

1. Stop before editing.
2. Add an entry to `CONFLICTS.md`.
3. Update `LIVE_STATUS.md` to `blocked` if progress cannot continue.
4. Wait for the Mastermind to split, sequence, or reassign the work.

## Shared Ledger Update Protocol

These common ledgers may be edited only by authorized writers:
`LIVE_STATUS.md`, `AGENT_LOG.md`, `DECISIONS.md`, `CONFLICTS.md`, and
`TASKS.md` where the agent is authorized to update its assigned task section.
`HUMAN_REQUESTS.md` remains Mastermind-write-only.

1. Re-read the ledger immediately before editing it.
2. Make only a narrow change: update your own row or assigned task section, or
   append a new entry. Do not rewrite unrelated entries.
3. After writing, re-read the changed section and check `git diff` before
   committing or reporting completion.
4. If another agent changed the same ledger or section, preserve that change,
   re-read the current file, and retry your narrow edit.
5. If the conflict cannot be resolved confidently, append or preserve a
   conflict record where possible, raise it for the Mastermind, and wait.

## Default Ownership

| Area | Default Owner |
| --- | --- |
| Product task briefs | Mastermind |
| Design briefs and design reviews | Designer |
| Google Stitch prompt drafts | Designer |
| Final human-facing prompts | Mastermind |
| Client source files | Front-End Builder |
| Server source files | Back-End Builder |
| API contracts | Back-End Builder |
| QA reports | QA Reviewer |
| Mastermind Decision sections in QA and design reports | Mastermind only |
| Final task acceptance | Mastermind |
| Refinement requests | Mastermind |
| Human requests | Mastermind |

## Git Rule

Agents must not revert another agent's edits. If another agent's edits break the current task, log the problem and ask the Mastermind for direction.
