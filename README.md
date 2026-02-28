# Laravel Best Practices Skill Installer

This package publishes an AI agent skill covering Laravel best practices — including Inertia + React conventions — into multiple locations to support various AI agents and editors.

## Install

```bash
composer require fperdomo/laravel-agent-skill --dev
```

## Usage

### Quick install — everything

```bash
php artisan lbpa:install

# Overwrite existing files
php artisan lbpa:install --force
```

### Laravel Boost (recommended)

If your project uses [Laravel Boost](https://laravel.com/docs/12.x/boost), the skill is auto-discovered and installed when you run:

```bash
php artisan boost:install
```

To keep skills up-to-date when dependencies are updated, add this to your project's `composer.json`:

```json
"scripts": {
    "post-update-cmd": [
        "@php artisan boost:update --ansi"
    ]
}
```

To publish manually to the Boost location (`.ai/skills/`):

```bash
php artisan vendor:publish --tag=lbpa-boost
# Publishes to: .ai/skills/laravel-best-practices/ and .ai/skills/inertia-development/
```

### Publish to Codex skill locations

**Project workspace (primary):**
```bash
php artisan vendor:publish --tag=lbpa-skill
# Publishes to: .codex/skills/laravel-best-practices/
```

**User home directory (global, shared across all projects):**
```bash
php artisan vendor:publish --tag=lbpa-skill-home
# Publishes to: ~/.codex/skills/laravel-best-practices/
```

**VS Code:**
```bash
php artisan vendor:publish --tag=lbpa-skill-vscode
# Publishes to: .vscode/codex/skills/laravel-best-practices/
```

**JetBrains IDEs (PhpStorm, IntelliJ, etc.):**
```bash
php artisan vendor:publish --tag=lbpa-skill-jetbrains
# Publishes to: .idea/codex/skills/laravel-best-practices/
```

**All Codex locations at once:**
```bash
php artisan vendor:publish --tag=lbpa-skill-all
```

### Publish AI agent adapters

```bash
php artisan vendor:publish --tag=lbpa-claude    # → CLAUDE.md
php artisan vendor:publish --tag=lbpa-copilot   # → .github/copilot-instructions.md
php artisan vendor:publish --tag=lbpa-agents    # → AGENTS.md
```

**Everything (all adapters + all skill locations):**
```bash
php artisan vendor:publish --tag=lbpa-all
```

## What's included

### Backend rules

| ID | Rule | Severity |
|----|------|----------|
| SRP-001 | Single Responsibility Principle | high |
| FUNC-001 | Methods should do one thing | medium |
| MVC-001 | Skinny controllers; move logic out | high |
| VAL-001 | Validation in FormRequest classes | **critical** |
| SVC-001 | Business logic in service/action classes | high |
| AUTH-001 | Use Policies for authorization | high |
| CONF-001 | Never call `env()` outside config files | high |
| DRY-001 | Don't repeat yourself | medium |
| ELO-001 | Prefer Eloquent + Collections (`sole()`, `firstOrCreate()`, casts) | low |
| BLADE-001 | No queries in Blade; eager load to avoid N+1 | **critical** |
| PERF-001 | Chunk/stream large dataset operations | medium |
| NAMING-001 | Follow Laravel naming conventions | medium |

### Inertia + React rules

| ID | Rule |
|----|------|
| INRT-001 | Directory conventions (`common`, `modules`, `pages`, `shadcn`) |
| INRT-002 | Page components: `Page` suffix, default export |
| INRT-003 | One component per file, PascalCase, function declarations |
| INRT-004 | Wrap shadcn components; avoid direct app-wide imports |
| INRT-005 | No barrel files; absolute aliased imports |
| INRT-006 | Type page props with TypeScript interfaces |
| INRT-007 | Use `useForm` for submissions; avoid raw axios/fetch |
| INRT-008 | Use `usePage` for shared data; avoid prop drilling |
| INRT-009 | Use `<Link>` for internal navigation; avoid plain `<a>` |
| INRT-010 | Use partial reloads (`router.reload`) instead of full visits |

### Inertia + Vue rules

| ID | Rule |
|----|------|
| INRT-VUE-001 | Directory conventions |
| INRT-VUE-002 | Page components: `Page` suffix, default export |
| INRT-VUE-003 | One component per `.vue` file, `<script setup>` |
| INRT-VUE-004 | Wrap third-party UI library components |
| INRT-VUE-005 | No barrel files; absolute aliased imports |

## Published structure

```
.ai/skills/laravel-best-practices/         # Laravel Boost — general skill
  SKILL.md
.ai/skills/inertia-development/            # Laravel Boost — Inertia React + Vue skill
  SKILL.md

.codex/skills/laravel-best-practices/      # Codex / project workspace
  SKILL.md
  references/
    rulebook.json
    laravel-best-practices-summary.md
    inertia-react.md
    inertia-react-summary.md
    inertia-vue.md
  scripts/
    detect-laravel-context.php
    review-diff.sh

CLAUDE.md                                  # Claude Code adapter
.github/copilot-instructions.md            # GitHub Copilot adapter
AGENTS.md                                  # Generic agent adapter
```