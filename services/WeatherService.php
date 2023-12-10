<?php

class WeatherService
{
    public static $instance;

    public static function getInstance() {
        if ( !(self::$instance instanceof self) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function appendCitiesWithWeatherDetails(array &$cities)
    {
        foreach ($cities as &$city) {
            $weather = OpenWeatherApiService::getInstance()->getWeatherByCoordinates((float)$city['latitude'], (float)$city['longitude']);

            $city = array_merge($city, (array)$weather);
        }
    }
}
