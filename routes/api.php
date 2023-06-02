<?php

use App\Services\WeatherForecast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/forecast', function(Request $request) {
    $weatherForecastService = new \App\Services\WeatherForecast();
    try {
        $forecast = $weatherForecastService->retrieveForecast()->getForecast();
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'There was an error retrieving the forecast.'
        ], 500);
    }

    return $forecast;
});
