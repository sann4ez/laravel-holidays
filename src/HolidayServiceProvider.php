<?php

namespace Sann4ez\Holidays;

use Illuminate\Support\ServiceProvider;

class HolidayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/holidays.php' => config_path('holidays.php'),
        ], 'holidays-config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/holidays.php',
            'holidays'
        );

        $this->app->singleton(HolidayManager::class, function () {
            return new HolidayManager();
        });
    }
}