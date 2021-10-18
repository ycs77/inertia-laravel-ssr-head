<?php

namespace Inertia\SSRHead;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Inertia\Response;

class InertiaSSRHeadServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(HeadManager::class, function ($app) {
            return new HeadManager();
        });

        $this->mergeConfigFrom(__DIR__.'/../config/inertia-ssr-head.php', 'inertia-ssr-head');
    }

    public function boot()
    {
        $this->registerInertiaResponseMacros();
        $this->registerBladeDirectives();
        $this->publishingFiles();
    }

    protected function registerInertiaResponseMacros()
    {
        Response::mixin(new ResponseMacros);
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('inertiaHead', function () {
            return "<?php echo app(\Inertia\SSRHead\HeadManager::class)->format(4)->render().\"\\n\"; ?>";
        });
    }

    protected function publishingFiles()
    {
        $this->publishes([
            __DIR__.'/../config/inertia-ssr-head.php' => config_path('inertia-ssr-head.php'),
        ], 'inertia-ssr-head-config');
    }
}
