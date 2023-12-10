<?php


class IndexController
{

    public function index()
    {
        $cities = FileProcessor::getCities();

        include 'views/index.php';
    }
}
