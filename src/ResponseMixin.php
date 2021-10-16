<?php

namespace Inertia\SSRHead;

/**
 * @mixin \Inertia\Response
 */
class ResponseMixin
{
    /**
     * @return \Inertia\SSRHead\HeadManager
     */
    public function headManager()
    {
        return function () {
            if (! isset($this->viewData['headManager'])) {
                $this->withViewData('headManager', app(HeadManager::class));
            }

            return $this->viewData['headManager'];
        };
    }

    public function title()
    {
        return function ($title) {
            $this->with('title', $title);
            $this->headManager()->title($title);

            return $this;
        };
    }

    public function description()
    {
        return function ($description) {
            $this->headManager()->description($description);

            return $this;
        };
    }

    public function image()
    {
        return function ($image) {
            $this->headManager()->image($image);

            return $this;
        };
    }

    public function ogMeta()
    {
        return function () {
            $this->headManager()
                ->ogTitle()
                ->ogDescription()
                ->ogImage();

            return $this;
        };
    }

    public function ogTitle()
    {
        return function ($title) {
            $this->headManager()->ogTitle($title);

            return $this;
        };
    }

    public function ogDescription()
    {
        return function ($description) {
            $this->headManager()->ogDescription($description);

            return $this;
        };
    }

    public function ogImage()
    {
        return function ($image) {
            $this->headManager()->ogImage($image);

            return $this;
        };
    }

    public function twitterMeta()
    {
        return function () {
            $this->headManager()
                ->twitterTitle()
                ->twitterDescription()
                ->twitterImage();

            return $this;
        };
    }

    public function twitterTitle()
    {
        return function ($title) {
            $this->headManager()->twitterTitle($title);

            return $this;
        };
    }

    public function twitterDescription()
    {
        return function ($description) {
            $this->headManager()->twitterDescription($description);

            return $this;
        };
    }

    public function twitterImage()
    {
        return function ($image) {
            $this->headManager()->twitterImage($image);

            return $this;
        };
    }
}
