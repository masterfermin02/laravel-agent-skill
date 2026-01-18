<?php

namespace FPerdomo\LaravelBestPracticesSkillInstaller\Console;

use Illuminate\Console\Command;

class InstallAllAdaptersCommand extends Command
{
    protected $signature = 'lbpa:install
                            {--force : Overwrite existing files}
                            {--tag=lbpa-all : Publish tag to use (default: lbpa-all)}';

    protected $description = 'Install/publish Laravel Best Practices agent skill and adapters (Codex, Claude Code, Copilot).';

    public function handle(): int
    {
        $tag = (string) $this->option('tag');
        $force = (bool) $this->option('force');

        $params = [
            '--tag' => $tag ?: 'lbpa-all',
        ];

        if ($force) {
            $params['--force'] = true;
        }

        $this->info("Publishing assets using tag [{$params['--tag']}]...");

        $code = $this->call('vendor:publish', $params);

        if ($code !== 0) {
            $this->error('Publishing failed.');
            return $code;
        }

        $this->info('Done.');
        return self::SUCCESS;
    }
}
