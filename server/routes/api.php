<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');

Route::post('socialsignin/{provider}', 'Auth\AuthController@socialSignin');
Route::post('socialsignup/{provider}', 'Auth\AuthController@socialSignup');
Route::post('signin', 'Auth\AuthController@signin');
Route::post('signup', 'Auth\AuthController@signup');
Route::post('logout', 'Auth\AuthController@logout');


Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResources([
        'user' => 'UserController',
        'giftLogo' => 'GiftLogoController',
        'giftBgImg' => 'GiftBgImgController',
        'giftCard' => 'GiftCardController',
    ]);

    Route::get('user_info', 'UserController@getUser');
});


Route::post('photo', function (Request $request) {
    return array("input" => $request->input(), "file" => $request->file());
});
