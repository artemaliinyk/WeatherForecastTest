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

    public function index(Request $request)
    {
        $cityName = $request->query('cityName');
        $source = $request->query('source');
        $weather = null;

        if ($cityName && $source) {
            $weather = $this->weatherService->getWeatherByCity($cityName, $source);
        }

        return view('index', ['cityName' => $cityName, 'weather' => $weather]);
    }

    public function getWeather(Request $request)
    {
        $cityName = $request->input('cityName');
        $source = $request->input('source');

        $weather = $this->weatherService->getWeatherByCity($cityName, $source);

        return redirect()->route('index', ['cityName' => $cityName, 'source' => $source]);
    }

    public function save(WeatherRequest $request)
    {
        $validated = $request->validated();

        if ($validated['source'] === WeatherService::SOURCE_API) {
            $weather = $this->weatherService->getWeatherByCity($validated['cityName'], $validated['source']);
            $this->weatherRepository->save($validated['cityName'], $weather);

            return redirect()->route('index', ['cityName' => $validated['cityName'], 'source' => $validated['source']])->with('success', 'Forecast saved successfully!');
        }

        return redirect()->back()->with('error', 'Invalid source.');
    }
}
