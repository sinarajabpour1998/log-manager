<?php

namespace Sinarajabpour1998\LogManager;

use Illuminate\Support\ServiceProvider;
use Sinarajabpour1998\LogManager\Facades\LogFacade;
use Sinarajabpour1998\LogManager\Repositories\LogRepository;

class LogManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        LogFacade::shouldProxyTo(LogRepository::class);
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views','logManager');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/log-manager.php', 'log-manager');
        $this->publishes([
            __DIR__.'/config/log-manager.php' =>config_path('log-manager.php'),
            __DIR__.'/views/' => resource_path('views/vendor/LogManager'),
        ], 'log-manager');
    }
}
