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

    $response->assertSeeInOrder([
        '<title>Page title</title>',
        '<meta name="description" content="Page description...">',
    ], false);
});

test('using Inertia::titleTemplate()', function () {
    Inertia::titleTemplate(fn (?string $title) => $title ? "$title - My App" : 'My App');

    $response = Inertia::render('TestPage');
    $response = toTestResponse($response);

    $response->assertViewHas('page');
    $page = $response->viewData('page');
    expect($page['props']['title'])->toBe('My App');

    $response->assertSee('<title>My App</title>', false);
});

test('can add <title> and open graph metadata with inertia response', function () {
    $response = Inertia::render('TestPage')
        ->title('Page title')
        ->description('Page description...')
        ->image('https://example.com/image')
        ->ogMeta();

    $response = toTestResponse($response);

    $headManager = $response->viewData('headManager');
    expect($headManager->getTitle())->toBe('Page title');
    expect($headManager->getDescription())->toBe('Page description...');
    expect($headManager->getImage())->toBe('https://example.com/image');

    $response->assertSeeInOrder([
        '<title>Page title</title>',
        '<meta name="description" content="Page description...">',
        '<meta property="og:title" content="Page title">',
        '<meta property="og:description" content="Page description...">',
        '<meta property="og:image" content="https://example.com/image">',
    ], false);
});

test('can add twitter summary card with inertia response', function () {
    config()->set(['inertia-ssr-head.twitter_site' => '@website_twitter_name']);

    $response = Inertia::render('TestPage')
        ->title('Page title')
        ->description('Page description...')
        ->image('https://example.com/image')
        ->twitterSummaryCard();

    $response = toTestResponse($response);

    $response->assertSeeInOrder([
        '<title>Page title</title>',
        '<meta name="description" content="Page description...">',
        '<meta name="twitter:card" content="summary">',
        '<meta name="twitter:title" content="Page title">',
        '<meta name="twitter:description" content="Page description...">',
        '<meta name="twitter:image" content="https://example.com/image">',
        '<meta name="twitter:site" content="@website_twitter_name">',
    ], false);
});

test('can add twitter summary large image card with inertia response', function () {
    config()->set([
        'inertia-ssr-head.twitter_site' => '@website_twitter_name',
        'inertia-ssr-head.twitter_creator' => '@creator_twitter_name',
    ]);

    $response = Inertia::render('TestPage')
        ->title('Page title')
        ->description('Page description...')
        ->image('https://example.com/image')
        ->twitterLargeCard();

    $response = toTestResponse($response);

    $response->assertSeeInOrder([
        '<title>Page title</title>',
        '<meta name="description" content="Page description...">',
        '<meta name="twitter:card" content="summary_large_image">',
        '<meta name="twitter:site" content="@website_twitter_name">',
        '<meta name="twitter:creator" content="@creator_twitter_name">',
        '<meta name="twitter:title" content="Page title">',
        '<meta name="twitter:description" content="Page description...">',
        '<meta name="twitter:image" content="https://example.com/image">',
    ], false);
});

test('can add twitter app card with inertia response', function () {
    config()->set(['inertia-ssr-head.twitter_site' => '@website_twitter_name']);

    $response = Inertia::render('TestPage')
        ->title('App title')
        ->description('App description...')
        ->twitterAppCard()
        ->twitterAppForIphone([
            'name' => 'Your APP',
            'id' => '123456789',
            'url' => 'https://example.com/iphone_app',
        ])
        ->twitterAppForIpad([
            'name' => 'Your APP',
            'id' => '123456789',
            'url' => 'https://example.com/ipad_app',
        ])
        ->twitterAppForGoogleplay([
            'name' => 'Your APP',
            'id' => '123456789',
            'url' => 'https://example.com/googleplay_app',
        ]);

    $response = toTestResponse($response);

    $response->assertSeeInOrder([
        '<title>App title</title>',
        '<meta name="description" content="App description...">',
        '<meta name="twitter:card" content="app">',
        '<meta name="twitter:site" content="@website_twitter_name">',
        '<meta name="twitter:description" content="App description...">',
        '<meta name="twitter:app:name:iphone" content="Your APP">',
        '<meta name="twitter:app:id:iphone" content="123456789">',
        '<meta name="twitter:app:url:iphone" content="https://example.com/iphone_app">',
        '<meta name="twitter:app:name:ipad" content="Your APP">',
        '<meta name="twitter:app:id:ipad" content="123456789">',
        '<meta name="twitter:app:url:ipad" content="https://example.com/ipad_app">',
        '<meta name="twitter:app:name:googleplay" content="Your APP">',
        '<meta name="twitter:app:id:googleplay" content="123456789">',
        '<meta name="twitter:app:url:googleplay" content="https://example.com/googleplay_app">',
    ], false);
});

test('can add twitter player card with inertia response', function () {
    config()->set(['inertia-ssr-head.twitter_site' => '@website_twitter_name']);

    $response = Inertia::render('TestPage')
        ->title('Video title')
        ->description('Video description...')
        ->image('https://example.com/video_thumbnail')
        ->twitterPlayerCard([
            'url' => 'https://example.com/video',
            'width' => 640,
            'height' => 360,
        ]);

    $response = toTestResponse($response);

    $response->assertSeeInOrder([
        '<title>Video title</title>',
        '<meta name="description" content="Video description...">',
        '<meta name="twitter:card" content="player">',
        '<meta name="twitter:site" content="@website_twitter_name">',
        '<meta name="twitter:title" content="Video title">',
        '<meta name="twitter:description" content="Video description...">',
        '<meta name="twitter:player" content="https://example.com/video">',
        '<meta name="twitter:player:width" content="640">',
        '<meta name="twitter:player:height" content="360">',
        '<meta name="twitter:image" content="https://example.com/video_thumbnail">',
    ], false);
});
