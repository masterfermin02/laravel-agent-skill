<?php

namespace Tests;

use \Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \FPerdomo\LaravelBestPracticesSkillInstaller\LaravelBestPracticesSkillInstallerServiceProvider::class,
        ];
    }
}
