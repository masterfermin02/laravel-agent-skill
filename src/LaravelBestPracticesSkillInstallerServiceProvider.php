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
        $homeDir = $_SERVER['HOME'] ?? getenv('HOME') ?: getenv('USERPROFILE') ?: null;
        $homeSkillTarget = $homeDir ? $homeDir . '/.codex/skills/laravel-best-practices' : null;

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

        // Laravel Boost skills (auto-discovered by boost:install, published to .ai/skills/)
        $boostSkillSource = __DIR__ . '/../resources/boost/skills/laravel-best-practices';
        $boostSkillTarget = base_path('.ai/skills/laravel-best-practices');

        $boostInertiaSource = __DIR__ . '/../resources/boost/skills/inertia-development';
        $boostInertiaTarget = base_path('.ai/skills/inertia-development');

        // Tag: lbpa-skill → .codex/skills/... (project workspace - primary)
        $this->publishes([
            $skillSource => $skillTarget,
        ], 'lbpa-skill');

        // Tag: lbpa-skill-home → ~/.codex/skills/... (user home - global)
        if ($homeSkillTarget) {
            $this->publishes([
                $skillSource => $homeSkillTarget,
            ], 'lbpa-skill-home');
        }

        // Tag: lbpa-skill-vscode → .vscode/codex/skills/... (VS Code specific)
        $this->publishes([
            $skillSource => $vscodeSkillTarget,
        ], 'lbpa-skill-vscode');

        // Tag: lbpa-skill-jetbrains → .idea/codex/skills/... (JetBrains specific)
        $this->publishes([
            $skillSource => $jetbrainsSkillTarget,
        ], 'lbpa-skill-jetbrains');

        // Tag: lbpa-skill-all → all skill locations
        // Multiple publishes() calls with the same tag are merged by Laravel
        $this->publishes([$skillSource => $skillTarget], 'lbpa-skill-all');
        $this->publishes([$skillSource => $vscodeSkillTarget], 'lbpa-skill-all');
        $this->publishes([$skillSource => $jetbrainsSkillTarget], 'lbpa-skill-all');
        if ($homeSkillTarget) {
            $this->publishes([$skillSource => $homeSkillTarget], 'lbpa-skill-all');
        }

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

        // Tag: lbpa-boost → .ai/skills/ (Laravel Boost compatible — all Boost skills)
        $this->publishes([
            $boostSkillSource  => $boostSkillTarget,
            $boostInertiaSource => $boostInertiaTarget,
        ], 'lbpa-boost');

        // Tag: lbpa-all → everything (all adapters + primary skill location + boost)
        $this->publishes([
            $skillSource        => $skillTarget,
            $claudeSource       => $claudeTarget,
            $copilotSource      => $copilotTarget,
            $agentsSource       => $agentsTarget,
            $boostSkillSource   => $boostSkillTarget,
            $boostInertiaSource => $boostInertiaTarget,
        ], 'lbpa-all');
    }
}
