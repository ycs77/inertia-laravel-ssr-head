<?php

namespace Ycs77\InertiaSSRHead\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ycs77\InertiaSSRHead\InertiaSSRHead
 */
class InertiaSSRHead extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'inertia-laravel-ssr-head';
    }
}
