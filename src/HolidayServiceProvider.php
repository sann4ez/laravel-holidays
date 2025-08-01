<?php

namespace Sann4ez\Holiday;

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
            __DIR__.'/../config/holiday.php' => config_path('holiday.php'),
        ], 'holiday-config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/holiday.php',
            'holiday'
        );

        $this->app->singleton(HolidayManager::class, function () {
            return new HolidayManager($this->app);
        });
    }
}