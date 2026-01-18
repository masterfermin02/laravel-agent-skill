<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    $path = $_SERVER['HOME'] . '/.codex/skills/laravel-best-practices';
    if (File::exists($path)) {
        File::deleteDirectory($path);
    }
});

it('can publish skill to home directory', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-home'])
        ->assertExitCode(0);

    $skillPath = $_SERVER['HOME'] . '/.codex/skills/laravel-best-practices';

    expect(File::exists($skillPath))->toBeTrue()
        ->and(File::isDirectory($skillPath))->toBeTrue();
});

it('creates necessary directory structure in home directory', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-home'])
        ->assertExitCode(0);

    $basePath = $_SERVER['HOME'] . '/.codex';

    expect(File::exists($basePath))->toBeTrue()
        ->and(File::isDirectory($basePath))->toBeTrue()
        ->and(File::exists($basePath . '/skills'))->toBeTrue()
        ->and(File::isDirectory($basePath . '/skills'))->toBeTrue();
});

it('copies all skill files to home directory', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-home'])
        ->assertExitCode(0);

    $skillPath = $_SERVER['HOME'] . '/.codex/skills/laravel-best-practices';

    expect(File::exists($skillPath))->toBeTrue()
        ->and(File::allFiles($skillPath))->not->toBeEmpty();
});

it('can force overwrite existing skill files in home directory', function () {
    $skillPath = $_SERVER['HOME'] . '/.codex/skills/laravel-best-practices';
    File::ensureDirectoryExists($skillPath);
    File::put($skillPath . '/test.txt', 'test content');

    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-home', '--force' => true])
        ->assertExitCode(0);

    expect(File::exists($skillPath))->toBeTrue();
});

it('publishes to different location than project workspace', function () {
    $homeSkillPath = $_SERVER['HOME'] . '/.codex/skills/laravel-best-practices';
    $projectSkillPath = base_path('.codex/skills/laravel-best-practices');

    $this->artisan('vendor:publish', ['--tag' => 'lbpa-skill-home'])
        ->assertExitCode(0);

    expect($homeSkillPath)->not->toBe($projectSkillPath)
        ->and(File::exists($homeSkillPath))->toBeTrue();
});
