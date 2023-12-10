<?php

use GuzzleHttp\Client;
use models\WeatherDetails;

class OpenWeatherApiService
{
    public static $instance;

    public static function getInstance(): OpenWeatherApiService
    {
        if ( !(self::$instance instanceof self) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getWeatherByCoordinates(float $latitude, float $longitude): WeatherDetails
    {
        $client = new Client([
            'base_uri' => $_ENV['WEATHER_API_URL'],
            'timeout'  => 2.0,
        ]);

        $url = str_replace(
            ['{lat}', '{lon}', '{API key}'],
            [$latitude, $longitude, $_ENV['WEATHER_API_KEY']],
            'data/2.5/weather?lat={lat}&lon={lon}&appid={API key}&units=metric'
        );

        $details = json_decode($client->get($url)->getBody()->getContents());

        return new WeatherDetails(
            $details->name,
            "https://openweathermap.org/img/wn/" . $details->weather[0]->icon . "@2x.png",
            $details->weather[0]->description,
            $details->main->temp_min,
            $details->main->temp_max
        );
    }


}
