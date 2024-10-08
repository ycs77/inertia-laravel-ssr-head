<?php

use Inertia\SSRHead\HeadManager;

test('can add tag', function () {
    $head = new HeadManager();

    $head->tag('<title>%s</title>', e('Page title'));

    $elements = $head->getElements();

    expect($elements)->toBe(['<title>Page title</title>']);
});

test('can add title tag', function () {
    $head = new HeadManager();

    $head->title('Page title');

    $elements = $head->getElements();

    expect($elements)->toBe(['<title>Page title</title>']);
});

test('escape special characters', function () {
    $head = new HeadManager();

    $head->title('<>\'"');

    $elements = $head->getElements();

    expect($elements)->toBe(['<title>&lt;&gt;&#039;&quot;</title>']);
});

test('can use title template with method', function () {
    $head = new HeadManager();

    $head
        ->titleTemplate('%s - My website')
        ->title('Page title');

    $elements = $head->getElements();

    expect($elements)->toBe(['<title>Page title - My website</title>']);
});

test('can use title template with attribute', function () {
    $head = new HeadManager();

    $head->title('Page title', '%s - My website');

    $elements = $head->getElements();

    expect($elements)->toBe(['<title>Page title - My website</title>']);
});

test('can use title template with closure', function () {
    $head = new HeadManager();

    $head->titleTemplate(fn (?string $title) => $title ? "$title - My website" : 'My website');

    $elements = $head->getElements();

    expect($elements)->toBe(['<title>My website</title>']);

    $head->title('Page title');

    $elements = $head->getElements();

    expect($elements)->toBe(['<title>Page title - My website</title>']);
});

test('without title template', function () {
    $head = new HeadManager();

    $head
        ->titleTemplate('%s - My website')
        ->title('Page title', false);

    $elements = $head->getElements();

    expect($elements)->toBe(['<title>Page title</title>']);
});

test('can add description and image tag', function () {
    $head = new HeadManager();

    $head
        ->description('Page description...')
        ->image('https://example.com/image');

    $elements = $head->getElements();

    expect($elements)->toBe(['<meta name="description" content="Page description...">']);
});

test('unique meta tag', function () {
    $head = new HeadManager();

    $head
        ->description('First description...')
        ->description('Second description...');

    $elements = $head->getElements();

    expect($elements)->toBe(['<meta name="description" content="Second description...">']);
});

test('can add title and og:title', function () {
    $head = new HeadManager();

    $head
        ->title('Page title')
        ->ogTitle();

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<title>Page title</title>',
        '<meta property="og:title" content="Page title">',
    ]);
});

test('can add og:title with full title', function () {
    $head = new HeadManager();

    $head
        ->titleTemplate('%s - My website')
        ->title('Page title')
        ->ogTitle();

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<title>Page title - My website</title>',
        '<meta property="og:title" content="Page title - My website">',
    ]);
});

test('can add title and custom og:title', function () {
    $head = new HeadManager();

    $head
        ->title('Page title')
        ->ogTitle('Custom og title');

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<title>Page title</title>',
        '<meta property="og:title" content="Custom og title">',
    ]);
});

test('can add all base Open Graph tags', function () {
    $head = new HeadManager();

    $head
        ->title('Page title')
        ->description('Page description...')
        ->image('https://example.com/image')
        ->ogTitle()
        ->ogDescription()
        ->ogImage()
        ->twitterTitle()
        ->twitterDescription()
        ->twitterImage();

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<title>Page title</title>',
        '<meta name="description" content="Page description...">',
        '<meta property="og:title" content="Page title">',
        '<meta property="og:description" content="Page description...">',
        '<meta property="og:image" content="https://example.com/image">',
        '<meta name="twitter:title" content="Page title">',
        '<meta name="twitter:description" content="Page description...">',
        '<meta name="twitter:image" content="https://example.com/image">',
    ]);
});

test('can render mitiple tags with oneline', function () {
    $head = new HeadManager();

    $head
        ->title('Page title')
        ->description('Page description...');

    $html = $head->render();

    expect($html)->toBe('<title>Page title</title><meta name="description" content="Page description...">');
});

test('can render mitiple tags with break line', function () {
    $head = new HeadManager();

    $head
        ->title('Page title')
        ->description('Page description...')
        ->image('https://example.com/image')
        ->ogTitle()
        ->ogDescription()
        ->ogImage()
        ->twitterTitle()
        ->twitterDescription()
        ->twitterImage();

    $html = $head->format(8)->render();

    expect($html)->toBe(<<<'HTML'
<title>Page title</title>
        <meta name="description" content="Page description...">
        <meta property="og:title" content="Page title">
        <meta property="og:description" content="Page description...">
        <meta property="og:image" content="https://example.com/image">
        <meta name="twitter:title" content="Page title">
        <meta name="twitter:description" content="Page description...">
        <meta name="twitter:image" content="https://example.com/image">
HTML);
});

