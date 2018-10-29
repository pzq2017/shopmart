<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(256);
        View::composer(
            'admin/base',
            \App\Http\ViewComposers\AdminComposer::class
        );
        DB::listen(function ($query) {
            if (!empty($query->bindings)) {
                $sql = $query->sql;
                $bindings = $query->bindings;
                foreach ($bindings as $binding) {
                    $value = is_numeric($binding) ? $binding : "'".$binding."'";
                    $sql = preg_replace('/\?/', $value, $sql, 1);
                }
                Log::info($sql);
            } else {
                Log::info($query->sql);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
