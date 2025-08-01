<?php

namespace Sann4ez\Holidays\Drivers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class HolidayApi extends \Sann4ez\Holidays\Contracts\CustomDriver
{
    const BASE_URI = 'https://holidayapi.com/v1/holidays';

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
            'key'   => config('holidays.holidayapi.token'),
            'country' => config('holidays.default_country'),
            'year'  => now()->subYear()->year,
        ], $query);

        return Http::get($this->getEndpoint(), $query);
    }

    /**
     * @inheritDoc
     */
    protected function hydrate(array $items): array
    {
        $holidays = $items['holidays'] ?? $items;

        $formattedHolidays = array_map(function ($holiday) {
            return [
                'name'          => $holiday['name'] ?? '',
                'date'          => $holiday['date'] ?? '',
                'country_code'  => $holiday['country'] ?? '',
                'type'          => ($holiday['public'] ?? '') ? 'Public' : 'Observance',
            ];
        }, $holidays);

        return [
            'options' => [
                'driver' => 'holidayapi',
            ],
            'holidays' => $formattedHolidays,
        ];
    }
}