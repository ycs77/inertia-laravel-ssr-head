<?php

namespace Inertia\SSRHead;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Inertia\Response;
use Inertia\ResponseFactory as InertiaResponseFactory;

class InertiaSSRHeadServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/inertia-ssr-head.php', 'inertia-ssr-head');

        $this->app->singleton(HeadManager::class, function () {
            return new HeadManager();
        });

        $this->app->bind(InertiaResponseFactory::class, ResponseFactory::class);
    }

    public function boot()
    {
        $this->registerMacros();
        $this->registerBladeDirectives();
        $this->publishingFiles();
    }

    protected function registerMacros()
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
