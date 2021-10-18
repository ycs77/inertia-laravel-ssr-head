<?php

use Inertia\SSRHead\HeadManager;

test('can add tag', function () {
    $head = new HeadManager();

    $head->tag('<title inertia>Page title</title>');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expect($elements[0])->toBe('<title inertia>Page title</title>');
});

test('can add title tag', function () {
    $head = new HeadManager();

    $head->title('Page title');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expect($elements[0])->toBe('<title inertia>Page title</title>');
});

test('can add description and image tag', function () {
    $head = new HeadManager();

    $head
        ->description('Page description...')
        ->image('https://example.com/image');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expect($elements[0])->toBe('<meta name="description" content="Page description..." inertia>');
});

test('can add title and og:title', function () {
    $head = new HeadManager();

    $head
        ->title('Page title')
        ->ogTitle();

    $elements = $head->getElements();

    expect($elements)->toHaveCount(2);
    expect($elements[0])->toBe('<title inertia>Page title</title>');
    expect($elements[1])->toBe('<meta property="og:title" content="Page title" inertia>');
});

test('can add title and custom og:title', function () {
    $head = new HeadManager();

    $head
        ->title('Page title')
        ->ogTitle('Custom og title');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(2);
    expect($elements[0])->toBe('<title inertia>Page title</title>');
    expect($elements[1])->toBe('<meta property="og:title" content="Custom og title" inertia>');
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

    expect($elements)->toHaveCount(8);
    expect($elements[0])->toBe('<title inertia>Page title</title>');
    expect($elements[1])->toBe('<meta name="description" content="Page description..." inertia>');
    expect($elements[2])->toBe('<meta property="og:title" content="Page title" inertia>');
    expect($elements[3])->toBe('<meta property="og:description" content="Page description..." inertia>');
    expect($elements[4])->toBe('<meta property="og:image" content="https://example.com/image" inertia>');
    expect($elements[5])->toBe('<meta name="twitter:title" content="Page title" inertia>');
    expect($elements[6])->toBe('<meta name="twitter:description" content="Page description..." inertia>');
    expect($elements[7])->toBe('<meta name="twitter:image" content="https://example.com/image" inertia>');
});

test('can render mitiple tags with oneline', function () {
    $head = new HeadManager();

    $head
        ->title('Page title')
        ->description('Page description...');

    $html = $head->render();

    expect($html)->toBe('<title inertia>Page title</title><meta name="description" content="Page description..." inertia>');
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
<title inertia>Page title</title>
        <meta name="description" content="Page description..." inertia>
        <meta property="og:title" content="Page title" inertia>
        <meta property="og:description" content="Page description..." inertia>
        <meta property="og:image" content="https://example.com/image" inertia>
        <meta name="twitter:title" content="Page title" inertia>
        <meta name="twitter:description" content="Page description..." inertia>
        <meta name="twitter:image" content="https://example.com/image" inertia>
HTML);
});

test('can render og:url tag', function () {
    $head = new HeadManager();

    $head->ogUrl();

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expect($elements[0])->toBe('<meta property="og:url" content="http://localhost" inertia>');
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

    expect($elements)->toHaveCount(5);
    expect($elements[0])->toBe('<meta property="og:image:url" content="https://example.com/image" inertia>');
    expect($elements[1])->toBe('<meta property="og:image:secure_url" content="https://example.com/image" inertia>');
    expect($elements[2])->toBe('<meta property="og:image:type" content="image/jpeg" inertia>');
    expect($elements[3])->toBe('<meta property="og:image:width" content="640" inertia>');
    expect($elements[4])->toBe('<meta property="og:image:height" content="360" inertia>');
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

    expect($elements)->toHaveCount(6);
    expect($elements[0])->toBe('<meta property="og:video:url" content="https://example.com/video" inertia>');
    expect($elements[1])->toBe('<meta property="og:video:secure_url" content="https://example.com/video" inertia>');
    expect($elements[2])->toBe('<meta property="og:video:type" content="video/mp4" inertia>');
    expect($elements[3])->toBe('<meta property="og:video:width" content="640" inertia>');
    expect($elements[4])->toBe('<meta property="og:video:height" content="360" inertia>');
    expect($elements[5])->toBe('<meta property="og:image" content="https://example.com/image" inertia>');
});

test('can render og:type tag', function () {
    $head = new HeadManager();

    $head->ogType('article');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expect($elements[0])->toBe('<meta property="og:type" content="article" inertia>');
});

test('can render og:locale tag', function () {
    $head = new HeadManager();

    $head->ogLocale('zh_TW');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expect($elements[0])->toBe('<meta property="og:locale" content="zh_TW" inertia>');
});

test('can render fb:app_id tag', function () {
    $head = new HeadManager();

    $head->fbAppID('123456789');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expect($elements[0])->toBe('<meta property="fb:app_id" content="123456789" inertia>');
});

test('can render twitter card tag', function () {
    $head = new HeadManager();

    $head->twitterCard('summary');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expect($elements[0])->toBe('<meta name="twitter:card" content="summary" inertia>');
});

test('can render twitter site tags', function () {
    $head = new HeadManager();

    $head->twitterSite('@website_twitter_name', '123456789');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(2);
    expect($elements[0])->toBe('<meta name="twitter:site" content="@website_twitter_name" inertia>');
    expect($elements[1])->toBe('<meta name="twitter:site:id" content="123456789" inertia>');
});

test('can render twitter creator tags', function () {
    $head = new HeadManager();

    $head->twitterCreator('@your_twitter_name', '123456789');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(2);
    expect($elements[0])->toBe('<meta name="twitter:creator" content="@your_twitter_name" inertia>');
    expect($elements[1])->toBe('<meta name="twitter:creator:id" content="123456789" inertia>');
});

