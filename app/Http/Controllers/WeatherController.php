<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    public function index()
    {
        return view('weather');
    }

    public function getWeather(Request $request)
    {
        $city = $request->input('city');
        $apiKey = env('WEATHER_API_KEY');
        $apiUrl = 'http://api.openweathermap.org/data/2.5/weather';

        // Получение данных о текущей погоде
        $response = Http::get($apiUrl, [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            $weather = $response->json();

            if (isset($weather['name'])) {
                $lat = $weather['coord']['lat'];
                $lon = $weather['coord']['lon'];

                // Получение почасового прогноза
                $forecastUrl = 'http://api.openweathermap.org/data/2.5/forecast';
                $forecastResponse = Http::get($forecastUrl, [
                    'lat' => $lat,
                    'lon' => $lon,
                    'appid' => $apiKey,
                    'units' => 'metric',
                ]);

                if ($forecastResponse->successful()) {
                    $hourlyWeather = $forecastResponse->json()['list'];
                    return view('weather', compact('weather', 'hourlyWeather'));
                } else {
                    Log::error('Failed to retrieve hourly weather data', ['status' => $forecastResponse->status(), 'body' => $forecastResponse->body()]);
                    return view('weather', ['error' => 'Failed to retrieve hourly weather data.']);
                }
            } else {
                return view('weather', ['error' => 'City not found.']);
            }
        } else {
            Log::error('Failed to retrieve weather data', ['status' => $response->status(), 'body' => $response->body()]);
            return view('weather', ['error' => 'Failed to retrieve weather data.']);
        }
    }
}
