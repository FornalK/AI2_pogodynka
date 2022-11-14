<?php

namespace App\Command;

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
    private CityRepository $cityRepository;
    private MeasurmentRepository $measurmentRepository;
    private WeatherUtil $weatherUtil;
    
    public function __constructor(CityRepository $cityRepository, MeasurmentRepository $measurmentRepository, WeatherUtil $weatherUtil, string $name = null)
    {
        $this->cityRepository = $cityRepository;
        $this->measurmentRepository = $measurmentRepository;
        $this->weatherUtil = $weatherUtil;

        parent::__constructor($name);
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
        $cityAndMeasurements = $this->weatherUtil->getWeatherForCountryAndCity($country_name, $city_name, $this->cityRepository, $this->measurementRepository);

        $output->writeln($cityAndMeasurements["measurements"]);

        return Command::SUCCESS;

        return Command::SUCCESS;
    }
}
