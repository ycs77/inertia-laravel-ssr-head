# Inertia.js Laravel SSR Head

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![GitHub Tests Action Status][ico-github-action]][link-github-action]
[![Style CI Build Status][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

Simple SSR Head for Inertia Laravel.

## Installation

Install the package via composer:

```bash
composer require ycs77/inertia-laravel-ssr-head
```

Install the client npm package:

```bash
npm install inertia-title
// or
yarn add inertia-title
```

Publish the config file with:
```bash
php artisan vendor:publish --provider="Inertia\SSRHead\InertiaSSRHeadServiceProvider" --tag="inertia-laravel-ssr-head-config"
```

## Usage in Laravel

...

## Usage in Vue 2

...

## Usage in Vue 3

...

## Testing

```bash
composer test
```

## Reference

* Facebool for Developers: [Webmasters - Sharing](https://developers.facebook.com/docs/sharing/webmasters)
* Twitter Developer Platform: [About Twitter Cards | Docs](https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/abouts-cards)

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

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
