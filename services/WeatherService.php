<?php

use Ballen\Distical\Calculator as DistanceCalculator;
use Ballen\Distical\Entities\LatLong;
use models\WeatherDetails;

class WeatherService
{
    public static $instance;

    public static function getInstance() {
        if ( !(self::$instance instanceof self) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function appendCitiesWithWeatherDetails(array $searchFields, array &$cities)
    {
        foreach ($cities as &$city) {
            $weather = $this->getWeatherByCoordinates((float)$city['latitude'], (float)$city['longitude']);
            $this->addDistanceFromSearchFieldsToWeather($weather, $searchFields, (float)$city['latitude'], (float)$city['longitude']);

            $city = array_merge($city, (array)$weather);
        }

        if ($searchFields) {
            $weather =  $this->getWeatherByCoordinates((float)$searchFields['latitude'], (float)$searchFields['longitude']);

            array_unshift($cities, (array)$weather);
        }
    }

    private function getWeatherByCoordinates(float $latitude, float $longitude): WeatherDetails
    {
        return OpenWeatherApiService::getInstance()->getWeatherByCoordinates($latitude, $longitude);
    }

    public function addDistanceFromSearchFieldsToWeather(WeatherDetails &$weather, array $searchFields, float $latitude, float $longitude)
    {
        if (!$searchFields) {
            return;
        }

        $weather->distance = $this->measureDistanceFromSearchFields(
            (float)$searchFields['latitude'],
            (float)$searchFields['longitude'],
            $latitude,
            $longitude
        );
    }

    private function measureDistanceFromSearchFields(?float $fromLatitude, ?float $fromLongitude, float $toLatitude, float $toLongitude)
    {
        if (!$fromLatitude || !$fromLongitude) {
            return null;
        }

        $fromCoordinates = new LatLong($fromLatitude, $fromLongitude);
        $toCoordinates = new LatLong($toLatitude, $toLongitude);

        $distanceCalculator = new DistanceCalculator($fromCoordinates, $toCoordinates);
        $distance = $distanceCalculator->get();

        return $distance->asKilometres();
    }
}
