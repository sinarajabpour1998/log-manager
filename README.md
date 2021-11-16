# Log Manager
This package provides log manager for laravel apps.

## Installation
Using Composer :

```bash
composer require sinarajabpour1998/log-manager
```

packagist : [log-manager](https://packagist.org/packages/sinarajabpour1998/log-manager)

## Usage

* Publish blade files

```bash
php artisan vendor:publish --tag=log-manager
```

** Please note if you already published the vendor, for updates you can run the 
following command :

```bash
php artisan vendor:publish --tag=log-manager --force
```

* Run migration command :

```bash
php artisan migrate
```

* Add the following tag in your sidebar layout :

```html
<x-log-menu></x-log-menu>
```

or shorten tag :

```html
<x-log-menu />
```

## Save custom logs

* First define some log types in log-manager config :

Types structure: "type" => "type_name"

```php
[
"log_types" => [
        "login" => "ورود به سایت",
        "registration" => "ثبت نام در سایت"
    ]
];
```

* Add the following code anywhere you want (be careful about namespace)

```php
use Sinarajabpour1998\LogManager\Facades\LogFacade;

LogFacade::generateLog("login");
```

Done ! now all the logs will be saved in the logs table

## Save system error logs

Edit the following file :

```bash
app\Exceptions\Handler.php
```

Your register method in Exception handler must be like this :

```php
    use Sinarajabpour1998\LogManager\Facades\LogFacade;
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // Added for log-manager
            if ($this->shouldReport($e)){
                LogFacade::generateErrorLog($e);
            }
        });
    }
```

Done ! now all the system error logs will be saved in the error_logs table

## Config options

You can set custom permissions for each section of this package. make sure that you already specified permissions in a seeder.

Also you need log_types before get started with custom logs.
