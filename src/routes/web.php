<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Sinarajabpour1998\LogManager\Http\Controllers',
    'prefix' => 'panel',
    'middleware' => ['web', 'auth', 'verified', Config::get('log-manager.permissions.main')]
], function () {

});
