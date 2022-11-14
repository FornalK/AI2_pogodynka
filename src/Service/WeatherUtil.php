<?php

namespace App\Service;

use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\MeasurmentRepository;

class WeatherUtil
{
    public function getWeatherForCountryAndCity(string $country_name, 
                                                string $city_name, 
                                                CityRepository $cityRepository, 
                                                MeasurmentRepository $measurementRepository): array {
        $city = $cityRepository->findCityByCountryAndCityName($country_name, $city_name);
        $result = $this->getWeatherForLocation($city, $measurementRepository);
        return $result;
    }

    public function getWeatherForLocation(City $city, MeasurmentRepository $measurementRepository): array
    {
        $measurements = $measurementRepository->findByCity($city);
        $cityAndMeasurements = array(
            "city" => $city,
            "measurements" => $measurements
        );

        return $cityAndMeasurements;
    }
}