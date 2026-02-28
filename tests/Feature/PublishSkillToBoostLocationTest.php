<?php

afterEach(function () {
    $boostPath = base_path('.ai');
    if (is_dir($boostPath)) {
        (new \Illuminate\Filesystem\Filesystem)->deleteDirectory($boostPath);
    }
});

test('can publish skill to Laravel Boost location', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-boost'])
        ->assertExitCode(0);

    expect(base_path('.ai/skills/laravel-best-practices'))->toBeDirectory();
});

test('creates necessary directory structure for Boost', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-boost'])
        ->assertExitCode(0);

    expect(base_path('.ai'))->toBeDirectory();
    expect(base_path('.ai/skills'))->toBeDirectory();
});

test('copies SKILL.md to Boost location', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-boost'])
        ->assertExitCode(0);

    expect(base_path('.ai/skills/laravel-best-practices/SKILL.md'))->toBeFile();
});

test('Boost SKILL.md contains required frontmatter', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-boost'])
        ->assertExitCode(0);

    $content = file_get_contents(base_path('.ai/skills/laravel-best-practices/SKILL.md'));

    expect($content)->toContain('name: laravel-best-practices');
    expect($content)->toContain('description:');
});

test('can force overwrite existing Boost skill files', function () {
    $skillPath = base_path('.ai/skills/laravel-best-practices');
    mkdir($skillPath, 0755, true);
    file_put_contents($skillPath . '/SKILL.md', 'old content');

    $this->artisan('vendor:publish', ['--tag' => 'lbpa-boost', '--force' => true])
        ->assertExitCode(0);

    expect(file_get_contents($skillPath . '/SKILL.md'))->not->toBe('old content');
});

test('lbpa-boost tag also publishes inertia-development skill', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-boost'])
        ->assertExitCode(0);

    expect(base_path('.ai/skills/inertia-development/SKILL.md'))->toBeFile();
});

test('inertia-development SKILL.md contains required frontmatter', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-boost'])
        ->assertExitCode(0);

    $content = file_get_contents(base_path('.ai/skills/inertia-development/SKILL.md'));

    expect($content)->toContain('name: inertia-development');
    expect($content)->toContain('description:');
});

test('lbpa-all tag includes Boost skill location', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-all'])
        ->assertExitCode(0);

    expect(base_path('.ai/skills/laravel-best-practices/SKILL.md'))->toBeFile();
    expect(base_path('.ai/skills/inertia-development/SKILL.md'))->toBeFile();
});
