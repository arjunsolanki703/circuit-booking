<?php

Route::group(['prefix' => 'api'], function() {
    Route::get('test', function (\Request $request) {
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        $user = Auth::findUserById($user_id);
        if ($user->hasUserPermissionWithName("Booking")) {
            return response()->json(('The test was successful'));
        } else {
            return response()->json(null, 401);
        }
    })->middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken');

    Route::post('restore', function (\Request $request) {
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        $user = Auth::findUserById($user_id);
        //try {
            $reset = new \Cb\UserPlus\Components\AccountExtend();
            $reset->property('resetPage', 'profile/login');
            $reset = $reset->onRestorePassword();
        //} catch (Exception $ex) {
        //    return response()->json(json_encode($ex), 502);
        //}
        //return response()->json(('We send you instruction on your E-mail'));
    });

    Route::options('/login', function (Request $request) {
        return response()->json([]);
    });
    Route::options('/users', function (Request $request) {
        return response()->json([]);
    });

    Route::get('users', function (\Request $request) {
        return response()->json(('The test was successful'));
    })->middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken');

    Route::resource('trackdays', 'Cb\UserPlus\Controllers\Trackdays');//->middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken');
    Route::resource('makes', 'Cb\UserPlus\Controllers\Car2DB\MakeController');//->middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken');
    Route::resource('models', 'Cb\UserPlus\Controllers\Car2DB\ModelController');//->middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken');
    Route::resource('series', 'Cb\UserPlus\Controllers\Car2DB\SerieController');//->middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken');
    Route::resource('trims', 'Cb\UserPlus\Controllers\Car2DB\TrimController');//->middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken');
    Route::resource('countries', 'Cb\UserPlus\Controllers\CountryController');//->middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken');
});
