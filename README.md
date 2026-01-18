# Laravel Best Practices Skill Installer

This package publishes an agent skill folder into multiple locations to support various AI agents and editors.

## Install (Laravel)
```bash
composer require fperdomo/laravel-agent-skill --dev
```

## Usage

### Quick Install - Everything
```bash
# Install all adapters and primary skill location
php artisan lbpa:install

# Overwrite existing files
php artisan lbpa:install --force
```

### Publish Skills to Different Locations

**Project workspace (primary location):**
```bash
php artisan vendor:publish --tag=lbpa-skill
# Publishes to: .codex/skills/laravel-best-practices/
```

**User home directory (global, shared across all projects):**
```bash
php artisan vendor:publish --tag=lbpa-skill-home
# Publishes to: ~/.codex/skills/laravel-best-practices/
```

**VS Code specific location:**
```bash
php artisan vendor:publish --tag=lbpa-skill-vscode
# Publishes to: .vscode/codex/skills/laravel-best-practices/
```

**JetBrains IDEs (PhpStorm, IntelliJ, etc.):**
```bash
php artisan vendor:publish --tag=lbpa-skill-jetbrains
# Publishes to: .idea/codex/skills/laravel-best-practices/
```

**All skill locations at once:**
```bash
php artisan vendor:publish --tag=lbpa-skill-all
# Publishes to: project, home, vscode, and jetbrains locations
```

### Publish AI Agent Adapters

**Claude adapter:**
```bash
php artisan vendor:publish --tag=lbpa-claude
# Publishes to: CLAUDE.md
```

**GitHub Copilot adapter:**
```bash
php artisan vendor:publish --tag=lbpa-copilot
# Publishes to: .github/copilot-instructions.md
```

**Generic agents documentation:**
```bash
php artisan vendor:publish --tag=lbpa-agents
# Publishes to: AGENTS.md
```

**All adapters + primary skill:**
```bash
php artisan vendor:publish --tag=lbpa-all
# Publishes everything to standard locations
```

## Published Structure

After publishing, your repository will contain:
- `.codex/skills/laravel-best-practices/SKILL.md`
- `.codex/skills/laravel-best-practices/references/*`
- `.codex/skills/laravel-best-practices/scripts/*`
- AI agent adapter files (CLAUDE.md, .github/copilot-instructions.md, AGENTS.md)

## Where AI Agents Look for Skills

Different AI agents and editors check for skills in various locations:

1. **Project Workspace** (`.codex/skills/`) - Most common, project-specific
2. **User Home** (`~/.codex/skills/`) - Global, shared across all projects
3. **VS Code** (`.vscode/codex/skills/`) - VS Code extension specific
4. **JetBrains** (`.idea/codex/skills/`) - PhpStorm, IntelliJ IDEA, etc.

Choose the location that best fits your workflow:
- Use **project workspace** for project-specific customizations
- Use **home directory** to share skills across all your Laravel projects
- Use **editor-specific** locations if you work in a team with mixed editors
