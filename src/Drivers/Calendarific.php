<?php

namespace Sann4ez\Holiday\Drivers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class Calendarific extends \Sann4ez\Holiday\Contracts\CustomDriver
{
    protected const BASE_URI = 'https://calendarific.com/api/v2/holidays';

    /**
     * @inheritDoc
     */
    public function getEndpoint(): string
    {
        return self::BASE_URI;
    }

    /**
     * @inheritDoc
     */
    protected function fetch(array $query = []): Response
    {
        $query = array_merge([
            'api_key' => config('holiday.calendarific.token'),
            'country' => config('holiday.default_country'),
            'year' => now()->year,
        ], $query);

        return Http::get($this->getEndpoint(), $query);
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
                'date'          => $holiday['date']['iso'] ?? '',
                'country_code'  => strtoupper($holiday['country']['id'] ?? ''),
                'type'          => $holiday['primary_type'] ?? '',
            ];
        }, $holidays);

        return [
            'options' => [
                'driver' => 'calendarific',
            ],
            'holidays' => $formattedHolidays,
        ];
    }
}