<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Sinarajabpour1998\LogManager\Http\Controllers',
    'prefix' => 'panel',
    'middleware' => ['web', 'auth', 'verified', Config::get('log-manager.permissions.main')]
], function () {
    Route::get("logs/all", "LogController@index")->name("log-manager.index");
    Route::get("search_log_users", "LogController@findUser")->name("log-manager.users");
});
