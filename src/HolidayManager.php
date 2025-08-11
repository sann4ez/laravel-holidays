<?php

namespace Sann4ez\Holidays;

use Sann4ez\Holidays\Contracts\CustomDriver;

class HolidayManager
{
    /**
     * Отримання списку свят з fallback-логікою
     * Пробує кілька драйверів або один, поки не поверне результат
     *
     * @param array $query                  Параметри запиту (наприклад: country, year, month)
     * @param array|string|null $drivers    Ім'я драйвера або null, щоб використати драйвер за замовчуванням
     * @return array                        Масив свят у стандартизованому форматі
     */
    public function get(array $query = [], array|string $drivers = null): array
    {
        if (is_string($drivers)) {
            $drivers = [$drivers];
        }

        $drivers ??= array_keys(config('holidays.drivers', [])) ?: ['calendarific'];

        foreach ($drivers as $driver) {
            $driverClass = config("holidays.drivers.{$driver}");

            if (!$driverClass) {
                continue;
            }

            /** @var CustomDriver $driver */
            $driver = app($driverClass);

            $formattedHolidays = $driver->getFormattedHolidays($query);

            if (empty($formattedHolidays['holidays'])) {
                continue;
            }

            return $formattedHolidays;
        }

        return [
            'options' => ['driver' => null,],
            'holidays' => [],
        ];
    }

    /**
     * Перевіряє, чи є передана дата святковим днем
     *
     * Виконує пошук дати у списку свят, отриманих з одного чи кількох драйверів,
     * з fallback-логікою (аналогічно методу get())
     *
     * Якщо увімкнено прапорець $weekend і дата є вихідним — повертає true
     * без запиту до драйверів
     *
     * @param  \Carbon\Carbon      $date      Дата, яку потрібно перевірити
     * @param  array               $query     Додаткові параметри запиту (наприклад: country, year, month)
     * @param  bool                $weekend   Якщо true — враховує вихідні дні
     * @param  array|string|null   $drivers   Ім’я одного драйвера або список драйверів
     *                                        null — використати дефолтний список з конфігу
     *
     * @return bool                           true, якщо дата є святковою або вихідною; інакше false
     */
    public function is(\Carbon\Carbon $date, array $query = [], bool $weekend = false, array|string $drivers = null): bool
    {
        $drivers = (array) ($drivers ?? array_keys(config('holidays.drivers', ['calendarific'])));

        if ($weekend && $date->isWeekend()) {
            return true;
        }

        $query += ['year' => $date->year];

        $result = $this->get($query, $drivers);

        $dates = array_flip(\Arr::pluck($result['holidays'] ?? [], 'date'));

        return isset($dates[$date->toDateString()]);
    }
}