<?php

namespace Sann4ez\Holidays\Contracts;

use Illuminate\Http\Client\Response;

/**
 * Абстрактний драйвер для розширення зовнішніх сервісів (Драйверів)
 */
abstract class CustomDriver
{
    /**
     * Отримання списку свят
     *
     * @param  array $query             Параметри запиту до API (наприклад: country, year)
     * @return array                    Масив свят у стандартизованому форматі
     */
    public function getFormattedHolidays(array $query = []): array
    {
        try {
            $response = $this->fetch($query);
            $response->throw();

            $data = $response->json() ?: [];

            return [
                'options'  => ['driver' => $this->getDriverName()],
                'holidays' => $this->hydrate($data),
            ];
        } catch (\Throwable $e) {
            return [
                'options'  => ['driver' => null],
                'holidays' => [],
            ];
        }
    }

    /**
     * Отримання короткого імені драйвера
     *
     * @return string
     */
    protected function getDriverName(): string
    {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }

    /**
     * Повернути endpoint для HTTP-запиту
     *
     * @return string                   Наприклад: 'https://api.example.com/v1/holidays'
     */
    abstract protected function getEndpoint(): string;

    /**
     * Виконати HTTP-запит до зовнішнього сервісу та отримати сирі дані.
     *
     * @param  array $query             Параметри запиту до API (наприклад: country, year)
     * @return Response                 Відповідь HTTP-клієнта Laravel
     */
    abstract protected function fetch(array $query = []): Response;

    /**
     * Перетворити сирий формат даних у відформатований вигляд
     *
     * @param  array $items             Дані, отримані з API
     * @return array                    Масив свят у відформатованому вигляді
     */
    abstract protected function hydrate(array $items): array;
}