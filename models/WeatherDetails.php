<?php

namespace models;

class WeatherDetails
{
    public function __construct(
        public string $cityName,
        public string $iconUrl,
        public string $description,
        public string $tempMin,
        public string $tempMax,
        public string $distance = '',
    ) {}
}
