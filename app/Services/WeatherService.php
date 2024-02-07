<?php

namespace App\Services;

use App\Models\Weather;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    const SOURCE_API = 'API';
    const SOURCE_DB = 'DB';

    public function getWeatherByCity($cityName, $source)
    {
        switch ($source) {
            case self::SOURCE_API:
                return $this->getWeatherByCityFromApi($cityName);
            case self::SOURCE_DB:
                return $this->getWeatherByCityFromDb($cityName);
            default:
                throw new \InvalidArgumentException("Invalid source provided: $source");
        }
    }

    protected function getWeatherByCityFromApi($cityName)
    {
        $response = Http::get(config('services.openweather.url'), [
            'q' => $cityName,
            'units' => 'metric',
            'appid' => config('services.openweather.api_key')
        ]);

        $responseJson = $response->json();

        return [
            'type' => self::SOURCE_API,
            'city_name' => $responseJson['city']['name'],
            'list' => $responseJson['list'],
        ];
    }

    protected function getWeatherByCityFromDb($cityName)
    {
        $weather = Weather::where('city_name', $cityName)->firstOrFail();

        return [
            'type' => self::SOURCE_DB,
            'city_name' => $cityName,
            'list' => [[
                'dt_txt' => $weather->timestamp_dt->format('Y-m-d H:i:s'),
                'main' => [
                    'temp_min' => $weather->min_tmp,
                    'temp_max' => $weather->max_tmp,
                ],
                'wind' => [
                    'speed' => $weather->wind_spd,
                ],
            ]],
            'updated_at' => $weather->updated_at,
        ];
    }
}
