<?php

namespace models;

class WeatherDetails
{
    public function __construct(
        public string $iconUrl,
        public string $description,
        public string $tempMin,
        public string $tempMax,
    ) {}
}
