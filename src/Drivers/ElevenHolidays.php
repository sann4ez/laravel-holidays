<?php

namespace Sann4ez\Holidays\Drivers;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ElevenHolidays extends \Sann4ez\Holidays\Contracts\CustomDriver
{
    protected const BASE_URI = 'https://api.11holidays.com/v1/holidays';

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
            'country' => config('holidays.default_country'),
        ], $query);

        return Http::get($this->getEndpoint(), $query);
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
                'country_code'  => $holiday['country'] ?? '',
                'type'          => $holiday['type'] ?? '',
            ];
        }, $holidays);
    }
}