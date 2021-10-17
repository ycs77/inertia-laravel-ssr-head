<?php

namespace Inertia\SSRHead;

class HeadManager
{
    protected $elements = [];

    protected $title;
    protected $description;
    protected $image;

    protected $space = 0;

    public function tag(string $element)
    {
        $this->elements[] = $element;

        return $this;
    }

    public function title(string $title)
    {
        $this->title = $title;
        $this->tag("<title inertia>$title</title>");

        return $this;
    }

    public function description(string $description)
    {
        $this->description = $description;
        $this->tag("<meta name=\"description\" content=\"$description\" inertia>");

        return $this;
    }

    public function image(string $image)
    {
        $this->image = $image;

        return $this;
    }

    public function ogTitle(string $title = null)
    {
        if ($title = $title ?? $this->title) {
            $this->tag("<meta property=\"og:title\" content=\"$title\" inertia>");
        }

        return $this;
    }

    public function ogDescription(string $description = null)
    {
        if ($description = $description ?? $this->description) {
            $this->tag("<meta property=\"og:description\" content=\"$description\" inertia>");
        }

        return $this;
    }

    public function ogImage(string $image = null)
    {
        if ($image = $image ?? $this->image) {
            $this->tag("<meta property=\"og:image\" content=\"$image\" inertia>");
        }

        return $this;
    }

    public function twitterTitle(string $title = null)
    {
        if ($title = $title ?? $this->title) {
            $this->tag("<meta property=\"twitter:title\" content=\"$title\" inertia>");
        }

        return $this;
    }

    public function twitterDescription(string $description = null)
    {
        if ($description = $description ?? $this->description) {
            $this->tag("<meta property=\"twitter:description\" content=\"$description\" inertia>");
        }

        return $this;
    }

    public function twitterImage(string $image = null)
    {
        if ($image = $image ?? $this->image) {
            $this->tag("<meta property=\"twitter:image\" content=\"$image\" inertia>");
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
