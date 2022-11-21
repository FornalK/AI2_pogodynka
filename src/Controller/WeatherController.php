<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;
use App\Repository\MeasurmentRepository;
use App\Repository\CityRepository;
use App\Service\WeatherUtil;

class WeatherController extends AbstractController
{
    // public function cityAction(City $city, MeasurmentRepository $measurementRepository): Response
    // {
    //     $measurements = $measurementRepository->findByCity($city);

    //     return $this->render('weather/city.html.twig', [
    //         'city' => $city,
    //         'measurements' => $measurements
    //     ]);
    // }

    // public function cityAction(string $country_name,
    //                            string $city_name,
    //                            MeasurmentRepository $measurementRepository,
    //                            CityRepository $cityRepository): Response
    // {
    //     $city = $cityRepository->findCityByCountryAndCityName($country_name, $city_name);
    //     $measurements = $measurementRepository->findByCity($city);

    //     return $this->render('weather/city.html.twig', [
    //         'city' => $city,
    //         'measurements' => $measurements
    //     ]);
    // }

    public function cityAction(string $country_name,
                               string $city_name,
                               WeatherUtil $weatherUtil): Response {

        $cityAndMeasurements = $weatherUtil->getWeatherForCountryAndCity($country_name, $city_name);
    
        return $this->render('weather/city.html.twig', [
            'city' => $cityAndMeasurements["city"],
            'measurements' => $cityAndMeasurements["measurements"]
        ]);
    }
}

