<?php

use Illuminate\Testing\TestResponse;
use Inertia\Response;
use Inertia\SSRHead\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function toTestResponse(Response $response): TestResponse
{
    return TestResponse::fromBaseResponse(
        $response->toResponse(request())
    );
}
