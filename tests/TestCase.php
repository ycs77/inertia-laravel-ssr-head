<?php

namespace Ycs77\InertiaSSRHead\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Ycs77\InertiaSSRHead\InertiaSSRHeadServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            InertiaSSRHeadServiceProvider::class,
        ];
    }
}
