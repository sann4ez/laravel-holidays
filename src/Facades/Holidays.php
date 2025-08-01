<?php

namespace Sann4ez\Holidays\Facades;

use Sann4ez\Holidays\HolidayManager;
use Illuminate\Support\Facades\Facade;

class Holidays extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return HolidayManager::class;
    }
}