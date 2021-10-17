<?php

use Illuminate\Testing\TestResponse;
use Inertia\Response;
use Inertia\SSRHead\HTML\Element;
use Inertia\SSRHead\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->in(__DIR__);

/**
 * Custom Test Helpers.
 */
function expectsElement(Element $element)
{
    return new class($element)
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
    };
}

function toTestResponse(Response $response)
{
    return TestResponse::fromBaseResponse(
        $response->toResponse(request())
    );
}
