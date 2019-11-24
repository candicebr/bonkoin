<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $car_brand;

    /**
     * @ORM\Column(type="integer")
     */
    private $car_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $car_km;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $car_fuel;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Advert", inversedBy="car", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $car_advert;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarBrand(): ?string
    {
        return $this->car_brand;
    }

    public function setCarBrand(?string $car_brand): self
    {
        $this->car_brand = $car_brand;

        return $this;
    }

    public function getCarDate(): ?int
    {
        return $this->car_date;
    }

    public function setCarDate(int $car_date): self
    {
        $this->car_date = $car_date;

        return $this;
    }

    public function getCarKm(): ?int
    {
        return $this->car_km;
    }

    public function setCarKm(?int $car_km): self
    {
        $this->car_km = $car_km;

        return $this;
    }

    public function getCarFuel(): ?string
    {
        return $this->car_fuel;
    }

    public function setCarFuel(string $car_fuel): self
    {
        $this->car_fuel = $car_fuel;

        return $this;
    }

    public function getCarAdvert(): ?Advert
    {
        return $this->car_advert;
    }

    public function setCarAdvert(Advert $car_advert): self
    {
        $this->car_advert = $car_advert;

        return $this;
    }
}
