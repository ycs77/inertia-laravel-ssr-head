<?php

namespace Inertia\SSRHead\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Inertia\SSRHead\InertiaSSRHeadServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use InteractsWithViews;

    protected function getPackageProviders($app)
    {
        return [
            InertiaSSRHeadServiceProvider::class,
        ];
    }
}
