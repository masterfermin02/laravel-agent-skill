<?php

use Illuminate\Support\Facades\File;

beforeEach(function () {
    // Clean up any test files that might exist
    $paths = [
        base_path('.codex/skills/laravel-best-practices'),
        base_path('CLAUDE.md'),
        base_path('.github/copilot-instructions.md'),
        base_path('AGENTS.md'),
    ];

    foreach ($paths as $path) {
        if (File::exists($path)) {
            if (File::isDirectory($path)) {
                File::deleteDirectory($path);
            } else {
                File::delete($path);
            }
        }
    }
});

afterEach(function () {
    // Clean up after tests
    $paths = [
        base_path('.codex'),
        base_path('CLAUDE.md'),
        base_path('.github'),
        base_path('AGENTS.md'),
    ];

    foreach ($paths as $path) {
        if (File::exists($path)) {
            if (File::isDirectory($path)) {
                File::deleteDirectory($path);
            } else {
                File::delete($path);
            }
        }
    }
});

it('can run the install command successfully', function () {
    $this->artisan('lbpa:install')
        ->assertExitCode(0);
});

it('publishes files with default tag (lbpa-all)', function () {
    $this->artisan('lbpa:install')
        ->expectsOutput('Publishing assets using tag [lbpa-all]...')
        ->expectsOutput('Done.')
        ->assertExitCode(0);

    expect(File::exists(base_path('.codex/skills/laravel-best-practices')))->toBeTrue()
        ->and(File::exists(base_path('CLAUDE.md')))->toBeTrue()
        ->and(File::exists(base_path('.github/copilot-instructions.md')))->toBeTrue()
        ->and(File::exists(base_path('AGENTS.md')))->toBeTrue();
});

it('can publish with custom tag', function () {
    $this->artisan('lbpa:install', ['--tag' => 'lbpa-skill'])
        ->expectsOutput('Publishing assets using tag [lbpa-skill]...')
        ->assertExitCode(0);

    expect(File::exists(base_path('.codex/skills/laravel-best-practices')))->toBeTrue();
});

it('can force overwrite existing files', function () {
    // First installation
    $this->artisan('lbpa:install')->assertExitCode(0);

    // Create a test file to verify it gets overwritten
    File::put(base_path('CLAUDE.md'), 'test content');

    // Force reinstall
    $this->artisan('lbpa:install', ['--force' => true])
        ->assertExitCode(0);

    expect(File::get(base_path('CLAUDE.md')))->not->toBe('test content');
});

it('publishes only claude adapter with lbpa-claude tag', function () {
    $this->artisan('lbpa:install', ['--tag' => 'lbpa-claude'])
        ->assertExitCode(0);

    expect(File::exists(base_path('CLAUDE.md')))->toBeTrue();
});

it('publishes only copilot adapter with lbpa-copilot tag', function () {
    $this->artisan('lbpa:install', ['--tag' => 'lbpa-copilot'])
        ->assertExitCode(0);

    expect(File::exists(base_path('.github/copilot-instructions.md')))->toBeTrue();
});

it('publishes only agents adapter with lbpa-agents tag', function () {
    $this->artisan('lbpa:install', ['--tag' => 'lbpa-agents'])
        ->assertExitCode(0);

    expect(File::exists(base_path('AGENTS.md')))->toBeTrue();
});
