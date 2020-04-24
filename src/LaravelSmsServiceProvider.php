<?php

/*
 * This file is part of the gengxuliang/laravel-sms.
 * (c) gengxuliang <gxl8566@163.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gengxuliang\LaravelSms;

use Illuminate\Support\ServiceProvider;

class LaravelSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/easysms.php' => config_path('easysms.php'),
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ],'Laravel-sms');
        }
    }

    /**
     * Register any application services.
     */
    public function register()
    {

    }
}
