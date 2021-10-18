# Inertia.js Laravel SSR Head

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![GitHub Tests Action Status][ico-github-action]][link-github-action]
[![Style CI Build Status][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

Simple SSR Head for Inertia Laravel, solve the social media metadata display of small Inertia.js x Laravel site.

**NOT a full SSR solution!!**

Inspired by [Root template data of Inertia.js docs](https://inertiajs.com/responses#root-template-data).

## Installation

Install the package via composer:

```bash
composer require ycs77/inertia-laravel-ssr-head
```

<!-- Publish the config file with:

```bash
php artisan vendor:publish --provider="Inertia\SSRHead\InertiaSSRHeadServiceProvider" --tag="inertia-laravel-ssr-head-config"
``` -->

Replace &lt;title&gt; to `@inertiaHead` directive:

```diff
 <!DOCTYPE html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 <head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1">
-    <title>{{ config('app.name') }}</title>
+    @inertiaHead
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

The package just auto update client &lt;title&gt; tag.

Add plugin for Vue 2:

```diff
 ...
+import { InertiaTitleVue2 } from 'inertia-title'

+Vue.use(InertiaTitleVue2)

 createInertiaApp({
   ...
 })
```

Or use in Vue 3:

```diff
 ...
+import { InertiaTitleVue3 } from 'inertia-title'

 createInertiaApp({
   ...
   setup({ el, app, props, plugin }) {
     createApp({ render: () => h(app, props) })
       .use(plugin)
+      .use(InertiaTitleVue3)
       .mount(el)
   },
 })
```

## Usage

Setting page title and description:

```php
return Inertia::render('Home')
    ->title('My homepage')
    ->description('Hello, This is my homepage~');
```

Rendered this HTML tags:

```html
<head>
    <title inertia>My homepage</title>
    <meta name="description" content="Hello, This is my homepage~" inertia>
</head>
```

The head tags just render with server-side on first visit page, client only update &lt;title&gt;, no update other meta tags.

The title will injection to `$page`, you can get the page title with using prop `title` or `$page.props.title` in client Vue 2/3:

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

Also, if you are using this package, it is not recommended to use Inertia &lt;Head&gt;.

Render Open Graph and Twitter Card tags, have `title`, `description`, `ogMeta()` is generate the Open Graph meta `og:title`, `og:description`, `og:image`:

```php
return Inertia::render('Home')
    ->title('My homepage')
    ->description('Hello, This is my homepage~')
    ->image('https://example.com/image')
    ->ogMeta();
```

Or if you want only render `og:title`, `og:description` meta tags:

```php
return Inertia::render('Home')
    ->title('My homepage')
    ->ogTitle('Custom og title')
    ->ogDescription('Custom og description...');
```

And same as `twitterMeta()`:

```php
return Inertia::render('Home')
    ->title('My homepage')
    ->description('Hello, This is my homepage~')
    ->image('https://example.com/image')
    ->twitterMeta();
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

The HeadManager is take from [Inertia.js](https://inertiajs.com/), thanks the awesome package for [Jonathan Reinink](https://github.com/reinink).

- [Lucas Yang](https://github.com/ycs77)
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
