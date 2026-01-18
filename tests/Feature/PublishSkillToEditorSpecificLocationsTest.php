<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    $paths = [
        base_path('.vscode/codex'),
        base_path('.idea/codex'),
    ];

    foreach ($paths as $path) {
        if (File::exists($path)) {
            File::deleteDirectory($path);
        }
    }
});

it('can publish skill to vscode location', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-vscode'])
        ->assertExitCode(0);

    $skillPath = base_path('.vscode/codex/skills/laravel-best-practices');

    expect(File::exists($skillPath))->toBeTrue()
        ->and(File::isDirectory($skillPath))->toBeTrue();
});

it('can publish skill to jetbrains location', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-jetbrains'])
        ->assertExitCode(0);

    $skillPath = base_path('.idea/codex/skills/laravel-best-practices');

    expect(File::exists($skillPath))->toBeTrue()
        ->and(File::isDirectory($skillPath))->toBeTrue();
});

it('creates vscode directory structure', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-vscode'])
        ->assertExitCode(0);

    expect(File::exists(base_path('.vscode')))->toBeTrue()
        ->and(File::isDirectory(base_path('.vscode')))->toBeTrue()
        ->and(File::exists(base_path('.vscode/codex')))->toBeTrue()
        ->and(File::isDirectory(base_path('.vscode/codex')))->toBeTrue();
});

it('creates jetbrains directory structure', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-jetbrains'])
        ->assertExitCode(0);

    expect(File::exists(base_path('.idea')))->toBeTrue()
        ->and(File::isDirectory(base_path('.idea')))->toBeTrue()
        ->and(File::exists(base_path('.idea/codex')))->toBeTrue()
        ->and(File::isDirectory(base_path('.idea/codex')))->toBeTrue();
});

it('copies all skill files to vscode location', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-vscode'])
        ->assertExitCode(0);

    $skillPath = base_path('.vscode/codex/skills/laravel-best-practices');

    expect(File::allFiles($skillPath))->not->toBeEmpty();
});

it('copies all skill files to jetbrains location', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-jetbrains'])
        ->assertExitCode(0);

    $skillPath = base_path('.idea/codex/skills/laravel-best-practices');

    expect(File::allFiles($skillPath))->not->toBeEmpty();
});

it('can force overwrite existing vscode skill files', function () {
    $skillPath = base_path('.vscode/codex/skills/laravel-best-practices');
    File::ensureDirectoryExists($skillPath);
    File::put($skillPath . '/test.txt', 'test content');

    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-vscode', '--force' => true])
        ->assertExitCode(0);

    expect(File::exists($skillPath))->toBeTrue();
});

it('can force overwrite existing jetbrains skill files', function () {
    $skillPath = base_path('.idea/codex/skills/laravel-best-practices');
    File::ensureDirectoryExists($skillPath);
    File::put($skillPath . '/test.txt', 'test content');

    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-jetbrains', '--force' => true])
        ->assertExitCode(0);

    expect(File::exists($skillPath))->toBeTrue();
});
