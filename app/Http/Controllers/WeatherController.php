<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Models\Weather;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        return view('index');
    }

    public function getWeather(Request $request)
    {
        $cityName = $request->input('cityName');
        $source = $request->input('source');

        $weather = $this->weatherService->getWeatherByCity($cityName, $source);

        return view('index', ['cityName' => $cityName, 'weather' => $weather]);
    }
}
