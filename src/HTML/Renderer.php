<?php

namespace Inertia\SSRHead\HTML;

use InvalidArgumentException;

class Renderer
{
    protected $elements;

    protected $space = 0;

    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    public function setElements(array $elements)
    {
        $this->elements = $elements;

        return $this;
    }

    protected function isUnaryTag(Element $element): bool
    {
        return array_search($element->tag, [
            'area', 'base', 'br', 'col', 'embed', 'hr', 'img',
            'input', 'keygen', 'link', 'meta', 'param', 'source',
            'track', 'wbr',
        ]) !== false;
    }

    protected function renderTagStart(Element $element): string
    {
        $attrs = array_reduce(array_keys($element->props), function ($carry, $key) use ($element) {
            $value = $element->props[$key];

            if (is_numeric($key)) {
                return $carry.' '.$value;
            }

            return $carry.' '.$key.'="'.e($value).'"';
        }, '');

        return '<'.$element->tag.$attrs.'>';
    }

    protected function renderTagChildren($children): string
    {
        if (is_string($children)) {
            return e($children);
        } elseif (is_array($children)) {
            return array_reduce($children, function ($html, $child) {
                return $html.$this->renderTagChildren($child);
            }, '');
        } elseif ($children instanceof Element) {
            return $this->renderTag($children);
        }

        throw new InvalidArgumentException(
            '$children must be type of String or Array or \Inertia\SSRHead\HTML\Element.'
        );
    }

    protected function renderTagEnd(Element $element): string
    {
        return $this->isUnaryTag($element) ? '' : ('</'.$element->tag.'>');
    }

    protected function renderTag(Element $element): string
    {
        $html = $this->renderTagStart($element);

        if (! empty($element->children)) {
            $html .= $this->renderTagChildren($element->children);
        }

        $html .= $this->renderTagEnd($element);

        return $html;
    }

    protected function renderBreakLineAndSpace(): string
    {
        return ($this->space > 0 ? "\n" : '').str_repeat(' ', $this->space);
    }

    public function format(int $space = 4)
    {
        $this->space = $space;

        return $this;
    }

    public function render(): string
    {
        return collect($this->elements)
            ->map(function (Element $element) {
                return $this->renderTag($element);
            })
            ->implode($this->renderBreakLineAndSpace());
    }
}
