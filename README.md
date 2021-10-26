# Inertia.js Laravel SSR Head

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![GitHub Tests Action Status][ico-github-action]][link-github-action]
[![Style CI Build Status][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

[繁體中文](README-zh-TW.md)

Simple SSR Head for Inertia Laravel

- 👓 Solved the Open Graph Meta crawling problem in Inertia.js x Laravel app
- ❌ No Headless Chrome, Node.js or PHP V8 Extension
- 🪄 Auto update Inertia page title

### **NOT a full SSR solution!! It doesn't solve the SEO problem!**

Because I made this package to make it easier for bot to crawl Open Graph Meta on Inertia.js App **without installing** (or can't installing) Headless Chrome, Node.js or PHP V8 Extension. This is applicable in situations where you are not familiar with how to install the above packages on the server, or the online web server does not support them (e.g. shared hosting).

Inspired by [Root template data of Inertia.js docs](https://inertiajs.com/responses#root-template-data).

## Installation

Install the package via composer:

```bash
composer require ycs77/inertia-laravel-ssr-head
```

Replace `<title>` to `@inertiaHead` directive:

```diff
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
-   <title>{{ config('app.name') }}</title>
+   @inertiaHead
</head>

<body>
    @inertia
</body>
</html>
```

### Install client plugin

And install the client npm package:

```bash
npm install inertia-title
// or
yarn add inertia-title
```

The package just auto update client `<title>` tag.

Add plugin for Vue 2 in `resources/js/app.js`:

```diff
...
+import InertiaTitle from 'inertia-title/vue2'

+Vue.use(InertiaTitle)

createInertiaApp({
  ...
})
```

Use in Vue 3 in `resources/js/app.js`:

```diff
...
+import InertiaTitle from 'inertia-title/vue3'

createInertiaApp({
  ...
  setup({ el, app, props, plugin }) {
    createApp({ render: () => h(app, props) })
      .use(plugin)
+     .use(InertiaTitle)
      .mount(el)
  },
})
```

Use in React or other client-side framework:

```diff
...
+import { useInertiaTitle } from 'inertia-title'

+useInertiaTitle()
```

## Config

Publish the config file with:

```bash
php artisan vendor:publish --tag="inertia-ssr-head-config"
```

You can setting the twitter site username or many in config `inertia-ssr-head.php`:

```php
<?php

return [

    'fb_app_id' => env('FB_APP_ID'),

    'twitter_site' => env('TWITTER_SITE'),
    'twitter_site_id' => env('TWITTER_SITE_ID'),

    'twitter_creator' => env('TWITTER_CREATOR'),
    'twitter_creator_id' => env('TWITTER_CREATOR_ID'),

    'twitter_app_name' => env('TWITTER_APP_NAME', env('APP_NAME')),

    'twitter_app_ios_id' => env('TWITTER_APP_IOS_ID'),
    'twitter_app_ios_url' => env('TWITTER_APP_IOS_URL'),

    'twitter_app_googleplay_id' => env('TWITTER_APP_GOOGLEPLAY_ID'),
    'twitter_app_googleplay_url' => env('TWITTER_APP_GOOGLEPLAY_URL'),

];
```

## Usage

Setting page title and description:

```php
return Inertia::render('Home')
    ->title('My homepage')
    ->description('Hello, This is my homepage~');
```

Then will be rendered to this HTML tags:

```html
<head>
    <title>My homepage</title>
    <meta name="description" content="Hello, This is my homepage~">
</head>
```

The head tags just render with server-side on first visit page, client only update `<title>`, no update other meta tags. Because the purpose of this package is only to allow the bot to crawl meta tags, it is omitted on the client side.

The title will injection to props, you can get the page title with using prop `title` or `$page.props.title` in client Vue 2/3:

```js
export default {
  props: {
    title: String,
  },
  mounted() {
    this.title             // => 'My homepage'  (with props)
    this.$page.props.title // => 'My homepage'  (with $page)
  },
}
```

Also, if you are using this package, it is not recommended to use Inertia `<Head>`.

### Title template

If you want add the Web site name after title, use `titleTemplate()` in `AppServiceProvider`, support using string and Closure:

```php
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Inertia::titleTemplate(fn ($title) => $title ? "$title - My App" : 'My App');
        // or pass string and %s will be replaced with the page title
        Inertia::titleTemplate('%s - My App');
    }
}
```

Or setting for one Inertia page:

```php
return Inertia::render('Home')
    ->title('My homepage', '%s :: My App');
```

If you want to disable title template only one page, you can set `false` in `title()`:

```php
return Inertia::render('Home')
    ->title('My homepage', false);
```

### Open Graph meta tags

Render Open Graph tags, have `title`, `description` and `ogMeta()`, the `ogMeta()` will generate the Open Graph meta `og:title`, `og:description`, `og:image`:

```php
return Inertia::render('Home')
    ->title('My homepage')
    ->description('Hello, This is my homepage~')
    ->image('https://example.com/image')
    ->ogMeta();

// Same...
return Inertia::render('Home')
    ->title('My homepage')
    ->description('Hello, This is my homepage~')
    ->image('https://example.com/image')
    ->ogTitle('My homepage')
    ->ogDescription('Hello, This is my homepage~')
    ->ogImage('https://example.com/image');
```

Or if you want only render `og:title`, `og:description` meta tags:

```php
return Inertia::render('Home')
    ->title('My homepage')
    ->ogTitle('Custom og title')
    ->ogDescription('Custom og description...');
```

### Twitter Card meta tags

Add Twitter Summary card meta tags with `twitterSummaryCard()`:

```php
return Inertia::render('Home')
    ->title('My homepage')
    ->description('Hello, This is my homepage~')
    ->image('https://example.com/image')
    ->twitterSummaryCard();
```

Add Summary large image card meta tags with `twitterLargeCard()`:

```php
return Inertia::render('Home')
    ->title('My homepage')
    ->description('Hello, This is my homepage~')
    ->image('https://example.com/image')
    ->twitterLargeCard()
    ->twitterCreator('@creator_twitter_name');
```

Add App card meta tags with `twitterAppCard()`:

```php
return Inertia::render('AppHome')
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
```

Add Player card meta tags with `twitterPlayerCard()`:

```php
return Inertia::render('Home')
    ->title('Video title')
    ->description('Video description...')
    ->image('https://example.com/video_thumbnail')
    ->twitterPlayerCard([
        'url' => 'https://example.com/video',
        'width' => 640,
        'height' => 360,
    ]);
```

## Custom head tag

Use `head()` method will add the custom HTML tag in `<head>`:

```php
return Inertia::render('Home')
    ->title('My homepage')
    ->head('<meta name="my-meta" content="some data...">')
    ->head('<meta name="my-meta" content="%s">', e('some data...')) // escape data
```

## Testing

```bash
composer test
```

## Alternatives

If need full SSR solution, please using [Inertia.js Official Server-side Rendering](https://inertiajs.com/server-side-rendering).

## Reference

* Inertia.js docs: [Root template data](https://inertiajs.com/responses#root-template-data)
* Facebool for Developers: [Webmasters - Sharing](https://developers.facebook.com/docs/sharing/webmasters)
* Twitter Developer Platform: [About Twitter Cards | Docs](https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/abouts-cards)

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Lucas Yang](https://github.com/ycs77)
- [Jonathan Reinink](https://github.com/reinink), creator for [Inertia.js](https://inertiajs.com/)
- [All Contributors](https://github.com/ycs77/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ycs77/inertia-laravel-ssr-head?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen?style=flat-square
[ico-github-action]: https://img.shields.io/github/workflow/status/ycs77/inertia-laravel-ssr-head/run-tests?label=tests&style=flat-square
[ico-style-ci]: https://github.styleci.io/repos/417571519/shield?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ycs77/inertia-laravel-ssr-head?style=flat-square

[link-packagist]: https://packagist.org/packages/ycs77/inertia-laravel-ssr-head
[link-github-action]: https://github.com/ycs77/inertia-laravel-ssr-head/actions?query=workflow%3Arun-tests+branch%3Amain
[link-style-ci]: https://github.styleci.io/repos/417571519
[link-downloads]: https://packagist.org/packages/ycs77/inertia-laravel-ssr-head