test('can render og:url tag', function () {
    $head = new HeadManager();

    $head->ogUrl();

    $elements = $head->getElements();

    expect($elements)->toBe(['<meta property="og:url" content="http://localhost">']);
});

test('can render mitiple og:image tags', function () {
    $head = new HeadManager();

    $head->ogImage([
        'url' => 'https://example.com/image',
        'secure_url' => 'https://example.com/image',
        'type' => 'image/jpeg',
        'width' => 640,
        'height' => 360,
    ]);

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<meta property="og:image:url" content="https://example.com/image">',
        '<meta property="og:image:secure_url" content="https://example.com/image">',
        '<meta property="og:image:type" content="image/jpeg">',
        '<meta property="og:image:width" content="640">',
        '<meta property="og:image:height" content="360">',
    ]);
});

test('can render mitiple og:video tags', function () {
    $head = new HeadManager();

    $head->ogVideo([
        'url' => 'https://example.com/video',
        'secure_url' => 'https://example.com/video',
        'type' => 'video/mp4',
        'width' => 640,
        'height' => 360,
        'image' => 'https://example.com/image',
    ]);

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<meta property="og:video:url" content="https://example.com/video">',
        '<meta property="og:video:secure_url" content="https://example.com/video">',
        '<meta property="og:video:type" content="video/mp4">',
        '<meta property="og:video:width" content="640">',
        '<meta property="og:video:height" content="360">',
        '<meta property="og:image" content="https://example.com/image">',
    ]);
});

test('can render og:type tag', function () {
    $head = new HeadManager();

    $head->ogType('article');

    $elements = $head->getElements();

    expect($elements)->toBe(['<meta property="og:type" content="article">']);
});

test('can render og:locale tag', function () {
    $head = new HeadManager();

    $head->ogLocale('zh_TW');

    $elements = $head->getElements();

    expect($elements)->toBe(['<meta property="og:locale" content="zh_TW">']);
});

test('can render fb:app_id tag', function () {
    $head = new HeadManager();

    $head->fbAppID('123456789');

    $elements = $head->getElements();

    expect($elements)->toBe(['<meta property="fb:app_id" content="123456789">']);
});

test('can render twitter card tag', function () {
    $head = new HeadManager();

    $head->twitterCard('summary');

    $elements = $head->getElements();

    expect($elements)->toBe(['<meta name="twitter:card" content="summary">']);
});

test('can render twitter site tags', function () {
    $head = new HeadManager();

    $head->twitterSite('@website_twitter_name', '123456789');

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<meta name="twitter:site" content="@website_twitter_name">',
        '<meta name="twitter:site:id" content="123456789">',
    ]);
});

test('can render twitter creator tags', function () {
    $head = new HeadManager();

    $head->twitterCreator('@your_twitter_name', '123456789');

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<meta name="twitter:creator" content="@your_twitter_name">',
        '<meta name="twitter:creator:id" content="123456789">',
    ]);
});

test('can render twitter player iframe tags', function () {
    $head = new HeadManager();

    $head->twitterPlayer([
        'url' => 'https://example.com/video',
        'width' => 640,
        'height' => 360,
    ]);

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<meta name="twitter:player" content="https://example.com/video">',
        '<meta name="twitter:player:width" content="640">',
        '<meta name="twitter:player:height" content="360">',
    ]);
});

test('can render twitter app tags', function () {
    $head = new HeadManager();

    $head->twitterAppForIphone([
        'name' => 'Your APP',
        'id' => '123456789',
        'url' => 'https://example.com/iphone_app',
    ]);
    $head->twitterAppForIpad([
        'name' => 'Your APP',
        'id' => '123456789',
        'url' => 'https://example.com/ipad_app',
    ]);
    $head->twitterAppForGoogleplay([
        'name' => 'Your APP',
        'id' => '123456789',
        'url' => 'https://example.com/googleplay_app',
    ]);

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<meta name="twitter:app:name:iphone" content="Your APP">',
        '<meta name="twitter:app:id:iphone" content="123456789">',
        '<meta name="twitter:app:url:iphone" content="https://example.com/iphone_app">',
        '<meta name="twitter:app:name:ipad" content="Your APP">',
        '<meta name="twitter:app:id:ipad" content="123456789">',
        '<meta name="twitter:app:url:ipad" content="https://example.com/ipad_app">',
        '<meta name="twitter:app:name:googleplay" content="Your APP">',
        '<meta name="twitter:app:id:googleplay" content="123456789">',
        '<meta name="twitter:app:url:googleplay" content="https://example.com/googleplay_app">',
    ]);
});

