<?php

namespace Sann4ez\Holiday\Facades;

use Sann4ez\Holiday\HolidayManager;
use Illuminate\Support\Facades\Facade;

class Holiday extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return HolidayManager::class;
    }
}