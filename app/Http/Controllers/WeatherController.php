<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Models\Weather;
use App\Http\Requests\WeatherRequest;
use App\Repositories\WeatherRepository;

class WeatherController extends Controller
{
    protected $weatherService;
    protected $weatherRepository;

    public function __construct(WeatherService $weatherService, WeatherRepository $weatherRepository)
    {
        $this->weatherService = $weatherService;
        $this->weatherRepository = $weatherRepository;
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

    public function save(WeatherRequest $request)
    {
        $validated = $request->validated();

        if ($validated['source'] === WeatherService::SOURCE_API) {
            $weather = $this->weatherService->getWeatherByCity($validated['cityName'], $validated['source']);
            $this->weatherRepository->saveWeather($validated['cityName'], $weather);

            return redirect()->back()->with('success', 'Forecast saved successfully!');
        }

        return redirect()->back()->with('error', 'Invalid source.');
    }
}
