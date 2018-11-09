<?php

Route::get('/login', 'Admin\LoginController@index')->name('login');
Route::post('/login', 'Admin\LoginController@login')->name('checkLogin');

Route::group(['middleware' => ['admin.auth'], 'namespace' => 'Admin'], function () {
    Route::post('/sigupload/upload', 'SiguploadController@upload')->name('sigupload.upload');
    /**
     * 首页
     */
    Route::get('/index', 'IndexController@index')->name('index');

    /**
     * 系统管理
     */
    Route::group(['namespace' => 'System', 'prefix' => '/system/', 'as' => 'system.'], function () {
        Route::resource('staff', 'StaffsController')->except('show');
        Route::get('staff/lists', 'StaffsController@lists')->name('staff.lists');

        Route::resource('role', 'RolesController')->except('show');
        Route::get('role/lists', 'RolesController@lists')->name('role.lists');

        Route::get('/log/index', 'LogsController@index')->name('log.index');
        Route::get('/log/lists', 'LogsController@lists')->name('log.lists');
    });

    /**
     * 基础设置
     */
    Route::group(['namespace' => 'Config', 'prefix' => '/config/', 'as' => 'config.'], function () {
        Route::get('/platform', 'PlatformController@index')->name('platform.index');
        Route::post('/platform/save', 'PlatformController@save')->name('platform.save');

        Route::resource('nav', 'NavsController')->except('show');
        Route::get('nav/lists', 'NavsController@lists')->name('nav.lists');

        Route::resource('ad', 'AdsController')->except('show');
        Route::get('ad/lists', 'AdsController@lists')->name('ad.lists');
        Route::put('ad/{ad}/update_publish_date', 'AdsController@update_publish_date')->name('ad.update_publish_date');

        Route::resource('ad_position', 'AdPositionsController')->except('show');
        Route::get('ad_position/lists', 'AdPositionsController@lists')->name('ad_position.lists');

        Route::resource('bank', 'BanksController')->except('show');
        Route::get('bank/lists', 'BanksController@lists')->name('bank.lists');
        Route::put('bank/{bank}/update_status', 'BanksController@update_status')->name('bank.update_status');

        Route::resource('payment_config', 'PaymentConfigController')->only(['index', 'edit', 'update']);
        Route::get('payment_config/lists', 'PaymentConfigController@lists')->name('payment_config.lists');
        Route::put('payment_config/{payment_config}/enabled', 'PaymentConfigController@enabled')->name('payment_config.enabled');
        Route::put('payment_config/{payment_config}/debug', 'PaymentConfigController@debug')->name('payment_config.debug');

        Route::resource('area', 'AreaController')->except('show');
        Route::get('area/lists', 'AreaController@lists')->name('area.lists');
    });

    /**
     * 运营管理
     */
    Route::group(['namespace' => 'Operate', 'prefix' => '/operation/', 'as' => 'operation.'], function () {
        Route::get('index', 'OperationController@index')->name('index');
    });

    /**
     * 订单管理
     */
    Route::group(['namespace' => 'Order', 'prefix' => '/order/', 'as' => 'order.'], function () {
        Route::get('index', 'OrderController@index')->name('index');
    });

    /**
     * 店铺管理
     */
    Route::group(['namespace' => 'Shop', 'prefix' => '/shop/', 'as' => 'shop.'], function () {
        Route::get('index', 'ShopController@index')->name('index');
    });

    /**
     * 商品管理
     */
    Route::group(['namespace' => 'Goods', 'prefix' => '/goods/', 'as' => 'goods.'], function () {
        Route::get('index', 'GoodsController@index')->name('index');
    });

});