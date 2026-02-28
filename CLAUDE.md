# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel package (`fperdomo/laravel-agent-skill`) that publishes an AI coding skill — structured best practices rules for Laravel — to multiple locations so AI agents and IDEs can use them. The package is minimal (~140 lines of core code) but drives rich publishable asset distribution.

## Commands

```bash
# Install dependencies
composer install

# Run tests (Pest)
composer test
# or
vendor/bin/pest

# Run a single test file
vendor/bin/pest tests/Feature/PublishSkillToProjectWorkspaceTest.php

# Run a specific test by name
vendor/bin/pest --filter "it publishes the skill"

# Build workbench testing environment
composer build

# Serve workbench locally
composer serve
```

## Architecture

The package has two source files and the rest is publishable content:

**Core source (`src/`):**
- `LaravelBestPracticesSkillInstallerServiceProvider.php` — Registers all publishable assets under 9 distinct tags (`lbpa-skill`, `lbpa-skill-home`, `lbpa-skill-vscode`, `lbpa-skill-jetbrains`, `lbpa-claude`, `lbpa-copilot`, `lbpa-agents`, `lbpa-all`, and the default). Registers the console command.
- `Console/InstallAllAdaptersCommand.php` — Artisan command `lbpa:install` that wraps `vendor:publish` with `--tag=lbpa-all` (accepts `--force` and `--tag` options).

**Publishable assets (`resources/`):**
- `skills/laravel-best-practices/` — The main skill directory published to `.codex/skills/laravel-best-practices/` (project-level), `~/.codex/skills/laravel-best-practices/` (home), `.vscode/codex/...` (VS Code), or `.idea/codex/...` (JetBrains).
  - `SKILL.md` — Skill guide used by AI agents during code review and generation.
  - `references/rulebook.json` — 15+ rules in JSON, each with `id`, `title`, `severity_default`, `signals`, `recommended_pattern`, `examples`, and `reference`.
  - `references/laravel-best-practices-summary.md` and `references/inertia-vue.md` — Supplemental documentation.
  - `scripts/` — Helper scripts (`detect-laravel-context.php`, `review-diff.sh`).
- `adapters/` — AI agent-specific adapter files published directly to the consuming project root: `CLAUDE.md`, `copilot-instructions.md` (→ `.github/`), `AGENTS.md`.

**Test suite (`tests/`):**
- Uses Pest + Orchestra Testbench (testbench.yaml configures the test app).
- Feature tests verify each publish tag works and puts files in the right location.
- Unit tests cover the service provider and rulebook structure (including Inertia rules).

## Key Conventions

**Adding new rules:** Add entries to `resources/skills/laravel-best-practices/references/rulebook.json`. Each rule requires `id` (e.g., `SRP-001`), `title`, `severity_default` (`high`/`medium`/`low`), `signals` (array), `recommended_pattern` (string), `examples` (object with `bad`/`good`), and `reference` (URL). Write a corresponding test in `tests/Unit/` to assert the rule exists with expected fields.

**Adding new publish targets:** Add a new `$this->publishes([...], 'tag-name')` call in the service provider's `boot()` method. Add a corresponding feature test in `tests/Feature/`.

**Rule ID prefixes in use:** `SRP`, `FUNC`, `MVC`, `VAL`, `SVC`, `DRY`, `ELO`, `BLADE`, `PERF`, `INRT` (Inertia/React), `INRT-VUE` (Inertia/Vue).
