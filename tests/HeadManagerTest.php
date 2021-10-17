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
    expect($elements[5])->toBe('<meta property="twitter:title" content="Page title" inertia>');
    expect($elements[6])->toBe('<meta property="twitter:description" content="Page description..." inertia>');
    expect($elements[7])->toBe('<meta property="twitter:image" content="https://example.com/image" inertia>');
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
        <meta property="twitter:title" content="Page title" inertia>
        <meta property="twitter:description" content="Page description..." inertia>
        <meta property="twitter:image" content="https://example.com/image" inertia>
HTML);
});
