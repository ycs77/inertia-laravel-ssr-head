<?php

namespace Inertia\SSRHead\Tests;

use Inertia\SSRHead\InertiaSSRHeadServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function defineEnvironment($app)
    {
        $app['view']->addLocation(__DIR__.'/stubs/views');
    }

    protected function getPackageProviders($app)
    {
        return [
            InertiaSSRHeadServiceProvider::class,
        ];
    }
}
