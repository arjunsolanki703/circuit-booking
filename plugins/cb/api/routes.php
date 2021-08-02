<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {

    Route::middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken')->namespace('Cb\Api\Controllers\V1')->group(function () {
        Route::apiResource('user', 'UserController');
        Route::apiResource('location', 'LocationController');
        Route::apiResource('location-address', 'LocationAddressController');
        Route::apiResource('vehicle-type', 'VehicleTypeController');
        Route::apiResource('variant', 'VariantController');
        Route::apiResource('variant-type', 'VariantTypeController');
        Route::apiResource('fia-grade', 'FiaGradeController');
    });

    Route::get('admin/get-token', 'Cb\Api\Controllers\V1\AdminController@getToken');

});
