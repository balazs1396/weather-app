<?php


class IndexController
{

    public function index(?string $query)
    {
        $searchFields = RequestService::getInstance()->getValidQueryFields($query);

        $cities = FileProcessor::getCities();

        WeatherService::getInstance()->appendCitiesWithWeatherDetails($searchFields, $cities);

        include 'views/index.php';
    }
}
