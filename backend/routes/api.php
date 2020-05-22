<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// AUTHENTICATION BEGIN
Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');
Route::post('socialsignin/{provider}', 'Auth\AuthController@socialSignin');
Route::post('socialsignup/{provider}', 'Auth\AuthController@socialSignup');

Route::post('signin', 'Auth\AuthController@signin');
Route::post('signup', 'Auth\AuthController@signup');
Route::post('logout', 'Auth\AuthController@logout');
Route::get('no-authenticated', 'Auth\AuthController@no_authenticated')->name('no-authenticated');
// AUTHENTICATION END

// FOR SUSER BEGIN
Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResources([
        'user' => 'UserController',
        'giftLogo' => 'GiftLogoController',
        'giftBgImg' => 'GiftBgImgController',
        'giftCard' => 'GiftCardController',
    ]);

    Route::get('user_info', 'UserController@getUser');

    Route::apiResources([
        'customer' => 'CustomerController',
    ]);
    Route::post('get_giftcard', 'CustomerController@getGiftCard');
    Route::post('transaction', 'CustomerController@transactions');
    Route::post('get_customer', 'CustomerController@getCustomer');
});
// FOR SUSER END

// FOR CUSTOMER BEGIN
Route::post('transaction/create', 'CustomerController@useGiftCard');

// FOR CUSTOMER END
