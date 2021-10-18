<?php

namespace Inertia\SSRHead;

class HeadManager
{
    protected $elements = [];

    protected $title;
    protected $titleTemplate = null;
    protected $description;
    protected $image;

    protected $space = 0;

    public function tag(string $element, ...$vars)
    {
        $element = sprintf($element, ...$vars);

        if (preg_match('/^\<meta (name|property)\="([\w\-:]+)"/', $element, $elementMatches) === 1) {
            $elementStart = $elementMatches[0];

            $matched = preg_grep('/^'.preg_quote($elementStart, '/').'/', $this->elements);
            if ($matched !== false && count($matched) >= 1) {
                $matchedKey = array_keys($matched)[0];

                // Replace exist <meta> element
                $this->elements[$matchedKey] = $element;
            } else {
                $this->elements[] = $element;
            }
        } else {
            $this->elements[] = $element;
        }

        return $this;
    }

    public function title(string $title, $template = null)
    {
        if ($template !== false && ($template || $this->titleTemplate)) {
            $title = sprintf(
                is_string($template) ? $template : $this->titleTemplate, $title
            );
        }

        $this->title = $title;
        $this->tag('<title inertia>%s</title>', e($title));

        return $this;
    }

    public function titleTemplate(?string $template)
    {
        $this->titleTemplate = $template;

        return $this;
    }

    public function description(string $description)
    {
        $this->description = $description;
        $this->tag('<meta name="description" content="%s" inertia>', e($description));

        return $this;
    }

    public function image(string $image)
    {
        $this->image = $image;

        return $this;
    }

    public function ogMeta(array $meta = [])
    {
        $this->ogTitle($meta['title'] ?? null);
        $this->ogDescription($meta['description'] ?? null);
        $this->ogImage($meta['image'] ?? null);

        return $this;
    }

    public function ogUrl(string $url = null)
    {
        $url = $url ?? url()->current();

        $this->tag('<meta property="og:url" content="%s" inertia>', e($url));

        return $this;
    }

    public function ogTitle(string $title = null)
    {
        if ($title = $title ?? $this->title) {
            $this->tag('<meta property="og:title" content="%s" inertia>', e($title));
        }

        return $this;
    }

    public function ogDescription(string $description = null)
    {
        if ($description = $description ?? $this->description) {
            $this->tag('<meta property="og:description" content="%s" inertia>', e($description));
        }

        return $this;
    }

    public function ogImage($image = null)
    {
        if (is_string($image) || (is_null($image) && $this->image)) {
            $image = $image ?? $this->image;
            $this->tag('<meta property="og:image" content="%s" inertia>', e($image));
        } elseif (is_array($image)) {
            foreach (['url', 'secure_url', 'type', 'width', 'height'] as $attr) {
                if (isset($image[$attr])) {
                    $this->tag('<meta property="og:image:%s" content="%s" inertia>', $attr, e($image[$attr]));
                }
            }
        }

        return $this;
    }

    public function ogVideo($video)
    {
        foreach (['url', 'secure_url', 'type', 'width', 'height'] as $attr) {
            if (isset($video[$attr])) {
                $this->tag('<meta property="og:video:%s" content="%s" inertia>', $attr, e($video[$attr]));
            }
        }

        if (isset($video['image'])) {
            $this->ogImage($video['image']);
        }

        return $this;
    }

    public function ogType(string $type = 'website')
    {
        $this->tag('<meta property="og:type" content="%s" inertia>', e($type));

        return $this;
    }

    public function ogLocale(string $locale)
    {
        $this->tag('<meta property="og:locale" content="%s" inertia>', e($locale));

        return $this;
    }

    public function fbAppID(string $id = null)
    {
        if ($id = $id ?? config('inertia-ssr-head.fb_app_id')) {
            $this->tag('<meta property="fb:app_id" content="%s" inertia>', e($id));
        }

        return $this;
    }

    public function twitterCard(string $type = 'summary')
    {
        $this->tag('<meta name="twitter:card" content="%s" inertia>', e($type));

        return $this;
    }

    public function twitterSummaryCard(array $meta = [])
    {
        $this->twitterCard('summary');
        $this->twitterTitle($meta['title'] ?? null);
        $this->twitterDescription($meta['description'] ?? null);
        $this->twitterImage($meta['image'] ?? null, $meta['image_alt'] ?? null);
        $this->twitterSite($meta['site'] ?? null, $meta['site_id'] ?? null);

        return $this;
    }

    public function twitterLargeCard(array $meta = [])
    {
        $this->twitterCard('summary_large_image');
        $this->twitterSite($meta['site'] ?? null, $meta['site_id'] ?? null);
        $this->twitterCreator($meta['creator'] ?? null, $meta['creator_id'] ?? null);
        $this->twitterTitle($meta['title'] ?? null);
        $this->twitterDescription($meta['description'] ?? null);
        $this->twitterImage($meta['image'] ?? null, $meta['image_alt'] ?? null);

        return $this;
    }

    public function twitterAppCard(array $meta = [])
    {
        $this->twitterCard('app');
        $this->twitterSite($meta['site'] ?? null, $meta['site_id'] ?? null);
        $this->twitterDescription($meta['description'] ?? null);

        if (isset($meta['country'])) {
            $this->twitterAppCountry($meta['country']);
        }

        return $this;
    }

