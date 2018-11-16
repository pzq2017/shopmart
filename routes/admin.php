<?php

Route::get('/login', 'Admin\LoginController@index')->name('login');
Route::post('/login', 'Admin\LoginController@login')->name('checkLogin');

Route::group(['middleware' => ['admin.auth'], 'namespace' => 'Admin'], function () {
    Route::post('/sigupload/upload', 'SiguploadController@upload')->name('sigupload.upload');
    Route::get('/my_info', 'IndexController@myInfo')->name('my_info');
    Route::post('/change_my_info', 'IndexController@changeMyInfo')->name('change_my_info');
    Route::post('/change_password', 'IndexController@changePassword')->name('change_password');
    Route::get('/logout', 'IndexController@logout')->name('logout');

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
        Route::get('staff/get_data', 'StaffsController@getData')->name('staff.get_data');

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
        Route::put('nav/{nav}/set_show', 'NavsController@setShow')->name('nav.set_show');

        Route::resource('ad', 'AdsController')->except('show');
        Route::get('ad/lists', 'AdsController@lists')->name('ad.lists');
        Route::put('ad/{ad}/update_publish_date', 'AdsController@updatePublishDate')->name('ad.update_publish_date');

        Route::resource('ad_position', 'AdPositionsController')->except('show');
        Route::get('ad_position/lists', 'AdPositionsController@lists')->name('ad_position.lists');

        Route::resource('bank', 'BanksController')->except('show');
        Route::get('bank/lists', 'BanksController@lists')->name('bank.lists');
        Route::put('bank/{bank}/update_status', 'BanksController@updateStatus')->name('bank.update_status');

        Route::resource('payment_config', 'PaymentConfigController')->only(['index', 'edit', 'update']);
        Route::get('payment_config/lists', 'PaymentConfigController@lists')->name('payment_config.lists');
        Route::put('payment_config/{payment_config}/enabled', 'PaymentConfigController@enabled')->name('payment_config.enabled');
        Route::put('payment_config/{payment_config}/debug', 'PaymentConfigController@debug')->name('payment_config.debug');

        Route::resource('area', 'AreaController')->except('show');
        Route::get('area/lists', 'AreaController@lists')->name('area.lists');
        Route::put('area/{area}/set_show', 'AreaController@setShow')->name('area.set_show');

        Route::resource('friend_link', 'FriendLinksController')->except('show');
        Route::get('friend_link/lists', 'FriendLinksController@lists')->name('friend_link.lists');
        Route::put('friend_link/{friend_link}/is_show', 'FriendLinksController@isShow')->name('friend_link.is_show');
    });

    /**
     * 文章管理
     */
    Route::group(['namespace' => 'Article'], function () {
        Route::resource('article', 'ArticleController')->except('show');
        Route::get('article/lists', 'ArticleController@lists')->name('article.lists');
        Route::get('article/set_pub', 'ArticleController@setPub')->name('article.set_pub');

        Route::group(['prefix' => '/article/', 'as' => 'article.'], function () {
            Route::resource('category', 'CategoryController')->except('show');
            Route::get('category/lists', 'CategoryController@lists')->name('category.lists');
        });
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