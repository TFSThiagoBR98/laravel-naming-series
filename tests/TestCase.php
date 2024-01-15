<?php

namespace TFSThiagoBR98\LaravelNamingSeries\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use TFSThiagoBR98\LaravelNamingSeries\LaravelNamingSeriesServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelNamingSeriesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_laravel-naming-series_table.php.stub';
        $migration->up();
    }
}
