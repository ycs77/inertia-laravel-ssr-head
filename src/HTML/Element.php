<?php

namespace Inertia\SSRHead\HTML;

class Element
{
    /** @var string */
    public $tag;

    /** @var array */
    public $props = [];

    /** @var string|array|\Inertia\SSRHead\HTML\Element */
    public $children = '';

    public function __construct(string $tag, array $props = [], $children = '')
    {
        $this->tag = $tag;
        $this->props = $props;
        $this->children = $children;
    }
}
