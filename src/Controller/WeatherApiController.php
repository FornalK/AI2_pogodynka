<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class WeatherApiController extends AbstractController
{
     /**
     * @return Response
     * @Route("/api/weather", name="api_weather_json")
     */
    public function weatherJsonAction(Request $request, WeatherUtil $weatherUtil): Response {
        $payload = $request->getContent();
        $payload = json_decode($payload, true);
        $countryName = $payload['country_name'];
        $cityName = $payload['city_name'];
        $outputType = $payload['output'];

        $cityAndMeasurements = $weatherUtil->getWeatherForCountryAndCity($countryName, $cityName);
        $location = $cityAndMeasurements["city"];
        $measurements = $cityAndMeasurements["measurements"];

        $responseArray['location'] = [
            'id' => $location->getId(),
            'name' => $location->getCityName(),
            'country' => $location->getCountryName(),
            'latitude' => $location->getLatitude(),
            'longitude' => $location->getLongitude(),
        ];

        $responseArray['measurements'] = [];

        foreach ($measurements as $measurement) {
            $responseArray['measurements'][$measurement->getDate()->format('Y-m-d')] = [
                'date' => $measurement->getDate()->format('Y-m-d'),
                'celsius' => $measurement->getTemperature(),
                'wind' => $measurement->getWind(),
                'cloudinessLevel' => $measurement->getCloudinessLevel()
            ];
        }

        // if($outputType == "json") {
        //     return $this->json($responseArray);             
        // } else if ($outputType == "csv") {
        //     $response = new Response();
        //     $output = implode(",", $responseArray['location']) . "\n";
        //     foreach ($responseArray['measurements'] as $measurement) {
        //         $output .= implode(",", $measurement) . "\n";
        //     }
        //     $response->setContent($output);
        //     return $response;     
        // } else {
        //     return $this->json(['success' => false, 'errors' => "Wrong output type. Select 'json' or 'csv'"]);
        // }

        $response = $this->render("weather_api/weather_twig.{$outputType}.twig", [
            'locationName' => $cityName,
            'location' => $location,
            'measurements' => $measurements,
        ]);    
        
        switch ($outputType) {
            case 'json':
                $response->headers->set('Content-Type', 'application/json');
                break;
            case 'csv':
                $response->headers->set('Content-Type', 'text/csv');
        }

        return $response;
       


        
    }
}
