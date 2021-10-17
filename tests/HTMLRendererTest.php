<?php

use Inertia\SSRHead\HTML\Element;
use Inertia\SSRHead\HTML\Renderer;

test('can rendered <title>', function () {
    $renderer = new Renderer([
        new Element('title', [], 'Page title'),
    ]);

    $html = $renderer->render();

    expect($html)->toBe('<title>Page title</title>');
});

test('can rendered <title inertia>', function () {
    $renderer = new Renderer([
        new Element('title', ['inertia'], 'Page title'),
    ]);

    $html = $renderer->render();

    expect($html)->toBe('<title inertia>Page title</title>');
});

test('can rendered <meta name="description" content="...">', function () {
    $renderer = new Renderer([
        new Element('meta', [
            'name' => 'description',
            'content' => 'Page description...',
        ]),
    ]);

    $html = $renderer->render();

    expect($html)->toBe('<meta name="description" content="Page description...">');
});

test('can rendered mitiple tags with oneline', function () {
    $renderer = new Renderer([
        new Element('title', ['inertia'], 'Page title'),
        new Element('meta', [
            'name' => 'description',
            'content' => 'Page description...',
        ]),
        new Element('meta', [
            'property' => 'og:description',
            'content' => 'Page description...',
        ]),
        new Element('meta', [
            'property' => 'og:image',
            'content' => 'https://example.com/image',
        ]),
    ]);

    $html = $renderer->render();

    expect($html)->toBe('<title inertia>Page title</title><meta name="description" content="Page description..."><meta property="og:description" content="Page description..."><meta property="og:image" content="https://example.com/image">');
});

test('can rendered mitiple tags with break line', function () {
    $renderer = new Renderer([
        new Element('title', ['inertia'], 'Page title'),
        new Element('meta', [
            'name' => 'description',
            'content' => 'Page description...',
        ]),
        new Element('meta', [
            'property' => 'og:description',
            'content' => 'Page description...',
        ]),
        new Element('meta', [
            'property' => 'og:image',
            'content' => 'https://example.com/image',
        ]),
    ]);

    $html = $renderer->format(8)->render();

    expect($html)->toBe(<<<'HTML'
<title inertia>Page title</title>
        <meta name="description" content="Page description...">
        <meta property="og:description" content="Page description...">
        <meta property="og:image" content="https://example.com/image">
HTML);
});
