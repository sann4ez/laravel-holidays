<?php

return [
    'default_country' => env('HOLIDAY_DEFAULT_COUNTRY', 'UA'),

    'driver' => env('HOLIDAY_DRIVER', 'calendarific'),

    'drivers' => [
        'calendarific' => \Sann4ez\Holidays\Drivers\Calendarific::class,
        'apininjas' => \Sann4ez\Holidays\Drivers\ApiNinjas::class,         // У безкоштовному плані не можна вказувати рік, по дефолту поточний
        'holidayapi' => \Sann4ez\Holidays\Drivers\HolidayApi::class,       // Немає поточного року у безкоштовному плані
        'elevenholidays' => \Sann4ez\Holidays\Drivers\ElevenHolidays::class,       // Немає поточного року у безкоштовному плані
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

    'elevenholidays' => [
        'token' => env('ELEVENHOLIDAYS_TOKEN', ''),
    ],
];