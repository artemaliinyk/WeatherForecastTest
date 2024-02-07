<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\WeatherService;
use App\Repositories\WeatherRepository;
use App\Http\Requests\WeatherRequest;

class WeatherController extends Controller
{
    public function __construct(protected WeatherService $weatherService, protected WeatherRepository $weatherRepository) {}

    /**
     * Display the weather index page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $cityName = $request->query('cityName');
        $source = $request->query('source');
        $weather = $cityName && $source ? $this->weatherService->getWeatherByCity($cityName, $source) : null;

        return view('index', compact('cityName', 'weather'));
    }

    /**
     * Fetch weather data and redirect to index page.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function getWeather(Request $request): RedirectResponse
    {
        $cityName = $request->input('cityName');
        $source = $request->input('source');

        $this->weatherService->getWeatherByCity($cityName, $source);

        return redirect()->route('index', compact('cityName', 'source'));
    }

    /**
     * Save weather data and redirect.
     *
     * @param WeatherRequest $request
     * @return RedirectResponse
     */
    public function save(WeatherRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($validated['source'] === WeatherService::SOURCE_API) {
            $weather = $this->weatherService->getWeatherByCity($validated['cityName'], $validated['source']);
            $this->weatherRepository->save($validated['cityName'], $weather);

            return redirect()->route('index', [
                'cityName' => $validated['cityName'], 
                'source' => $validated['source']
            ])->with('success', 'Forecast saved successfully!');
        }

        return redirect()->back()->with('error', 'Invalid source.');
    }
}
