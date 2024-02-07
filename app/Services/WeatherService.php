<?php

namespace App\Services;

use App\Models\Weather;
use Illuminate\Support\Facades\Http;
use App\Repositories\WeatherRepository;

class WeatherService
{
    const SOURCE_API = 'API';
    const SOURCE_DB = 'DB';

    public function __construct(private WeatherRepository $weatherRepository) {}

    /**
     * Get weather by city name from the specified source.
     *
     * @param string $cityName Name of the city.
     * @param string $source Source of the weather data (API or DB).
     * @return array|null Weather data array or null if an invalid source is provided.
     * @throws \InvalidArgumentException If the source is invalid.
     */
    public function getWeatherByCity(string $cityName, string $source): ?array
    {
        return match ($source) {
            self::SOURCE_API => $this->getWeatherByCityFromApi($cityName),
            self::SOURCE_DB => $this->getWeatherByCityFromDb($cityName),
            default => throw new \InvalidArgumentException("Invalid source provided: $source"),
        };
    }

    /**
     * Fetch weather for a city from an external API.
     *
     * @param string $cityName City name to fetch weather for.
     * @return array Weather data from the API.
     */
    protected function getWeatherByCityFromApi(string $cityName): array
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

    /**
     * Retrieve weather information for a city from the database.
     *
     * @param string $cityName Name of the city to retrieve weather for.
     * @return array Weather data from the database.
     */
    protected function getWeatherByCityFromDb(string $cityName): array
    {
        $weather = $this->weatherRepository->findByCityName($cityName);

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
