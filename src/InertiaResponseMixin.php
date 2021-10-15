<?php

namespace Ycs77\InertiaSSRHead;

/**
 * @mixin \Inertia\Response
 */
class InertiaResponseMixin
{
    public function title()
    {
        return function ($title) {
            $this->with('title', $title);

            $openGraph = $this->viewData['openGraph'];
            $openGraph['title'] = $title;
            $this->viewData['openGraph'] = $openGraph;

            return $this;
        };
    }

    public function description()
    {
        return function ($description) {
            $openGraph = $this->viewData['openGraph'];
            $openGraph['description'] = $description;
            $this->viewData['openGraph'] = $openGraph;

            return $this;
        };
    }

    public function image()
    {
        return function ($image) {
            $openGraph = $this->viewData['openGraph'];
            $openGraph['image'] = $image;
            $this->viewData['openGraph'] = $openGraph;

            return $this;
        };
    }

    public function ogMeta()
    {
        return function () {
            $this->ogTitle();
            $this->ogDescription();
            $this->ogImage();

            return $this;
        };
    }

    public function ogTitle()
    {
        return function ($title = null) {
            $openGraph = $this->viewData['openGraph'];
            $openGraph['og:title'] = $title ?? $openGraph['title'] ?? $this->props['title'];
            $this->viewData['openGraph'] = $openGraph;

            return $this;
        };
    }

    public function ogDescription()
    {
        return function ($description = null) {
            $openGraph = $this->viewData['openGraph'];
            $openGraph['og:description'] = $description ?? $openGraph['description'];
            $this->viewData['openGraph'] = $openGraph;

            return $this;
        };
    }

    public function ogImage()
    {
        return function ($image = null) {
            $openGraph = $this->viewData['openGraph'];
            $openGraph['og:image'] = $image ?? $openGraph['image'];
            $this->viewData['openGraph'] = $openGraph;

            return $this;
        };
    }

    public function twitterMeta()
    {
        return function () {
            $this->twitterTitle();
            $this->twitterDescription();
            $this->twitterImage();

            return $this;
        };
    }

    public function twitterTitle()
    {
        return function ($title = null) {
            $openGraph = $this->viewData['openGraph'];
            $openGraph['twitter:title'] = $title ?? $openGraph['title'];
            $this->viewData['openGraph'] = $openGraph;

            return $this;
        };
    }

    public function twitterDescription()
    {
        return function ($description = null) {
            $openGraph = $this->viewData['openGraph'];
            $openGraph['twitter:description'] = $description ?? $openGraph['description'];
            $this->viewData['openGraph'] = $openGraph;

            return $this;
        };
    }

    public function twitterImage()
    {
        return function ($image = null) {
            $openGraph = $this->viewData['openGraph'];
            $openGraph['twitter:image'] = $image ?? $openGraph['image'];
            $this->viewData['openGraph'] = $openGraph;

            return $this;
        };
    }
}