test('can render twitter summary card with params data', function () {
    $head = new HeadManager();

    $head->twitterSummaryCard([
        'title' => 'Page title',
        'description' => 'Page description...',
        'image' => 'https://example.com/image',
        'site' => '@website_twitter_name',
    ]);

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<meta name="twitter:card" content="summary">',
        '<meta name="twitter:title" content="Page title">',
        '<meta name="twitter:description" content="Page description...">',
        '<meta name="twitter:image" content="https://example.com/image">',
        '<meta name="twitter:site" content="@website_twitter_name">',
    ]);
});

test('can render twitter summary card with config data', function () {
    config()->set(['inertia-ssr-head.twitter_site' => '@website_twitter_name']);

    $head = new HeadManager();

    $head
        ->title('Page title')
        ->description('Page description...')
        ->image('https://example.com/image')
        ->twitterSummaryCard();

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<title>Page title</title>',
        '<meta name="description" content="Page description...">',
        '<meta name="twitter:card" content="summary">',
        '<meta name="twitter:title" content="Page title">',
        '<meta name="twitter:description" content="Page description...">',
        '<meta name="twitter:image" content="https://example.com/image">',
        '<meta name="twitter:site" content="@website_twitter_name">',
    ]);
});

test('can render twitter summary large image card', function () {
    $head = new HeadManager();

    $head->twitterLargeCard([
        'site' => '@website_twitter_name',
        'creator' => '@creator_twitter_name',
        'title' => 'Page title',
        'description' => 'Page description...',
        'image' => 'https://example.com/image',
    ]);

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<meta name="twitter:card" content="summary_large_image">',
        '<meta name="twitter:site" content="@website_twitter_name">',
        '<meta name="twitter:creator" content="@creator_twitter_name">',
        '<meta name="twitter:title" content="Page title">',
        '<meta name="twitter:description" content="Page description...">',
        '<meta name="twitter:image" content="https://example.com/image">',
    ]);
});

test('can render twitter app card', function () {
    $head = new HeadManager();

    $head
        ->twitterAppCard([
            'site' => '@website_twitter_name',
            'description' => 'App description...',
        ])
        ->twitterAppCountry('TW')
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

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<meta name="twitter:card" content="app">',
        '<meta name="twitter:site" content="@website_twitter_name">',
        '<meta name="twitter:description" content="App description...">',
        '<meta name="twitter:app:country" content="TW">',
        '<meta name="twitter:app:name:iphone" content="Your APP">',
        '<meta name="twitter:app:id:iphone" content="123456789">',
        '<meta name="twitter:app:url:iphone" content="https://example.com/iphone_app">',
        '<meta name="twitter:app:name:ipad" content="Your APP">',
        '<meta name="twitter:app:id:ipad" content="123456789">',
        '<meta name="twitter:app:url:ipad" content="https://example.com/ipad_app">',
        '<meta name="twitter:app:name:googleplay" content="Your APP">',
        '<meta name="twitter:app:id:googleplay" content="123456789">',
        '<meta name="twitter:app:url:googleplay" content="https://example.com/googleplay_app">',
    ]);
});

test('can render twitter player card', function () {
    config()->set(['inertia-ssr-head.twitter_site' => '@website_twitter_name']);

    $head = new HeadManager();

    $head->twitterPlayerCard([
        'title' => 'Video title',
        'site' => '@website_twitter_name',
        'description' => 'Video description...',
        'url' => 'https://example.com/video',
        'width' => 640,
        'height' => 360,
        'image' => 'https://example.com/video_thumbnail',
    ]);

    $elements = $head->getElements();

    expect($elements)->toBe([
        '<meta name="twitter:card" content="player">',
        '<meta name="twitter:site" content="@website_twitter_name">',
        '<meta name="twitter:title" content="Video title">',
        '<meta name="twitter:description" content="Video description...">',
        '<meta name="twitter:player" content="https://example.com/video">',
        '<meta name="twitter:player:width" content="640">',
        '<meta name="twitter:player:height" content="360">',
        '<meta name="twitter:image" content="https://example.com/video_thumbnail">',
    ]);
});
