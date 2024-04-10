<?php

use App\Http\Controllers\Authorization\AuthorizationController;
use App\Http\Controllers\UserAuth\UserAuthController;
use App\Mail\AuthEmailCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    // Route::post('login', 'AuthController@login');
    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');
    // Route::post('create-account', [UserAuthController::class, 'createAccount']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'authorization',
], function () {
    Route::post('check-nickname-unique', [AuthorizationController::class, 'checkNicknameUnique']);
    Route::post('check-email-unique', [AuthorizationController::class, 'checkEmailUnique']);

    Route::post('request-email-code', [AuthorizationController::class, 'requestEmailCode']);
    Route::post('confirm-email-code', [AuthorizationController::class, 'confirmEmailCode']);
    Route::post('provider-email-confirmation', [AuthorizationController::class, 'confirmEmailByProvider']);

    Route::post('init-account', [AuthorizationController::class, 'initAccount']);
    Route::post('login-by-google', [AuthorizationController::class, 'loginByGoogle']);
});


Route::get('/test', function () {
    return 1;
});
