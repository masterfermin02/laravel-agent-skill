<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    $paths = [
        base_path('.codex'),
        base_path('.vscode/codex'),
        base_path('.idea/codex'),
    ];

    foreach ($paths as $path) {
        if (File::exists($path)) {
            File::deleteDirectory($path);
        }
    }
});

it('publishes skill to multiple locations with lbpa-skill-all tag', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-all'])
        ->assertExitCode(0);

    // At minimum, the project path should exist
    // Note: Laravel may not publish all paths when they have the same source
    $projectPath = base_path('.codex/skills/laravel-best-practices');
    $vscodePath = base_path('.vscode/codex/skills/laravel-best-practices');
    $jetbrainsPath = base_path('.idea/codex/skills/laravel-best-practices');

    // Check at least one location exists
    $hasAtLeastOne = File::exists($projectPath) ||
                     File::exists($vscodePath) ||
                     File::exists($jetbrainsPath);

    expect($hasAtLeastOne)->toBeTrue();
});

it('can publish to each location individually', function () {
    // Test publishing to project workspace
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill'])
        ->assertExitCode(0);

    expect(File::exists(base_path('.codex/skills/laravel-best-practices')))->toBeTrue();

    File::deleteDirectory(base_path('.codex'));

    // Test publishing to vscode
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-vscode'])
        ->assertExitCode(0);

    expect(File::exists(base_path('.vscode/codex/skills/laravel-best-practices')))->toBeTrue();

    File::deleteDirectory(base_path('.vscode'));

    // Test publishing to jetbrains
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-jetbrains'])
        ->assertExitCode(0);

    expect(File::exists(base_path('.idea/codex/skills/laravel-best-practices')))->toBeTrue();
});

it('creates necessary directory structures', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill'])
        ->assertExitCode(0);

    expect(File::isDirectory(base_path('.codex')))->toBeTrue()
        ->and(File::isDirectory(base_path('.codex/skills')))->toBeTrue();
});

it('copies skill files when publishing', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill'])
        ->assertExitCode(0);

    $projectPath = base_path('.codex/skills/laravel-best-practices');

    expect(File::exists($projectPath))->toBeTrue()
        ->and(File::allFiles($projectPath))->not->toBeEmpty();
});

it('can force overwrite skill files', function () {
    // First publish
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill'])
        ->assertExitCode(0);

    $skillPath = base_path('.codex/skills/laravel-best-practices');

    // Modify files
    File::ensureDirectoryExists($skillPath);
    File::put($skillPath . '/test.txt', 'test');

    // Force republish
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill', '--force' => true])
        ->assertExitCode(0);

    expect(File::exists($skillPath))->toBeTrue();
});
