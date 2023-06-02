<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ForecastCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast {cities?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a simple 5 day temperature forecast for the given cities. 
    Please either disclude spaces from city names or use underscores in place of spaces.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //VALIDATE INPUT
        $cities = $this->argument('cities');
        //check if the array is empty
        if (empty($cities)) {
            //Prompt user for city names
            $cities = $this->ask('No city names provided. Which cities would you like to check? (separate by comma)');
            //convert the string to an array
            $cities = explode(',', $cities);
        }


        //RETRIEVE FORECAST
        $weatherForecastService = new \App\Services\WeatherForecast();
        try {
            $forecast = $weatherForecastService->setCities($cities)->setDays(5)->retrieveForecast()->getForecast();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            Command::FAILURE;
        }

        $this->displayForecast($forecast);
        Command::SUCCESS;
    }

    private function displayForecast($forecast)
    {
        //TRANSFORM FORECAST RESPONSE
        $forecast = collect($forecast)->map(function ($city) {
            $days = collect($city['data'])->map(function ($day) {
                return 'Avg: '. $day['temp'] .', Max: '. $day['max_temp'] .', Low: ' . $day['low_temp'];
            })->toArray();
            return array_merge([$city['city_name']], $days);
        })->toArray();

        //create a table that shows the min max and average temperate for each of the cities
        $this->table(['City', 'Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5'], $forecast);
    }
}
