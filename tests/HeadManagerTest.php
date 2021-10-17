<?php

use Inertia\SSRHead\HeadManager;
use Inertia\SSRHead\HTML\Renderer;

test('can add tag', function () {
    $head = new HeadManager(new Renderer);

    $head->addTag('title', ['inertia'], 'Page title');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expectsElement($elements[0])->toBe('title', ['inertia'], 'Page title');
});

test('can add title tag', function () {
    $head = new HeadManager(new Renderer);

    $head->title('Page title');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expectsElement($elements[0])->toBe('title', ['inertia'], 'Page title');
});

test('can add description and image tag', function () {
    $head = new HeadManager(new Renderer);

    $head
        ->description('Page description...')
        ->image('https://example.com/image');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(1);
    expectsElement($elements[0])->toBe('meta', [
        'name' => 'description',
        'content' => 'Page description...',
        'inertia',
    ], '');
});

test('can add title and og:title', function () {
    $head = new HeadManager(new Renderer);

    $head
        ->title('Page title')
        ->ogTitle();

    $elements = $head->getElements();

    expect($elements)->toHaveCount(2);
    expectsElement($elements[0])->toBe('title', ['inertia'], 'Page title');
    expectsElement($elements[1])->toBe('meta', [
        'property' => 'og:title',
        'content' => 'Page title',
        'inertia',
    ], '');
});

test('can add title and custom og:title', function () {
    $head = new HeadManager(new Renderer);

    $head
        ->title('Page title')
        ->ogTitle('Custom og title');

    $elements = $head->getElements();

    expect($elements)->toHaveCount(2);
    expectsElement($elements[0])->toBe('title', ['inertia'], 'Page title');
    expectsElement($elements[1])->toBe('meta', [
        'property' => 'og:title',
        'content' => 'Custom og title',
        'inertia',
    ], '');
});

test('can add all base Open Graph tags', function () {
    $head = new HeadManager(new Renderer);

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
    expectsElement($elements[0])->toBe('title', ['inertia'], 'Page title');
    expectsElement($elements[1])->toBe('meta', [
        'name' => 'description',
        'content' => 'Page description...',
        'inertia',
    ], '');
    expectsElement($elements[2])->toBe('meta', [
        'property' => 'og:title',
        'content' => 'Page title',
        'inertia',
    ], '');
    expectsElement($elements[3])->toBe('meta', [
        'property' => 'og:description',
        'content' => 'Page description...',
        'inertia',
    ], '');
    expectsElement($elements[4])->toBe('meta', [
        'property' => 'og:image',
        'content' => 'https://example.com/image',
        'inertia',
    ], '');
    expectsElement($elements[5])->toBe('meta', [
        'name' => 'twitter:title',
        'content' => 'Page title',
        'inertia',
    ], '');
    expectsElement($elements[6])->toBe('meta', [
        'name' => 'twitter:description',
        'content' => 'Page description...',
        'inertia',
    ], '');
    expectsElement($elements[7])->toBe('meta', [
        'name' => 'twitter:image',
        'content' => 'https://example.com/image',
        'inertia',
    ], '');
});