test('can render twitter player iframe tags', function () {
    $head = new HeadManager();

    $head->twitterPlayer([
        'url' => 'https://example.com/player',
        'width' => 640,
        'height' => 360,
    ]);

    $elements = $head->getElements();

    expect($elements)->toHaveCount(3);
    expect($elements[0])->toBe('<meta name="twitter:player" content="https://example.com/player" inertia>');
    expect($elements[1])->toBe('<meta name="twitter:player:width" content="640" inertia>');
    expect($elements[2])->toBe('<meta name="twitter:player:height" content="360" inertia>');
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

    expect($elements)->toHaveCount(9);
    expect($elements[0])->toBe('<meta name="twitter:app:name:iphone" content="Your APP" inertia>');
    expect($elements[1])->toBe('<meta name="twitter:app:id:iphone" content="123456789" inertia>');
    expect($elements[2])->toBe('<meta name="twitter:app:url:iphone" content="https://example.com/iphone_app" inertia>');
    expect($elements[3])->toBe('<meta name="twitter:app:name:ipad" content="Your APP" inertia>');
    expect($elements[4])->toBe('<meta name="twitter:app:id:ipad" content="123456789" inertia>');
    expect($elements[5])->toBe('<meta name="twitter:app:url:ipad" content="https://example.com/ipad_app" inertia>');
    expect($elements[6])->toBe('<meta name="twitter:app:name:googleplay" content="Your APP" inertia>');
    expect($elements[7])->toBe('<meta name="twitter:app:id:googleplay" content="123456789" inertia>');
    expect($elements[8])->toBe('<meta name="twitter:app:url:googleplay" content="https://example.com/googleplay_app" inertia>');
});

test('can render twitter summary card', function () {
    $head = new HeadManager();

    $head
        ->title('Page title')
        ->description('Page description...')
        ->image('https://example.com/image')
        ->twitterSummaryCard()
        ->twitterTitle()
        ->twitterDescription()
        ->twitterImage()
        ->twitterSite('@website_twitter_name');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(7);
    expect($elements[0])->toBe('<title inertia>Page title</title>');
    expect($elements[1])->toBe('<meta name="description" content="Page description..." inertia>');
    expect($elements[2])->toBe('<meta name="twitter:card" content="summary" inertia>');
    expect($elements[3])->toBe('<meta name="twitter:title" content="Page title" inertia>');
    expect($elements[4])->toBe('<meta name="twitter:description" content="Page description..." inertia>');
    expect($elements[5])->toBe('<meta name="twitter:image" content="https://example.com/image" inertia>');
    expect($elements[6])->toBe('<meta name="twitter:site" content="@website_twitter_name" inertia>');
});

test('can render twitter summary large image card', function () {
    $head = new HeadManager();

    $head
        ->title('Page title')
        ->description('Page description...')
        ->image('https://example.com/image')
        ->twitterLargeCard()
        ->twitterSite('@website_twitter_name')
        ->twitterCreator('@creator_twitter_name')
        ->twitterTitle()
        ->twitterDescription()
        ->twitterImage();

    $elements = $head->getElements();

    expect($elements)->toHaveCount(8);
    expect($elements[0])->toBe('<title inertia>Page title</title>');
    expect($elements[1])->toBe('<meta name="description" content="Page description..." inertia>');
    expect($elements[2])->toBe('<meta name="twitter:card" content="summary_large_image" inertia>');
    expect($elements[3])->toBe('<meta name="twitter:site" content="@website_twitter_name" inertia>');
    expect($elements[4])->toBe('<meta name="twitter:creator" content="@creator_twitter_name" inertia>');
    expect($elements[5])->toBe('<meta name="twitter:title" content="Page title" inertia>');
    expect($elements[6])->toBe('<meta name="twitter:description" content="Page description..." inertia>');
    expect($elements[7])->toBe('<meta name="twitter:image" content="https://example.com/image" inertia>');
});

test('can render twitter player card', function () {
    $head = new HeadManager();

    $head
        ->title('App title')
        ->description('App description...')
        ->twitterAppCard()
        ->twitterSite('@website_twitter_name')
        ->twitterDescription()
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

    expect($elements)->toHaveCount(15);
    expect($elements[0])->toBe('<title inertia>App title</title>');
    expect($elements[1])->toBe('<meta name="description" content="App description..." inertia>');
    expect($elements[2])->toBe('<meta name="twitter:card" content="app" inertia>');
    expect($elements[3])->toBe('<meta name="twitter:site" content="@website_twitter_name" inertia>');
    expect($elements[4])->toBe('<meta name="twitter:description" content="App description..." inertia>');
    expect($elements[5])->toBe('<meta name="twitter:app:country" content="TW" inertia>');
    expect($elements[6])->toBe('<meta name="twitter:app:name:iphone" content="Your APP" inertia>');
    expect($elements[7])->toBe('<meta name="twitter:app:id:iphone" content="123456789" inertia>');
    expect($elements[8])->toBe('<meta name="twitter:app:url:iphone" content="https://example.com/iphone_app" inertia>');
    expect($elements[9])->toBe('<meta name="twitter:app:name:ipad" content="Your APP" inertia>');
    expect($elements[10])->toBe('<meta name="twitter:app:id:ipad" content="123456789" inertia>');
    expect($elements[11])->toBe('<meta name="twitter:app:url:ipad" content="https://example.com/ipad_app" inertia>');
    expect($elements[12])->toBe('<meta name="twitter:app:name:googleplay" content="Your APP" inertia>');
    expect($elements[13])->toBe('<meta name="twitter:app:id:googleplay" content="123456789" inertia>');
    expect($elements[14])->toBe('<meta name="twitter:app:url:googleplay" content="https://example.com/googleplay_app" inertia>');
});
