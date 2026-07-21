# GilwellSyria

Laravel 13 website and admin CMS for GilwellSyria, an established nonprofit
with a bilingual English/Arabic public site, donor/partner credibility content,
and admin-only Filament publishing workflows.

## Stack

- Laravel 13, PHP 8.3+
- Livewire 4
- Filament 5 admin panel at `/admin`
- MySQL or MariaDB for local/VPS environments
- Tailwind CSS 4 and Vite 8

Host PHP and Composer are not required for this repo. Use the project-local
Docker image and wrapper scripts:

```bash
docker build -t gilwell-syria-php -f docker/php/Dockerfile .
scripts/dev-composer install
scripts/dev-php artisan key:generate
scripts/dev-php artisan migrate --seed
npm install
npm run build
```

## Development

Public URLs are locale-prefixed:

- `/en`
- `/ar`

The Arabic routes render right-to-left. The CMS stores English and Arabic fields
on each record instead of separate translated records.

Useful commands:

```bash
scripts/dev-php artisan test
npm run build
scripts/dev-php artisan serve --host=0.0.0.0 --port=8000
npm run dev
```

## Agent Workflow

This repo includes the multi-agent Codex workflow kit:

- `prompts/mastermind.md`
- `prompts/designer.md`
- `prompts/backend-builder.md`
- `prompts/frontend-builder.md`
- `prompts/qa-reviewer.md`
- `TASKS.md`, `LIVE_STATUS.md`, `AGENT_LOG.md`, `DECISIONS.md`,
  `CONFLICTS.md`, `HUMAN_REQUESTS.md`

Mastermind assigns tasks and communicates with the Human Operator. Specialist
agents write handoffs and visible working notes in the repo files.
