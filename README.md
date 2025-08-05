# Laravel Holidays

Laravel package to get holidays with multi-driver support

[![License](https://img.shields.io/packagist/l/sann4ez/laravel-holidays.svg?style=for-the-badge)](https://packagist.org/packages/sann4ez/laravel-holidays)
[![GitHub Stars](https://img.shields.io/github/stars/sann4ez/laravel-holidays.svg?style=for-the-badge)](https://github.com/sann4ez/laravel-holidays)
[![Latest Stable Version](https://img.shields.io/packagist/v/sann4ez/laravel-holidays.svg?style=for-the-badge)](https://packagist.org/packages/sann4ez/laravel-holidays)
[![Total Downloads](https://img.shields.io/packagist/dt/sann4ez/laravel-holidays.svg?style=for-the-badge)](https://packagist.org/packages/sann4ez/laravel-holidays)

## Installation

1️⃣ Require this package using Composer:
```shell  
composer require sann4ez/laravel-holidays
```

2️⃣ Publish the package resources:
```shell  
php artisan vendor:publish --tag="holidays-config"
```

This command publishes:
- Configuration file

### 🔧 Default Configuration

Here’s the default `config` file for reference:
```php
<?php

return [
    'default_country' => env('HOLIDAY_DEFAULT_COUNTRY', 'UA'),

    'driver' => env('HOLIDAY_DRIVER', 'calendarific'),

    'drivers' => [
        'calendarific' => \Sann4ez\Holidays\Drivers\Calendarific::class,
        'apininjas' => \Sann4ez\Holidays\Drivers\ApiNinjas::class,              // У безкоштовному плані не можна вказувати рік, по дефолту поточний
        'holidayapi' => \Sann4ez\Holidays\Drivers\HolidayApi::class,            // Немає поточного року у безкоштовному плані
        'elevenholidays' => \Sann4ez\Holidays\Drivers\ElevenHolidays::class,
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
```

## Usage

### 📝 Get holidays for a year

```php
use Sann4ez\Holidays\Facades\Holidays;

$holidays = Holidays::get();
```
or

```php
use Sann4ez\Holidays\Facades\Holidays;

$holidays = Holidays::get(['country' => 'UA', 'year' => 2025], 'calendarific');
```