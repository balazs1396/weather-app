<?php

use Ballen\Distical\Calculator as DistanceCalculator;
use Ballen\Distical\Entities\LatLong;
use models\WeatherDetails;

class WeatherService
{
    public static $instance;

    public static function getInstance(): WeatherService
    {
        if ( !(self::$instance instanceof self) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param array $searchFields
     * @param array $cities
     * @return void
     */
    public function appendCitiesWithWeatherDetails(array $searchFields, array &$cities): void
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

    /**
     * @param array<WeatherDetails> $cities
     * @return void
     */
    public function sortCitiesByTemperatureSpread(array &$cities): void
    {
        usort($cities, function($a, $b) {
            $diffA = $a['tempMax'] - $a['tempMin'];
            $diffB = $b['tempMax'] - $b['tempMin'];

            if ($diffA == $diffB) {
                return 0;
            }

            return ($diffA < $diffB) ? -1 : 1;
        });
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @return WeatherDetails
     */
    private function getWeatherByCoordinates(float $latitude, float $longitude): WeatherDetails
    {
        return OpenWeatherApiService::getInstance()->getWeatherByCoordinates($latitude, $longitude);
    }

    /**
     * @param WeatherDetails $weather
     * @param array $searchFields
     * @param float $latitude
     * @param float $longitude
     * @return void
     */
    public function addDistanceFromSearchFieldsToWeather(WeatherDetails &$weather, array $searchFields, float $latitude, float $longitude): void
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

    /**
     * @param float|null $fromLatitude
     * @param float|null $fromLongitude
     * @param float $toLatitude
     * @param float $toLongitude
     * @return float|int|null
     */
    private function measureDistanceFromSearchFields(?float $fromLatitude, ?float $fromLongitude, float $toLatitude, float $toLongitude): float|int|null
    {
        if (!$fromLatitude || !$fromLongitude) {
            return null;
        }

        $fromCoordinates = new LatLong($fromLatitude, $fromLongitude);
        $toCoordinates = new LatLong($toLatitude, $toLongitude);

        $distanceCalculator = new DistanceCalculator($fromCoordinates, $toCoordinates);
        $distance = $distanceCalculator->get();

        return round($distance->asKilometres(), 2);
    }
}
