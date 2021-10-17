<?php

use Inertia\Inertia;

test('can add <title> and description metadata with inertia response', function () {
    $response = Inertia::render('TestPage')
        ->title('Page title')
        ->description('Page description...');

    $response = toTestResponse($response);

    $response->assertViewHas('page');
    $page = $response->viewData('page');
    expect($page['props']['title'])->toBe('Page title');

    $response->assertViewHas('headManager');
    $headManager = $response->viewData('headManager');
    expect($headManager->getTitle())->toBe('Page title');
    expect($headManager->getDescription())->toBe('Page description...');

    $response->assertSee('<title inertia>Page title</title>', false);
    $response->assertSee('<meta name="description" content="Page description...">', false);
});

test('can add <title> and og metadata with inertia response', function () {
    $response = Inertia::render('TestPage')
        ->title('Page title')
        ->description('Page description...')
        ->image('https://example.com/image')
        ->ogMeta();

    $response = toTestResponse($response);

    $response->assertViewHas('page');
    $page = $response->viewData('page');
    expect($page['props']['title'])->toBe('Page title');

    $response->assertViewHas('headManager');
    $headManager = $response->viewData('headManager');
    expect($headManager->getTitle())->toBe('Page title');
    expect($headManager->getDescription())->toBe('Page description...');
    expect($headManager->getImage())->toBe('https://example.com/image');

    $response->assertSee('<title inertia>Page title</title>', false);
    $response->assertSee('<meta name="description" content="Page description...">', false);
    $response->assertSee('<meta property="og:title" content="Page title">', false);
    $response->assertSee('<meta property="og:description" content="Page description...">', false);
    $response->assertSee('<meta property="og:image" content="https://example.com/image">', false);
});
