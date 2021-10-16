<?php

namespace Inertia\SSRHead\HTML;

use InvalidArgumentException;

class Renderer
{
    protected $elements;

    protected $space = 0;

    public function __construct(array $elements)
    {
        $this->elements = $elements;
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

    protected function renderTagChildren(Element $element): string
    {
        if (is_string($element->children)) {
            return e($element->children);
        } elseif (is_array($element->children)) {
            return array_reduce($element->children, function ($html, $child) {
                if (is_string($child)) {
                    return $html.e($child);
                } elseif ($child instanceof Element) {
                    return $html.$this->renderTag($child);
                }
                throw new InvalidArgumentException(
                    '$element->children\'s child must be type of String or \Inertia\SSRHead\HTML\Element.'
                );
            }, '');
        } elseif ($element->children instanceof Element) {
            return $this->renderTag($element->children);
        }

        throw new InvalidArgumentException(
            '$element->children must be type of String or Array or \Inertia\SSRHead\HTML\Element.'
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
            $html .= $this->renderTagChildren($element);
        }

        $html .= $this->renderTagEnd($element);

        return $html;
    }

    protected function renderBreakLineAndSpace(): string
    {
        return ($this->space > 0 ? "\n" : '').str_repeat(' ', $this->space);
    }

    public function render(): string
    {
        return collect($this->elements)
            ->map(function (Element $element) {
                return $this->renderTag($element);
            })
            ->implode($this->renderBreakLineAndSpace());
    }

    public function format(int $space = 4)
    {
        $this->space = $space;

        return $this;
    }
}
