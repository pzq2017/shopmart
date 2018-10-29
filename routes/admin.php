<?php

Route::get('/login', 'Admin\LoginController@index')->name('login');
Route::post('/login', 'Admin\LoginController@login')->name('checkLogin');

Route::group(['middleware' => ['admin.auth'], 'namespace' => 'Admin'], function () {
    Route::get('/index', 'IndexController@index')->name('index');
    Route::get('/main', 'IndexController@main')->name('main');
    Route::get('/subMenus', 'IndexController@subMenus')->name('subMenus');
    Route::get('/clearCache', 'IndexController@clearCache')->name('clearCache');
    Route::post('/updatPwd', 'IndexController@updatPwd')->name('updatPwd');
    Route::get('/logout', 'IndexController@logout')->name('logout');

    Route::resource('/menu', 'MenuController')->except('show');
    Route::resource('/memu/privileges', 'MenuPrivilegesController')->except('show');
    Route::post('/menu/getSysMenus', 'MenuController@sysMenus')->name('menu.getSysMenus');

    Route::resource('/homemenu', 'HomeMenuController')->except('show');

    Route::resource('/roles', 'RolesController')->except('show');

    Route::resource('/staffs', 'StaffsController')->except('show');

    Route::get('/logs/staffs/login', 'LogController@staffsLogin')->name('logs.staffs.login');
    Route::get('/logs/staffs/operate', 'LogController@staffsOperate')->name('logs.staffs.operate');

    Route::resource('/messages', 'MessagesController');
    Route::get('/messages/{message}/sendSet', 'MessagesController@sendMessage')->name('messages.sendSet');
    Route::post('/messages/{message}/send', 'MessagesController@sendMessage')->name('messages.send');

    Route::post('/sigupload/picture', 'SiguploadController@picture')->name('sigupload.picture');
});