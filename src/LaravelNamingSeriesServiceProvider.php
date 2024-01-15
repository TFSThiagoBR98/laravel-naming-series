<?php

declare(strict_types=1);

namespace TFSThiagoBR98\LaravelNamingSeries;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelNamingSeriesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-naming-series')
            ->hasConfigFile()
            ->hasMigration('create_naming_series_table.php');
    }

    public function packageRegistered(): void
    {
        //
    }
}