    public function twitterPlayerCard(array $meta = [])
    {
        $this->twitterCard('player');
        $this->twitterSite($meta['site'] ?? null, $meta['site_id'] ?? null);
        $this->twitterTitle($meta['title'] ?? null);
        $this->twitterDescription($meta['description'] ?? null);
        $this->twitterPlayer([
            'url' => $meta['url'],
            'width' => $meta['width'],
            'height' => $meta['height'],
        ]);
        $this->twitterImage($meta['image'] ?? null, $meta['image_alt'] ?? null);

        return $this;
    }

    public function twitterTitle(string $title = null)
    {
        if ($title = $title ?? $this->title) {
            $this->tag('<meta name="twitter:title" content="%s" inertia>', e($title));
        }

        return $this;
    }

    public function twitterDescription(string $description = null)
    {
        if ($description = $description ?? $this->description) {
            $this->tag('<meta name="twitter:description" content="%s" inertia>', e($description));
        }

        return $this;
    }

    public function twitterImage(string $image = null, string $alt = null)
    {
        if ($image = $image ?? $this->image) {
            $this->tag('<meta name="twitter:image" content="%s" inertia>', e($image));
        }

        if ($alt) {
            $this->tag('<meta name="twitter:image:alt" content="%s" inertia>', e($alt));
        }

        return $this;
    }

    public function twitterSite(string $username = null, string $id = null)
    {
        if ($username = $username ?? config('inertia-ssr-head.twitter_site')) {
            $this->tag('<meta name="twitter:site" content="%s" inertia>', e($username));
        }

        if ($id = $id ?? config('inertia-ssr-head.twitter_site_id')) {
            $this->tag('<meta name="twitter:site:id" content="%s" inertia>', e($id));
        }

        return $this;
    }

    public function twitterCreator(string $username = null, string $id = null)
    {
        if ($username = $username ?? config('inertia-ssr-head.twitter_creator')) {
            $this->tag('<meta name="twitter:creator" content="%s" inertia>', e($username));
        }

        if ($id = $id ?? config('inertia-ssr-head.twitter_creator_id')) {
            $this->tag('<meta name="twitter:creator:id" content="%s" inertia>', e($id));
        }

        return $this;
    }

    public function twitterAppForIphone(array $app = [])
    {
        $appName = $app['name'] ?? config('inertia-ssr-head.twitter_app_name');
        $appId = $app['id'] ?? config('inertia-ssr-head.twitter_app_ios_id');
        $appUrl = $app['url'] ?? config('inertia-ssr-head.twitter_app_ios_url');

        $this->tag('<meta name="twitter:app:name:iphone" content="%s" inertia>', e($appName));
        $this->tag('<meta name="twitter:app:id:iphone" content="%s" inertia>', e($appId));
        $this->tag('<meta name="twitter:app:url:iphone" content="%s" inertia>', e($appUrl));

        return $this;
    }

    public function twitterAppForIpad(array $app = [])
    {
        $appName = $app['name'] ?? config('inertia-ssr-head.twitter_app_name');
        $appId = $app['id'] ?? config('inertia-ssr-head.twitter_app_ios_id');
        $appUrl = $app['url'] ?? config('inertia-ssr-head.twitter_app_ios_url');

        $this->tag('<meta name="twitter:app:name:ipad" content="%s" inertia>', e($appName));
        $this->tag('<meta name="twitter:app:id:ipad" content="%s" inertia>', e($appId));
        $this->tag('<meta name="twitter:app:url:ipad" content="%s" inertia>', e($appUrl));

        return $this;
    }

    public function twitterAppForGoogleplay(array $app = [])
    {
        $appName = $app['name'] ?? config('inertia-ssr-head.twitter_app_name');
        $appId = $app['id'] ?? config('inertia-ssr-head.twitter_app_googleplay_id');
        $appUrl = $app['url'] ?? config('inertia-ssr-head.twitter_app_googleplay_url');

        $this->tag('<meta name="twitter:app:name:googleplay" content="%s" inertia>', e($appName));
        $this->tag('<meta name="twitter:app:id:googleplay" content="%s" inertia>', e($appId));
        $this->tag('<meta name="twitter:app:url:googleplay" content="%s" inertia>', e($appUrl));

        return $this;
    }

    public function twitterAppCountry(string $country)
    {
        $this->tag('<meta name="twitter:app:country" content="%s" inertia>', e($country));

        return $this;
    }

    public function twitterPlayer(array $player)
    {
        $this->tag('<meta name="twitter:player" content="%s" inertia>', e($player['url']));

        foreach (['width', 'height', 'stream'] as $attr) {
            if (isset($player[$attr])) {
                $this->tag('<meta name="twitter:player:%s" content="%s" inertia>', $attr, e($player[$attr]));
            }
        }

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function setElements(array $elements)
    {
        $this->elements = $elements;

        return $this;
    }

    public function format(int $space = 4)
    {
        $this->space = $space;

        return $this;
    }

    protected function renderBreakLineAndSpace(): string
    {
        return ($this->space > 0 ? "\n" : '').str_repeat(' ', $this->space);
    }

    public function render(): string
    {
        return collect($this->elements)->implode($this->renderBreakLineAndSpace());
    }
}
