<?php

namespace Sann4ez\Holidays\Drivers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class ApiNinjas extends \Sann4ez\Holidays\Contracts\CustomDriver
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
            'country' => config('holidays.default_country'),
        ], $query);

        return Http::withHeaders([
            'X-Api-Key' => config('holidays.apininjas.token'),
        ])->get($this->getEndpoint(), $query);
    }

    /**
     * @inheritDoc
     */
    protected function hydrate(array $items): array
    {
        $holidays = $items ?? [];

        return array_map(function ($holiday) {
            return [
                'name'          => $holiday['name'] ?? '',
                'date'          => $holiday['date'] ?? '',
                'country_code'  => $holiday['iso'] ?? '',
                'type'          => $holiday['type'] ?? '',
            ];
        }, $holidays);
    }
}