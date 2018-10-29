<?php
if (!function_exists('admin_auth')) {
    function admin_auth()
    {
        return Auth::guard('admin')->user();
    }
}

if (!function_exists('route_uri')) {
    function route_uri($name)
    {
        return config('app.url').'/'.Route::getRoutes()->getByName($name)->uri();
    }
}