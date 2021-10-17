<?php

use Illuminate\Testing\TestResponse;
use Inertia\Response;
use Inertia\SSRHead\HTML\Element;
use Inertia\SSRHead\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->in(__DIR__);

function toTestResponse(Response $response)
{
    return TestResponse::fromBaseResponse(
        $response->toResponse(request())
    );
}
