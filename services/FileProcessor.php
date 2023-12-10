<?php

class FileProcessor
{

    public static function getCities(): array
    {
        $file = "storage/cities.dat";
        $contents = file_get_contents($file);
        $cityRows = explode("\n", $contents);

        $header = $cityRows[0];
        unset($cityRows[0]);

        $cities = [];
        foreach($cityRows as $cityRow) {
            $cityParts = explode(" ", $cityRow);
            $cities[] = [
                'country' => $cityParts[0],
                'zip' => $cityParts[1],
                'city' => $cityParts[2],
                'longitude' => $cityParts[3],
                'latitude' => $cityParts[4],
            ];
        }

        return $cities;
    }
}
