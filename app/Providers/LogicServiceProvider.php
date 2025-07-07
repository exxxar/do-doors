<?php

namespace App\Providers;

use App\Classes\NamingLogic;
use Illuminate\Support\ServiceProvider;

class LogicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('naming.service', fn () => new NamingLogic());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
