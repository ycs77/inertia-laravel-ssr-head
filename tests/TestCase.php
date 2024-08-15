<?php

namespace Inertia\SSRHead\Tests;

use Inertia\SSRHead\InertiaSSRHeadServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function defineEnvironment($app): void
    {
        $app['view']->addLocation(__DIR__.'/stubs/views');
    }

    protected function getPackageProviders($app): array
    {
        return [
            InertiaSSRHeadServiceProvider::class,
        ];
    }
}
