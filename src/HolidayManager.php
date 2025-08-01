<?php

namespace Sann4ez\Holiday;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Sann4ez\Holiday\Contracts\CustomDriver;

class HolidayManager
{
    /**
     * @param array $query          Параметри запиту (наприклад: country, year, month)
     * @param string|null $driver   Ім'я драйвера або null, щоб використати драйвер за замовчуванням
     * @return array                Масив свят у стандартизованому форматі
     */
    public function get(array $query = [], string|null $driver = null): array
    {
        $driver ??= config('holiday.driver', \Sann4ez\Holiday\Drivers\Calendarific::class);
        $driverClass = config("holiday.drivers.{$driver}");

        /** @var CustomDriver $driver */
        $driver = app($driverClass);

        return $driver->getFormattedHolidays($query);
    }
}