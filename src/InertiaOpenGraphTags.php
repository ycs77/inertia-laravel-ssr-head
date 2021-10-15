<?php

namespace Ycs77\InertiaSSRHead;

use Illuminate\Contracts\Support\Renderable;
use Stringable;

/**
 * @see https://developers.facebook.com/docs/sharing/webmasters
 * @see https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/summary-card-with-large-image
 */
class InertiaOpenGraphTags implements Renderable, Stringable
{
    /** @var array */
    protected $contents;

    /** @var array */
    protected $openGraph;

    /** @var int */
    protected $space;

    public function __construct(array $openGraph, int $space = 8)
    {
        $this->openGraph = $openGraph;
        $this->space = $space;
    }

    public function description()
    {
        if (array_key_exists('description', $this->openGraph)) {
            $this->contents[] = '<meta name="description" content="'.$this->openGraph['description'].'">';
        }

        return $this;
    }

    public function ogTitle()
    {
        if (array_key_exists('og:title', $this->openGraph)) {
            $this->contents[] = '<meta property="og:title" content="'.$this->openGraph['og:title'].'">';
        }

        return $this;
    }

    public function ogDescription()
    {
        if (array_key_exists('og:description', $this->openGraph)) {
            $this->contents[] = '<meta property="og:description" content="'.$this->openGraph['og:description'].'">';
        }

        return $this;
    }

    public function ogImage()
    {
        if (array_key_exists('og:image', $this->openGraph)) {
            $this->contents[] = '<meta property="og:image" content="'.$this->openGraph['og:image'].'">';
        }

        return $this;
    }

    public function twitterTitle()
    {
        if (array_key_exists('twitter:title', $this->openGraph)) {
            $this->contents[] = '<meta name="twitter:title" content="'.$this->openGraph['twitter:title'].'">';
        }

        return $this;
    }

    public function twitterDescription()
    {
        if (array_key_exists('twitter:description', $this->openGraph)) {
            $this->contents[] = '<meta name="twitter:description" content="'.$this->openGraph['twitter:description'].'">';
        }

        return $this;
    }

    public function twitterImage()
    {
        if (array_key_exists('twitter:image', $this->openGraph)) {
            $this->contents[] = '<meta name="twitter:image" content="'.$this->openGraph['twitter:image'].'">';
        }

        return $this;
    }

    public function render()
    {
        $this->description();
        $this->ogTitle();
        $this->ogDescription();
        $this->ogImage();
        $this->twitterTitle();
        $this->twitterDescription();
        $this->twitterImage();

        return implode(str_repeat(' ', $this->space)."\n", $this->contents);
    }

    public function __toString()
    {
        return $this->render();
    }
}
