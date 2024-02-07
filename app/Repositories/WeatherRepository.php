<?php

namespace App\Repositories;

use App\Models\Weather;

class WeatherRepository
{
    /**
     * Find weather data by city name.
     *
     * @param string $cityName The name of the city.
     * @return Weather|null Weather model instance or null if not found.
     */
    public function findByCityName(string $cityName): ?Weather
    {
        return Weather::where('city_name', $cityName)->firstOrFail();
    }

    /**
     * Save or update weather data for a given city.
     *
     * @param string $cityName The name of the city.
     * @param array $data The weather data array.
     * @return Weather The saved or updated Weather model instance.
     */
    public function save(string $cityName, array $data): Weather
    {
        $weatherData = $data['list'][0];

        return Weather::updateOrCreate(
            ['city_name' => $cityName],
            [
                'min_tmp' => $weatherData['main']['temp_min'],
                'max_tmp' => $weatherData['main']['temp_max'],
                'wind_spd' => $weatherData['wind']['speed'],
                'timestamp_dt' => $weatherData['dt_txt'],
            ]
        );
    }
}