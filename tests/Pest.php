<?php

use Inertia\SSRHead\HTML\Element;
use Inertia\SSRHead\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->in(__DIR__);

function expectElement(Element $element) {
    return new ElementExpectation($element);
}

class ElementExpectation
{
    protected $element;

    public function __construct($element)
    {
        $this->element = $element;
    }

    public function toBe($expectedTag, $expectedProps, $expectedChildren): void
    {
        Assert::assertSame($this->element->tag, $expectedTag);
        Assert::assertSame($this->element->props, $expectedProps);
        Assert::assertSame($this->element->children, $expectedChildren);
    }
}
