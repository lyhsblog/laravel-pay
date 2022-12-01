<?php

namespace Ybzc\Laravel\Pay;

use Illuminate\Support\ServiceProvider;

class PayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/Models/Migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/', 'laravelpay');
        $this->app->bind(PayService::class, PayStateMachineService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
