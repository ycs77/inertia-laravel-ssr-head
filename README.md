# Inertia.js Laravel SSR Head

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ycs77/inertia-laravel-ssr-head.svg?style=flat-square)](https://packagist.org/packages/ycs77/inertia-laravel-ssr-head)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/ycs77/inertia-laravel-ssr-head/run-tests?label=tests)](https://github.com/ycs77/inertia-laravel-ssr-head/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/ycs77/inertia-laravel-ssr-head/Check%20&%20fix%20styling?label=code%20style)](https://github.com/ycs77/inertia-laravel-ssr-head/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ycs77/inertia-laravel-ssr-head.svg?style=flat-square)](https://packagist.org/packages/ycs77/inertia-laravel-ssr-head)

Simple SSR Head for Inertia Laravel.

## Installation

Install the package via composer:

```bash
composer require ycs77/inertia-laravel-ssr-head
```

Publish the config file with:
```bash
php artisan vendor:publish --provider="Ycs77\InertiaSSRHead\InertiaSSRHeadServiceProvider" --tag="inertia-laravel-ssr-head-config"
```

## Usage

```php
// ...
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Lucas Yang](https://github.com/ycs77)
- [All Contributors](https://github.com/ycs77/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
