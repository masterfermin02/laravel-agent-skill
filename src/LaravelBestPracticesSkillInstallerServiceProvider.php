<?php

namespace FPerdomo\LaravelBestPracticesSkillInstaller;

use Illuminate\Support\ServiceProvider;
use FPerdomo\LaravelBestPracticesSkillInstaller\Console\InstallAllAdaptersCommand;

class LaravelBestPracticesSkillInstallerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Optional: register command to run publish programmatically
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallAllAdaptersCommand::class,
            ]);
        }
    }

    public function boot(): void
    {
        $skillSource = __DIR__ . '/../resources/skills/laravel-best-practices';

        // Primary project workspace location (most common)
        $skillTarget = base_path('.codex/skills/laravel-best-practices');

        // User home directory location (global/shared across projects)
        $homeSkillTarget = $_SERVER['HOME'] . '/.codex/skills/laravel-best-practices';

        // VS Code specific location
        $vscodeSkillTarget = base_path('.vscode/codex/skills/laravel-best-practices');

        // JetBrains specific location (for PhpStorm, IntelliJ, etc.)
        $jetbrainsSkillTarget = base_path('.idea/codex/skills/laravel-best-practices');

        $claudeSource = __DIR__ . '/../resources/adapters/CLAUDE.md';
        $claudeTarget = base_path('CLAUDE.md'); // or base_path('.claude/CLAUDE.md')

        $copilotSource = __DIR__ . '/../resources/adapters/copilot-instructions.md';
        $copilotTarget = base_path('.github/copilot-instructions.md');

        $agentsSource = __DIR__ . '/../resources/adapters/AGENTS.md';
        $agentsTarget = base_path('AGENTS.md');

        // Tag: lbpa-skill → .codex/skills/... (project workspace - primary)
        $this->publishes([
            $skillSource => $skillTarget,
        ], 'lbpa-skill');

        // Tag: lbpa-skill-home → ~/.codex/skills/... (user home - global)
        $this->publishes([
            $skillSource => $homeSkillTarget,
        ], 'lbpa-skill-home');

        // Tag: lbpa-skill-vscode → .vscode/codex/skills/... (VS Code specific)
        $this->publishes([
            $skillSource => $vscodeSkillTarget,
        ], 'lbpa-skill-vscode');

        // Tag: lbpa-skill-jetbrains → .idea/codex/skills/... (JetBrains specific)
        $this->publishes([
            $skillSource => $jetbrainsSkillTarget,
        ], 'lbpa-skill-jetbrains');

        // Tag: lbpa-skill-all → all skill locations
        $this->publishes([
            $skillSource => $skillTarget,
            $skillSource => $homeSkillTarget,
            $skillSource => $vscodeSkillTarget,
            $skillSource => $jetbrainsSkillTarget,
        ], 'lbpa-skill-all');

        // Tag: lbpa-claude → CLAUDE.md
        $this->publishes([
            $claudeSource => $claudeTarget,
        ], 'lbpa-claude');

        // Tag: lbpa-copilot → .github/copilot-instructions.md
        $this->publishes([
            $copilotSource => $copilotTarget,
        ], 'lbpa-copilot');

        // Tag: lbpa-agents → AGENTS.md (optional but useful)
        $this->publishes([
            $agentsSource => $agentsTarget,
        ], 'lbpa-agents');

        // Tag: lbpa-all → everything (all adapters + primary skill location)
        $this->publishes([
            $skillSource => $skillTarget,
            $claudeSource => $claudeTarget,
            $copilotSource => $copilotTarget,
            $agentsSource => $agentsTarget,
        ], 'lbpa-all');
    }
}
