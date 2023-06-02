<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
/**
 * Class WeatherForecast
 * @package App\Services
 */
class WeatherForecast
{
    private $cities = ['Gold Coast', 'Brisbane', 'Sunshine Coast'];
    private $days = 5;
    private $forecast = [];

    
    private CONST APIURL = 'https://api.weatherbit.io/v2.0/forecast/daily';
    

    /**
     * Set the cities for the weather forecast.
     *
     * @param [String] $cities
     * @return WeatherForecast
     */
    public function setCities($cities)
    {
        $this->cities = collect($cities)->map(function ($city) {
            return trim($city);
        })->map(function ($city) {
            return strtolower($city);
        })->toArray();
        return $this;
    }

    /**
     * Set the number of days for the weather forecast.
     *
     * @param [Integer] $days
     * @return WeatherForecast
     */
    public function setDays($days)
    {
        $this->days = $days;
        return $this;
    }

    /**
     * Retrieve the forecast for the given cities and store it in the forecast property.
     *
     * @return WeatherForecast
     * @throws \Exception
     */
    public function retrieveForecast() {
        foreach ($this->cities as $city) {
            $this->retrieveForecastForCity($city);
        }
        return $this;
    }

    /**
     * Return the forecast property.
     *
     * @return Array
     */
    public function getForecast() {
        return $this->forecast;
    }

    /**
     * Gets the forecast for the given city and stores it in the forecast property.
     *
     * @param string $city
     * @return WeatherForecast
     * @throws \Exception
     */
    private function retrieveForecastForCity($city) {
        try {
            $this->forecast[$city] = Cache::remember($city . $this->days, 1200, function () use ($city) {
                return $this->retrieveForecastFromApi($city);
            });
        } catch (\Exception $e) {
            Log::error('Error retrieving forecast for ' . $city . '. Error: ' . $e->getMessage());
            throw $e;
        }
        return $this;
    }

    /**
     * Retrieves the forecast for the given city from the weatherbit API.
     *
     * @param string $city
     * @return Array
     */
    private function retrieveForecastFromApi($city) {
        // use guzzle
        $client = new \GuzzleHttp\Client();

        //build the query string
        $query = [
            'city' => $city,
            'days' => $this->days,
            'key' => env('WEATHERBIT_API_KEY')
        ];
        //make the request
        $response = $client->request('GET', self::APIURL, [
            'query' => $query
        ]);

        //Check code is 200. If not, throw an error.
        if ($response->getStatusCode() != 200) {
            throw new \Exception('Error retrieving forecast for ' . $city . '. Status code: ' . $response->getStatusCode());
        }

        //check if the response is valid. If not throw an error
        $response = json_decode($response->getBody(), true);
        if (!isset($response['data']))
        {
            throw new \Exception('Error retrieving forecast for ' . $city . '. Response: ' . $response);
        }

        return $response;
    }
}
