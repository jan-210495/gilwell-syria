# Agent Rules

These rules apply to every Codex CLI session working in this repo.

## Read Order

Before acting, read:

1. `README.md`
2. `AGENTS.md`
3. your role prompt in `prompts/`
4. `TASKS.md`
5. `LIVE_STATUS.md`
6. `AGENT_LOG.md`
7. `DECISIONS.md`
8. `CONFLICTS.md`

## Coordination Rules

- Work only inside your assigned role and task ownership.
- Only the Mastermind assigns tasks, accepts or rejects work, and resolves conflicts. Other agents may recommend actions and record proposed handoffs, but cannot make those decisions.
- Do not overwrite another agent's work.
- Do not revert files you did not change unless the Mastermind explicitly assigns that recovery task.
- If a file you need is owned by another active agent, log the conflict in `CONFLICTS.md` and wait for Mastermind direction.
- If instructions conflict, follow the newest explicit Mastermind instruction and log the decision.
- If product, API, design, or architecture behavior changes, update `DECISIONS.md`.
- If you are blocked, update `LIVE_STATUS.md`, append `AGENT_LOG.md`, and add an entry to `CONFLICTS.md` when another agent or decision is involved.

## Shared Ledger Update Protocol

The shared ledgers may be edited only by authorized writers: `LIVE_STATUS.md`,
`AGENT_LOG.md`, `DECISIONS.md`, `CONFLICTS.md`, and `TASKS.md` where you are
authorized to update your assigned task section. `HUMAN_REQUESTS.md` remains
Mastermind-write-only.

1. Re-read the ledger immediately before editing.
2. Make a narrow update only to your own row or assigned task section, or
   append your own new entry.
3. After writing, re-read the changed section and check `git diff` before
   committing or reporting completion.
4. If another agent changed the same ledger or section, preserve their change,
   re-read the file, and retry your edit.
5. If you cannot resolve a merge or conflict confidently, log or raise the
   conflict for the Mastermind and wait for direction.

## Human Operator Rule

Only the Mastermind contacts the Human Operator.

Specialist agents may write proposed human requests in their handoff, but they must not address the Human Operator directly. The Mastermind decides whether the request is necessary and rewrites it into a final actionable request.

The Designer may create Google Stitch prompts, but only the Mastermind delivers final prompts to the Human Operator.

## Watch Mode Rule

You cannot expose hidden private reasoning. You must provide visible working notes instead.

For every meaningful action, log:

- action taken
- rationale
- files changed
- commands run
- decisions
- assumptions
- blockers
- handoffs
- next requested action

Assumptions, blockers, and handoffs must be visible repo-file records in the coordination files, not only private notes or chat.

## Completion Rule

When finished, report:

- task id
- changed files
- summary of changes
- verification commands and results
- decisions added
- conflicts opened or resolved
- remaining risks
- requested next action from Mastermind
