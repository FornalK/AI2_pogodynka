<?php

namespace App\Entity;

use App\Repository\MeasurmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurmentRepository::class)]
class Measurment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 1, nullable: true)]
    private ?string $temperature = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 1, nullable: true)]
    private ?string $wind = null;

    #[ORM\Column(nullable: true)]
    private ?int $cloudiness_level = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city_id): self
    {
        $this->city = $city_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(?string $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getWind(): ?string
    {
        return $this->wind;
    }

    public function setWind(string $wind): self
    {
        $this->wind = $wind;

        return $this;
    }

    public function getCloudinessLevel(): ?int
    {
        return $this->cloudiness_level;
    }

    public function setCloudinessLevel(?int $cloudiness_level): self
    {
        $this->cloudiness_level = $cloudiness_level;

        return $this;
    }

    public function celsiusToFahrenheit(float $celsius): float
    {
        return $celsius * 1.8 + 32;
    }
}
