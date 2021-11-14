# Log Manager
This package provides log manager for laravel apps.

## Installation
Using Composer :

```bash
composer require sinarajabpour1998/log-manager
```

packagist : [log-manager](https://packagist.org/packages/sinarajabpour1998/log-manager)

## Usage

* Change the user modal namespace to laratrust config 
  (located in `/config/laratrust.php`) in `user_models` section :

```php
'user_models' => [
    'users' => 'App\Models\User',
],
```

* Publish blade files

```bash
php artisan vendor:publish --tag=log-manager
```

** Please note if you already published the vendor, for updates you can run the 
following command :

```bash
php artisan vendor:publish --tag=log-manager --force
```

* Add the following tag in your sidebar layout :

```html
<x-log-menu></x-log-menu>
```

or shorten tag :

```html
<x-log-menu />
```

## Config options

You can set custom permissions for each section of this package. make sure that you already specified permissions in a seeder.

