<?php

namespace App\Service;

use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\MeasurmentRepository;

class WeatherUtil
{
    private CityRepository $cityRepository;
    private MeasurmentRepository $measurementRepository;

    public function __construct(CityRepository $cityRepository, MeasurmentRepository $measurementRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->measurementRepository = $measurementRepository;
    }

    public function getWeatherForCountryAndCity(string $country_name, string $city_name): array {
        $city = $this->cityRepository->findCityByCountryAndCityName($country_name, $city_name);
        $result = $this->getWeatherForLocation($city);
        return $result;
    }

    public function getWeatherForLocation(City $city): array
    {
        $measurements = $this->measurementRepository->findByCity($city);
        $cityAndMeasurements = array(
            "city" => $city,
            "measurements" => $measurements
        );

        return $cityAndMeasurements;
    }
}