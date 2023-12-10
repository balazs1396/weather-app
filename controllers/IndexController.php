<?php


class IndexController
{

    public function index()
    {
        $cities = FileProcessor::getCities();

        WeatherService::getInstance()->appendCitiesWithWeatherDetails($cities);

        include 'views/index.php';
    }
}
