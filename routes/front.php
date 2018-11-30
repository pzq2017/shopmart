<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/28
 * Time: 11:23
 */

Route::group(['namespace' => 'Front'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::group(['prefix' => 'register', 'as' => 'register'], function () {
            Route::get('/', 'RegisterController@index');
            Route::get('/check_account', 'RegisterController@checkAccount')->name('.check_account');
            Route::get('/check_mobile', 'RegisterController@checkMobile')->name('.check_mobile');
            Route::get('/check_email', 'RegisterController@checkEmail')->name('.check_email');
            Route::post('/send_sms', 'RegisterController@sendSms')->name('.send_sms');
            Route::post('/store', 'RegisterController@store')->name('.store');
        });
    });
});