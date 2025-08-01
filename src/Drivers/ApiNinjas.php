<?php

namespace Sann4ez\Holiday\Drivers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class ApiNinjas extends \Sann4ez\Holiday\Contracts\CustomDriver
{
    protected const BASE_URI = 'https://api.api-ninjas.com/v1/holidays';

    /**
     * @inheritDoc
     */
    protected function getEndpoint(): string
    {
        return self::BASE_URI;
    }

    /**
     * @inheritDoc
     */
    protected function fetch(array $query = []): Response
    {
        $query = array_merge([
            'country' => config('holiday.default_country'),
        ], $query);

        return Http::withHeaders([
            'X-Api-Key' => config('holiday.apininjas.token'),
        ])->get($this->getEndpoint(), $query);
    }

    /**
     * @inheritDoc
     */
    protected function hydrate(array $items): array
    {
        $holidays = $items['response']['holidays'] ?? $items;

        $formattedHolidays = array_map(function ($holiday) {
            return [
                'name'          => $holiday['name'] ?? '',
                'date'          => $holiday['date'] ?? '',
                'country_code'  => $holiday['iso'] ?? '',
                'type'          => $holiday['type'] ?? '',
            ];
        }, $holidays);

        return [
            'options' => [
                'driver' => 'apininjas',
            ],
            'holidays' => $formattedHolidays,
        ];
    }
}