<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Sinarajabpour1998\LogManager\Http\Controllers',
    'prefix' => 'panel',
    'middleware' => ['web', 'auth', 'verified', Config::get('log-manager.permissions.main')]
], function () {
    Route::get("logs/all", "LogController@index")
        ->name("log-manager.index")
        ->middleware(Config::get('log-manager.permissions.all-logs'));

    Route::get("search_log_users", "LogController@findUser")
        ->name("log-manager.users");

    Route::get("error-logs/all", "LogController@errorLogIndex")
        ->name("log-manager.error.log.index")
        ->middleware(Config::get('log-manager.permissions.error-logs'));

    Route::get("error-log/{log}", "LogController@showErrorLog")
        ->name("log-manager.error.log.show")
        ->middleware(Config::get('log-manager.permissions.show-error-log'));

    Route::delete("error-log/delete/{log}", "LogController@destroyErrorLog")
        ->name("log-manager.error.log.destroy")
        ->middleware(Config::get('log-manager.permissions.delete-error-log'));
});
