<?php

namespace Ycs77\InertiaSSRHead;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InertiaSSRHeadServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('inertia-laravel-ssr-head')
            ->hasConfigFile('inertia-ssr-head')
            ->hasViews();
    }
}
