<?php

namespace Inertia\SSRHead;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Inertia\Response;
use Inertia\SSRHead\HTML\Renderer;

class InertiaSSRHeadServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(HeadManager::class, function ($app) {
            return new HeadManager($app->make(Renderer::class), []);
        });

        $this->mergeConfigFrom(__DIR__.'/../config/inertia-ssr-head.php', 'inertia-ssr-head');
    }

    public function boot()
    {
        $this->registerInertiaResponseMixin();
        $this->registerBladeDirectives();
    }

    protected function registerInertiaResponseMixin()
    {
        Response::mixin(new ResponseMixin);
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('inertiaHead', function () {
            return "<?php echo app(\Inertia\SSRHead\HeadManager::class)->renderer()->format(8)->render().\"\\n\"; ?>";
        });
    }
}
