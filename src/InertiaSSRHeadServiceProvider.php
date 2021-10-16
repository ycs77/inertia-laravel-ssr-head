<?php

namespace Inertia\SSRHead;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Inertia\Response;

class InertiaSSRHeadServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/inertia-ssr-head.php', 'inertia-ssr-head');
    }

    public function boot()
    {
        $this->registerInertiaResponseMixin();
        $this->registerTitleDirective();
    }

    protected function registerInertiaResponseMixin()
    {
        Response::mixin(new InertiaResponseMixin);
    }

    protected function registerTitleDirective()
    {
        Blade::directive('inertiaTitle', function () {
            return '<?php echo $page[\'props\'][\'title\'] ?? $title ?? config(\'app.name\'); ?>';
        });

        Blade::directive('inertiaOpenGraph', function () {
            return '<?php echo (new \Inertia\SSRHead\InertiaOpenGraphTags($openGraph))->render(); ?>';
        });
    }
}
