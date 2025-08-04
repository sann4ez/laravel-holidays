<?php

namespace Sann4ez\Holidays;

use Sann4ez\Holidays\Contracts\CustomDriver;

class HolidayManager
{
    /**
     * @param array $query          Параметри запиту (наприклад: country, year, month)
     * @param string|null $driver   Ім'я драйвера або null, щоб використати драйвер за замовчуванням
     * @return array                Масив свят у стандартизованому форматі
     */
    public function get(array $query = [], string|null $driver = null): array
    {
        $driver ??= config('holidays.driver', 'calendarific');
        $driverClass = config("holiday.drivers.{$driver}", \Sann4ez\Holidays\Drivers\Calendarific::class);

        /** @var CustomDriver $driver */
        $driver = app($driverClass);

        return $driver->getFormattedHolidays($query);
    }
}