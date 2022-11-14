<?php

namespace App\Command;

use App\Repository\CityRepository;
use App\Repository\MeasurmentRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'weather:getByLocationId',
    description: 'Provides measurements for a specific location by its id',
)]
class WeatherGetByLocationIdCommand extends Command
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
            ->addArgument('locationId', InputArgument::REQUIRED, 'City ID')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $locationId = $input->getArgument('locationId');
        $city = $this->cityRepository->find($locationId);
        $measurements = $this->weatherUtil->getWeatherForLocation($city, $this->measurmentRepository);

        $output->writeln($measurements);

        return Command::SUCCESS;
    }
}
