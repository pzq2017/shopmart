<?php

Route::get('/login', 'Admin\LoginController@index')->name('login');
Route::post('/login', 'Admin\LoginController@login')->name('checkLogin');

Route::group(['middleware' => ['admin.auth'], 'namespace' => 'Admin'], function () {
    Route::post('/sigupload/picture', 'SiguploadController@picture')->name('sigupload.picture');
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