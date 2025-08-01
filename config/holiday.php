<?php

return [
    'default_country' => env('HOLIDAY_DEFAULT_COUNTRY', 'UA'),

    'driver' => env('HOLIDAY_DRIVER', 'holidayapi'),

    'drivers' => [
        'calendarific' => \Sann4ez\Holiday\Drivers\Calendarific::class,
        'apininjas' => \Sann4ez\Holiday\Drivers\ApiNinjas::class,         // У безкоштовному плані не можна вказувати рік, по дефолту поточний
        'holidayapi' => \Sann4ez\Holiday\Drivers\HolidayApi::class,       // Немає поточного року у безкоштовному плані
    ],

    'calendarific' => [
        'token' => env('CALENDARFIC_TOKEN', ''),
    ],

    'apininjas' => [
        'token' => env('APININJAS_TOKEN', ''),
    ],

    'holidayapi' => [
        'token' => env('HOLIDAYAPI_TOKEN', ''),
    ],
];