<?php

use FPerdomo\LaravelBestPracticesSkillInstaller\LaravelBestPracticesSkillInstallerServiceProvider;
use FPerdomo\LaravelBestPracticesSkillInstaller\Console\InstallAllAdaptersCommand;

it('can be instantiated', function () {
    $provider = new LaravelBestPracticesSkillInstallerServiceProvider($this->app);

    expect($provider)->toBeInstanceOf(LaravelBestPracticesSkillInstallerServiceProvider::class);
});

it('registers the install command', function () {
    // Verify we can run the command
    $this->artisan('lbpa:install', ['--help'])
        ->assertExitCode(0);
});

it('service provider is loaded', function () {
    $providers = $this->app->getLoadedProviders();

    expect($providers)->toHaveKey(LaravelBestPracticesSkillInstallerServiceProvider::class);
});

it('registers multiple publish tags', function () {
    $expectedTags = [
        'lbpa-skill',
        'lbpa-skill-home',
        'lbpa-skill-vscode',
        'lbpa-skill-jetbrains',
        'lbpa-skill-all',
        'lbpa-claude',
        'lbpa-copilot',
        'lbpa-agents',
        'lbpa-all',
    ];

    foreach ($expectedTags as $tag) {
        $paths = LaravelBestPracticesSkillInstallerServiceProvider::pathsToPublish(
            LaravelBestPracticesSkillInstallerServiceProvider::class,
            $tag
        );
        expect($paths)->not->toBeEmpty("Tag '{$tag}' should have publishable paths");
    }
});
