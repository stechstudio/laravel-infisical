<?php

namespace STS\Infisical;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InfisicalServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('infisical')
            ->hasConfigFile()
            ->hasCommands([
                Commands\Verify::class,
                Commands\Merge::class,
            ]);
    }
}
