# Laravel Banners

TODO: Custom Width & Height
TODO: Refactor code

## Getting started

### Installation
This library can be installed using composer, if you don't have it already, [download it](https://getcomposer.org/download).

You can either run this command :
```bash
composer require felixdorn/laravel-banners
```
Or by adding a requirement in your `composer.json` :
```json
{
  "require": {
    "felixdorn/laravel-banners": "0.1.0"  
  }
}
```
Don't forget to run `composer install` after adding the requirement.

You might also want to publish the configuration :
```bash
php artisan vendor:publish --provider=Delights\Banners\BannersServiceProvider
```

### Usage

```blade
<meta name="og:image" content="{{ route('generate-banner', [
    'title' => 'My site',
    'body' => 'My site is really cool because yes',
    'image' => '/assets/logo.png',
    'theme' => 'dark',
    'width' => 1200,    
    'height' => 620 
]) }}">
```

> Note: If you don't specify any of those values, it falls back to the configuration's default (config/banners.php) 

#### Cache

