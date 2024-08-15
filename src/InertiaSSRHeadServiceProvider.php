<?php

namespace Inertia\SSRHead;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Inertia\Response;
use Inertia\ResponseFactory as InertiaResponseFactory;

class InertiaSSRHeadServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/inertia-ssr-head.php', 'inertia-ssr-head');

        $this->app->singleton(HeadManager::class, fn () => new HeadManager());

        $this->app->bind(InertiaResponseFactory::class, ResponseFactory::class);
    }

    public function boot(): void
    {
        $this->registerMacros();
        $this->registerBladeDirectives();
        $this->publishingFiles();
    }

    protected function registerMacros(): void
    {
        Response::mixin(new ResponseMacros);
    }

    protected function registerBladeDirectives(): void
    {
        Blade::directive('inertiaHead', fn () => "<?php echo app(\Inertia\SSRHead\HeadManager::class)->format(4)->render().\"\\n\"; ?>");
    }

    protected function publishingFiles(): void
    {
        $this->publishes([
            __DIR__.'/../config/inertia-ssr-head.php' => config_path('inertia-ssr-head.php'),
        ], 'inertia-ssr-head-config');
    }
}
