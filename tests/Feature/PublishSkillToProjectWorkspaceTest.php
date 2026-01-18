<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    $path = base_path('.codex');
    if (File::exists($path)) {
        File::deleteDirectory($path);
    }
});

it('can publish skill to project workspace', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill'])
        ->assertExitCode(0);

    $skillPath = base_path('.codex/skills/laravel-best-practices');

    expect(File::exists($skillPath))->toBeTrue()
        ->and(File::isDirectory($skillPath))->toBeTrue();
});

it('creates necessary directory structure', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill'])
        ->assertExitCode(0);

    expect(File::exists(base_path('.codex')))->toBeTrue()
        ->and(File::isDirectory(base_path('.codex')))->toBeTrue()
        ->and(File::exists(base_path('.codex/skills')))->toBeTrue()
        ->and(File::isDirectory(base_path('.codex/skills')))->toBeTrue();
});

it('copies all skill files to project workspace', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill'])
        ->assertExitCode(0);

    $skillPath = base_path('.codex/skills/laravel-best-practices');

    expect(File::exists($skillPath))->toBeTrue()
        ->and(File::allFiles($skillPath))->not->toBeEmpty();
});

it('can force overwrite existing skill files', function () {
    $skillPath = base_path('.codex/skills/laravel-best-practices');
    File::ensureDirectoryExists($skillPath);
    File::put($skillPath . '/test.txt', 'test content');

    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill', '--force' => true])
        ->assertExitCode(0);

    expect(File::exists($skillPath))->toBeTrue();
});
