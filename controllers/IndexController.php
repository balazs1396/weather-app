<?php


class IndexController
{

    public function index(?string $query)
    {
        $searchFields = RequestService::getInstance()->getValidQueryFields($query);

        $cities = FileProcessor::getCities();

        $weatherService = WeatherService::getInstance();
        $weatherService->appendCitiesWithWeatherDetails($searchFields, $cities);
        $weatherService->sortCitiesByTemperatureSpread($cities);

        include 'views/index.php';
    }
}
