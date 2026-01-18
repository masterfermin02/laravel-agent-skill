<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    // Clean up after tests
    $paths = [
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

it('can publish claude adapter', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-claude'])
        ->assertExitCode(0);

    expect(File::exists(base_path('CLAUDE.md')))->toBeTrue()
        ->and(File::isFile(base_path('CLAUDE.md')))->toBeTrue();
});

it('can publish copilot adapter', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-copilot'])
        ->assertExitCode(0);

    expect(File::exists(base_path('.github/copilot-instructions.md')))->toBeTrue()
        ->and(File::isFile(base_path('.github/copilot-instructions.md')))->toBeTrue();
});

it('can publish agents adapter', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-agents'])
        ->assertExitCode(0);

    expect(File::exists(base_path('AGENTS.md')))->toBeTrue()
        ->and(File::isFile(base_path('AGENTS.md')))->toBeTrue();
});

it('publishes all adapters with lbpa-all tag', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-all'])
        ->assertExitCode(0);

    expect(File::exists(base_path('CLAUDE.md')))->toBeTrue()
        ->and(File::exists(base_path('.github/copilot-instructions.md')))->toBeTrue()
        ->and(File::exists(base_path('AGENTS.md')))->toBeTrue();
});

it('creates directories if they do not exist', function () {
    $this->artisan('vendor:publish', ['--tag' => 'lbpa-copilot'])
        ->assertExitCode(0);

    expect(File::exists(base_path('.github')))->toBeTrue()
        ->and(File::isDirectory(base_path('.github')))->toBeTrue();
});

it('can force overwrite existing adapter files', function () {
    File::ensureDirectoryExists(base_path('.github'));
    File::put(base_path('.github/copilot-instructions.md'), 'old content');

    $this->artisan('vendor:publish', ['--tag' => 'lbpa-copilot', '--force' => true])
        ->assertExitCode(0);

    expect(File::get(base_path('.github/copilot-instructions.md')))
        ->not->toBe('old content');
});
