<?php

/*
 * This file is part of the gengxuliang/laravel-sms.
 * (c) gengxuliang <gxl8566@163.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gengxuliang\LaravelSms;

use Illuminate\Support\ServiceProvider;
use Overtrue\EasySms\EasySms;

class LaravelSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/easysms.php'  => config_path('easysms.php'),
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'Laravel-sms');
        }
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/easysms.php', 'easysms');

        $this->app->singleton(EasySms::class, function () {
            $config  = config('easysms');
            $easySms = new EasySms($config);
            return $easySms;
        });

        $this->app->alias(EasySms::class, 'easysms');
    }
}
