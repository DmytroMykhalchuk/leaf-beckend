<?php

use App\Http\Controllers\Authorization\AuthorizationController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\UserAuth\UserAuthController;
use App\Http\Services\ImageService;
use App\Mail\AuthEmailCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    // Route::post('login', 'UserAuthController@login');
    // Route::post('logout', 'UserAuthController@logout');
    Route::post('refresh', [UserAuthController::class, 'refresh']);
    Route::post('me', [UserAuthController::class, 'me']);
    // Route::post('create-account', [UserUserAuthController::class, 'createAccount']);
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

Route::group(([
    'middleware' => 'api',
    'prefix' => 'profile',
]), function () {
    Route::post('update', [ProfileController::class, 'updateProfile']);

    Route::post('change-email-request', [ProfileController::class, 'changeEmail']);
    Route::post('confirm-email-changing', [ProfileController::class, 'confirmEmailChanging']);
    Route::post('change-email-provider', [ProfileController::class, 'changeEmailProvider']);

    Route::post('request-email-code', [ProfileController::class, 'requestEmailCode']);
    Route::post('confirm-current-email', [ProfileController::class, 'confirmCurrentEmail']);
});


Route::get('/test', function () {
    $imageService = new ImageService();

    // $response = $imageService->deleteProfilePicture('/assets/avatars/1712821234661793f26990f.jpg');
    // dd($response);
    return 1;
});
