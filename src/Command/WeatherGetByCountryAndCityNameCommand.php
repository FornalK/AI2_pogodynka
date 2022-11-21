<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:getByCountryAndCityName',
    description: 'Provides measurements for a specific location by its country and city names',
)]
class WeatherGetByCountryAndCityNameCommand extends Command
{
    private WeatherUtil $weatherUtil;
    
    public function __construct(WeatherUtil $weatherUtil, string $name = null)
    {
        $this->weatherUtil = $weatherUtil;

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('countryName', InputArgument::REQUIRED, 'Country name')
            ->addArgument('cityName', InputArgument::REQUIRED, 'City name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $countryName = $input->getArgument('countryName');
        $cityName = $input->getArgument('cityName');
        $cityAndMeasurements = $this->weatherUtil->getWeatherForCountryAndCity($countryName, $cityName);

        $output->writeln("Country: " . $cityAndMeasurements["city"]->getCountryName());
        $output->writeln("City: " . $cityAndMeasurements["city"]->getCityName());
        foreach($cityAndMeasurements["measurements"] as $measurement) {
            $output->writeln("Date: " . json_encode($measurement->getDate()));
            $output->writeln("Temperature: " . $measurement->getTemperature());
            $output->writeln("Wind: " . $measurement->getWind());
            $output->writeln("Cloudiness Level: " . $measurement->getCloudinessLevel());
            $output->writeln("");
        }

        return Command::SUCCESS;
    }
}
