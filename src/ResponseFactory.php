<?php

namespace Inertia\SSRHead;

use Inertia\Response;
use Inertia\ResponseFactory as BaseResponseFactory;

class ResponseFactory extends BaseResponseFactory
{
    protected bool $usingTitleTemplate = false;

    public function titleTemplate($template)
    {
        $this->usingTitleTemplate = true;

        app(HeadManager::class)->titleTemplate($template);

        return $this;
    }

    public function render($component, $props = []): Response
    {
        return tap(parent::render($component, $props), function (Response $response) {
            if ($this->usingTitleTemplate) {
                $response->with('title', app(HeadManager::class)->getFullTitle());
            }
        });
    }
}
