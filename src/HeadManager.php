<?php

namespace Inertia\SSRHead;

use Inertia\SSRHead\HTML\Element;

class HeadManager
{
    protected $elements;

    protected $title;
    protected $description;
    protected $image;

    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    public function addTag(string $tag, array $props = [], $children = '')
    {
        $this->elements[] = new Element($tag, $props, $children);

        return $this;
    }

    public function title(string $title)
    {
        $this->title = $title;
        $this->addTag('title', ['inertia'], $title);

        return $this;
    }

    public function description(string $description)
    {
        $this->description = $description;
        $this->addTag('meta', [
            'name' => 'description',
            'content' => $description,
        ]);

        return $this;
    }

    public function image(string $image)
    {
        $this->image = $image;

        return $this;
    }

    public function ogTitle(string $ogTitle = null)
    {
        if ($ogTitle = $ogTitle ?? $this->title) {
            $this->addTag('meta', [
                'property' => 'og:title',
                'content' => $ogTitle,
            ]);
        }

        return $this;
    }

    public function ogDescription(string $ogDescription = null)
    {
        if ($ogDescription = $ogDescription ?? $this->description) {
            $this->addTag('meta', [
                'property' => 'og:description',
                'content' => $ogDescription,
            ]);
        }

        return $this;
    }

    public function ogImage(string $ogImage = null)
    {
        if ($ogImage = $ogImage ?? $this->image) {
            $this->addTag('meta', [
                'property' => 'og:image',
                'content' => $ogImage,
            ]);
        }

        return $this;
    }

    public function twitterTitle(string $twitterTitle = null)
    {
        if ($twitterTitle = $twitterTitle ?? $this->title) {
            $this->addTag('meta', [
                'name' => 'twitter:title',
                'content' => $twitterTitle,
            ]);
        }

        return $this;
    }

    public function twitterDescription(string $twitterDescription = null)
    {
        if ($twitterDescription = $twitterDescription ?? $this->description) {
            $this->addTag('meta', [
                'name' => 'twitter:description',
                'content' => $twitterDescription,
            ]);
        }

        return $this;
    }

    public function twitterImage(string $twitterImage = null)
    {
        if ($twitterImage = $twitterImage ?? $this->image) {
            $this->addTag('meta', [
                'name' => 'twitter:image',
                'content' => $twitterImage,
            ]);
        }

        return $this;
    }

    public function getElements()
    {
        return $this->elements;
    }
}
