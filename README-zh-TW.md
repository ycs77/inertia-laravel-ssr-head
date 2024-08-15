# Inertia.js Laravel SSR Head

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![GitHub Tests Action Status][ico-github-action]][link-github-action]
[![Style CI Build Status][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

[English](README.md) | 繁體中文

一個簡易的 Inertia Laravel SSR Head 套件

- 😎 解決了 Inertia.js x Laravel 網站中，無法被爬取社群媒體資訊 (Open Graph Meta) 的問題
- ❌ 不需要安裝 Headless Chrome、Node.js 或 PHP V8 Extension
- ✨ 自動更新 Inertia 頁面標題

靈感來自 [Inertia.js 官網 - Root template data](https://inertiajs.com/responses#root-template-data)。

### **記住！這個套件不是完整的 SSR 解決方案！！並沒有解決 SEO 的問題！**

因為我做這個套件的目的是可以**不用裝** (或不能裝) Headless Chrome、Node.js 或 PHP V8 Extension 時，為了讓 Inertia.js 的網站可以比較輕鬆的讓 bot 抓取 Open Graph Meta。適用情境於，比如不熟悉如何在伺服器上裝以上的套件，或者是上線網站伺服器不支援 (例：共享主機)。

如果你需要完整的 SSR 解決方案，可以使用 [Inertia.js 官方 Server-side Rendering](https://inertiajs.com/server-side-rendering) 功能。

## 支援版本

| 版本 | Laravel 版本 | PHP 版本 |
| ---- | ------------ | -------- |
| 1.x  | >=7.0        | >=7.3    |
| 2.x  | >=11.0       | >=8.2    |

## 安裝套件

使用 Composer 安裝套件：

```bash
composer require ycs77/inertia-laravel-ssr-head
```

替換 `<title>` 成 `@inertiaHead`：

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

### 安裝前端套件 (client 端)

可以用 NPM 或 Yarn 安裝：

```bash
npm install inertia-title
// 或
yarn add inertia-title
```

這個套件功能是會自動更新 `<title>`。

然後來看看要怎麼使用，首先先開啟 `resources/js/app.js`，Vue 2 的註冊方法是：

```diff
...
+import InertiaTitle from 'inertia-title/vue2'

+Vue.use(InertiaTitle)

createInertiaApp({
  ...
})
```

在 Vue 3 中：

```diff
...
+import InertiaTitle from 'inertia-title/vue3'

createInertiaApp({
  ...
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
+     .use(InertiaTitle)
      .mount(el)
  },
})
```

如果你是用 React 或其他前端框架：

```diff
...
+import { inertiaTitle } from 'inertia-title'

+inertiaTitle()
```

## Config 設定

發布 config 檔：

```bash
php artisan vendor:publish --tag="inertia-ssr-head-config"
```

你可以在 config 檔 `inertia-ssr-head.php` 裡面設定整個網站的 twitter site username 或其他的設定：

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

## 用法

設定 title 和 description：

```php
return Inertia::render('Home')
    ->title('首頁')
    ->description('哈囉！這是首頁~');
```

然後會渲染成以下的 HTML：

```html
<head>
    <title>首頁</title>
    <meta name="description" content="哈囉！這是首頁~">
</head>
```

在 SSR head 套件中，這些 head 標籤只會在首次訪問頁面時在 server 端渲染，client 端切換頁面只會更新 `<title>`，不會更新其他 meta 標籤。因為這個套件的目的只是要讓機器人抓取 meta 標籤，所以在 client 端就省略了。

標題會被塞進 props 裡，可以用 prop `title` 或 `$page.props.title` 取得標題，這裡有 Vue Options API 的範例：

```js
export default {
  props: {
    title: String,
  },
  created() {
    this.title             // => '首頁'  (用 props 取得標題)
    this.$page.props.title // => '首頁'  (用 $page 取得標題)
  },
}
```

以及 Composition API 的範例：

```vue
<script setup>
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  title: String,
})

const page = usePage()

props.title      // => '首頁'  (用 props 取得標題)
page.props.title // => '首頁'  (用 page.props 取得標題)
</script>
```

還有，如果你安裝了這個套件，就不要使用 Inertia 的 `<Head>`，會造成衝突。

### Title template

如果你要在標題後面都自動增加網站的名稱，可以在 `AppServiceProvider` 中使用 `titleTemplate()`，支援 string 和 Closure 兩種方式，：

```php
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Inertia::titleTemplate(fn ($title) => $title ? "$title - My App" : 'My App');
        // 或者傳入字串，%s 會被替換成頁面標題
        Inertia::titleTemplate('%s - My App');
    }
}
```

或者可以在單個 Inertia 頁面上設定：

```php
return Inertia::render('Home')
    ->title('首頁', '%s :: My App');
```

如果要禁用 Title template 的話，可以傳 `false` 進去：

```php
return Inertia::render('Home')
    ->title('首頁', false);
```

### Open Graph 標籤

渲染 Open Graph 標籤，需要有 `title`、`description` 和 `ogMeta()`，`ogMeta()` 則是會自動生成 `og:title`、`og:description`、`og:image` 三個標籤：

```php
return Inertia::render('Home')
    ->title('首頁')
    ->description('哈囉！這是首頁~')
    ->image('https://example.com/image')
    ->ogMeta();

// 效果一樣...
return Inertia::render('Home')
    ->title('首頁')
    ->description('哈囉！這是首頁~')
    ->image('https://example.com/image')
    ->ogTitle('首頁')
    ->ogDescription('哈囉！這是首頁~')
    ->ogImage('https://example.com/image');
```

或者可以單獨設定 `og:title`、`og:description` 標籤：

```php
return Inertia::render('Home')
    ->title('首頁')
    ->ogTitle('Custom og title')
    ->ogDescription('Custom og description...');
```

### Twitter Card 標籤

用 `twitterSummaryCard()` 設定 Twitter Summary card 的標籤：

```php
return Inertia::render('Home')
    ->title('首頁')
    ->description('哈囉！這是首頁~')
    ->image('https://example.com/image')
    ->twitterSummaryCard();
```

用 `twitterLargeCard()` 設定 Summary large image card 的標籤：

```php
return Inertia::render('Home')
    ->title('首頁')
    ->description('哈囉！這是首頁~')
    ->image('https://example.com/image')
    ->twitterLargeCard()
    ->twitterCreator('@creator_twitter_name');
```

用 `twitterAppCard()` 設定 App card 的標籤：

```php
return Inertia::render('AppHome')
    ->title('App title')
    ->description('App description...')
    ->twitterAppCard()
    ->twitterAppForIphone([
        'name' => '你的 APP',
        'id' => '123456789',
        'url' => 'https://example.com/iphone_app',
    ])
    ->twitterAppForIpad([
        'name' => '你的 APP',
        'id' => '123456789',
        'url' => 'https://example.com/ipad_app',
    ])
    ->twitterAppForGoogleplay([
        'name' => '你的 APP',
        'id' => '123456789',
        'url' => 'https://example.com/googleplay_app',
    ]);
```

用 `twitterPlayerCard()` 設定 Player card 的標籤：

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

## 自訂 head 標籤

使用 `tag()` 方法可以注入自訂的 HTML 標籤到 `<head>` 裡面：

```php
return Inertia::render('Home')
    ->title('首頁')
    ->tag('<meta name="my-meta" content="some data...">')
    ->tag('<meta name="my-meta" content="%s">', e('some data...')) // escape 傳入資料
```

## 測試

```bash
composer test
```

## 參考資料

* Inertia.js 文檔：[Root template data](https://inertiajs.com/responses#root-template-data)
* Meta for Developers: [Webmasters - Sharing](https://developers.facebook.com/docs/sharing/webmasters)
* Twitter Developer Platform: [About Twitter Cards | Docs](https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/abouts-cards)

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Lucas Yang](https://github.com/ycs77)
- [All Contributors](https://github.com/ycs77/inertia-laravel-ssr-head/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ycs77/inertia-laravel-ssr-head?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen?style=flat-square
[ico-github-action]: https://img.shields.io/github/actions/workflow/status/ycs77/inertia-laravel-ssr-head/tests.yml?branch=2.x&label=tests&style=flat-square
[ico-style-ci]: https://github.styleci.io/repos/417571519/shield?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ycs77/inertia-laravel-ssr-head?style=flat-square

[link-packagist]: https://packagist.org/packages/ycs77/inertia-laravel-ssr-head
[link-github-action]: https://github.com/ycs77/inertia-laravel-ssr-head/actions/workflows/tests.yml?query=branch%3A2.x
[link-style-ci]: https://github.styleci.io/repos/417571519
[link-downloads]: https://packagist.org/packages/ycs77/inertia-laravel-ssr-head
