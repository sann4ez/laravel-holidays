<?php

namespace Sann4ez\Holiday\Contracts;

use Illuminate\Support\Collection;
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
        $response = $this->fetch($query);

        $data = $response->json() ?: [];

        return $this->hydrate($data);
    }

    /**
     * Повернути базовий URL або endpoint для HTTP-запиту
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