<?php

namespace Inertia\SSRHead;

/**
 * @mixin \Inertia\Response
 *
 * @property array $viewData
 */
class ResponseMacros
{
    /** @return \Inertia\SSRHead\HeadManager */
    public function headManager()
    {
        return function () {
            if (! isset($this->viewData['headManager'])) {
                $this->withViewData('headManager', app(HeadManager::class));
            }

            return $this->viewData['headManager'];
        };
    }

    public function tag()
    {
        return function (string $html, ...$vars) {
            $this->headManager()->tag($html, ...$vars);

            return $this;
        };
    }

    public function title()
    {
        return function (?string $title, $template = null) {
            $this->headManager()->title($title, $template);
            $this->with('title', $this->headManager()->getFullTitle());

            return $this;
        };
    }

    public function titleTemplate()
    {
        return function ($template) {
            $this->headManager()->titleTemplate($template);
            $this->with('title', $this->headManager()->getFullTitle());

            return $this;
        };
    }

    public function description()
    {
        return function (string $description) {
            $this->headManager()->description($description);

            return $this;
        };
    }

    public function image()
    {
        return function (string $image) {
            $this->headManager()->image($image);

            return $this;
        };
    }

    public function ogMeta()
    {
        return function (array $meta = []) {
            $this->headManager()->ogMeta($meta);

            return $this;
        };
    }

    public function ogUrl()
    {
        return function (string $url = null) {
            $this->headManager()->ogUrl($url);

            return $this;
        };
    }

    public function ogTitle()
    {
        return function (string $title = null) {
            $this->headManager()->ogTitle($title);

            return $this;
        };
    }

    public function ogDescription()
    {
        return function (string $description = null) {
            $this->headManager()->ogDescription($description);

            return $this;
        };
    }

    public function ogImage()
    {
        return function ($image = null) {
            $this->headManager()->ogImage($image);

            return $this;
        };
    }

    public function ogVideo()
    {
        return function (array $video) {
            $this->headManager()->ogVideo($video);

            return $this;
        };
    }

    public function ogType()
    {
        return function (string $type = 'website') {
            $this->headManager()->ogType($type);

            return $this;
        };
    }

    public function ogLocale()
    {
        return function (string $locale) {
            $this->headManager()->ogLocale($locale);

            return $this;
        };
    }

    public function fbAppID()
    {
        return function (string $id = null) {
            $this->headManager()->fbAppID($id);

            return $this;
        };
    }

    public function twitterCard()
    {
        return function (string $type = 'summary') {
            $this->headManager()->twitterCard($type);

            return $this;
        };
    }

    public function twitterSummaryCard()
    {
        return function (array $meta = []) {
            $this->headManager()->twitterSummaryCard($meta);

            return $this;
        };
    }

    public function twitterLargeCard()
    {
        return function (array $meta = []) {
            $this->headManager()->twitterLargeCard($meta);

            return $this;
        };
    }

    public function twitterAppCard()
    {
        return function (array $meta = []) {
            $this->headManager()->twitterAppCard($meta);

            return $this;
        };
    }

    public function twitterPlayerCard()
    {
        return function (array $meta = []) {
            $this->headManager()->twitterPlayerCard($meta);

            return $this;
        };
    }

    public function twitterTitle()
    {
        return function (string $title = null) {
            $this->headManager()->twitterTitle($title);

            return $this;
        };
    }

    public function twitterDescription()
    {
        return function (string $description = null) {
            $this->headManager()->twitterDescription($description);

            return $this;
        };
    }

    public function twitterImage()
    {
        return function (string $image = null, string $alt = null) {
            $this->headManager()->twitterImage($image, $alt);

            return $this;
        };
    }

    public function twitterSite()
    {
        return function (string $username = null, string $id = null) {
            $this->headManager()->twitterSite($username, $id);

            return $this;
        };
    }

    public function twitterCreator()
    {
        return function (string $username = null, string $id = null) {
            $this->headManager()->twitterCreator($username, $id);

            return $this;
        };
    }

    public function twitterAppForIphone()
    {
        return function (array $app = []) {
            $this->headManager()->twitterAppForIphone($app);

            return $this;
        };
    }

    public function twitterAppForIpad()
    {
        return function (array $app = []) {
            $this->headManager()->twitterAppForIpad($app);

            return $this;
        };
    }

    public function twitterAppForGoogleplay()
    {
        return function (array $app = []) {
            $this->headManager()->twitterAppForGoogleplay($app);

            return $this;
        };
    }

    public function twitterAppCountry()
    {
        return function (string $country) {
            $this->headManager()->twitterAppCountry($country);

            return $this;
        };
    }

    public function twitterPlayer()
    {
        return function (array $player) {
            $this->headManager()->twitterPlayer($player);

            return $this;
        };
    }
}
