<?php

namespace App\Repositories;

use App\Models\Weather;

class WeatherRepository
{
    public function saveWeather($cityName, $weatherData): void
    {
        $weather = $weatherData['list1'][0] ?? null;

        if (!$weather) {
            return;
        }

        Weather::updateOrCreate(
            ['city_name' => $cityName],
            [
                'min_tmp' => $weather['main']['temp_min'],
                'max_tmp' => $weather['main']['temp_max'],
                'wind_spd' => $weather['wind']['speed'],
                'timestamp_dt' => $weather['dt_txt']
            ]
        );
    }
}