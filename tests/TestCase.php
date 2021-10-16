<?php

namespace Inertia\SSRHead\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Inertia\SSRHead\InertiaSSRHeadServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            InertiaSSRHeadServiceProvider::class,
        ];
    }
}
