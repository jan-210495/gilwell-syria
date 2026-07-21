# Decisions

Record decisions that affect product behavior, design direction, API contracts, architecture, workflow, or human involvement.

## Decision Format

```text
YYYY-MM-DD | Decision ID | Owner | Scope | Decision | Rationale | Rejected Options | Impact
```

## Accepted Decisions

```text
2026-07-21 | D-001 | Mastermind | Workflow | Use separate Codex CLI sessions coordinated through repo files | This keeps the workflow reusable outside a single chat session | Built-in subagents as the primary model | All role prompts assume shared files
2026-07-21 | D-002 | Mastermind | Workflow | Use five working roles plus Human Operator | The user wants Designer, Front-End Builder, Back-End Builder, QA, and Mastermind separation | One generic Builder role | Prompts and ownership rules use specialist roles
2026-07-21 | D-003 | Mastermind | Human routing | Only Mastermind contacts the Human Operator | Human attention should be used only for final external missions | Agents speaking to the human directly | Specialist agents submit proposed human requests to Mastermind
```
