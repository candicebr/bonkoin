<?php


namespace App\Entity;


class AdvertSearch
{
    //----------------------------recherche générale---------------------
    /**
     * @var double|null
     */
    private $price;

    /**
     * @var string|null
     */
    private $category;

    /**
     * @var string|null
     */
    private $region;


    //------------------------recherche sur une voiture-------------------
    /**
     * @var string|null
     */
    private $car_brand;

    /**
     * @var int|null
     */
    private $car_date;

    /**
     * @var int|null
     */
    private $car_km;

    /**
     * @var string|null
     */
    private $car_fuel;

    //-----------------------recherche sur des vêtements-------------------

    /**
     * @var string|null
     */
    private $clothe_type;

    /**
     * @var string|null
     */
    private $clothe_universe;

    /**
     * @var string|null
     */
    private $clothe_color;

    /**
     * @var string|null
     */
    private $clothe_state;

    /**
     * @var string|null
     */
    private $clothe_brand;

    //---------------------recherche sur l'immobilier---------------------

    /**
     * @var string|null
     */
    private $immovable_type;

    /**
     * @var double|null
     */
    private $immovable_surface;

    /**
     * @var int|null
     */
    private $immovable_room;

    /**
     * @var string|null
     */
    private $immovable_energy;

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param string|null $region
     */
    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return string|null
     */
    public function getCarBrand(): ?string
    {
        return $this->car_brand;
    }

    /**
     * @param string|null $car_brand
     */
    public function setCarBrand(?string $car_brand): void
    {
        $this->car_brand = $car_brand;
    }

    /**
     * @return int|null
     */
    public function getCarDate(): ?int
    {
        return $this->car_date;
    }

    /**
     * @param int|null $car_date
     */
    public function setCarDate(?int $car_date): void
    {
        $this->car_date = $car_date;
    }

    /**
     * @return int|null
     */
    public function getCarKm(): ?int
    {
        return $this->car_km;
    }

    /**
     * @param int|null $car_km
     */
    public function setCarKm(?int $car_km): void
    {
        $this->car_km = $car_km;
    }

    /**
     * @return string|null
     */
    public function getCarFuel(): ?string
    {
        return $this->car_fuel;
    }

    /**
     * @param string|null $car_fuel
     */
    public function setCarFuel(?string $car_fuel): void
    {
        $this->car_fuel = $car_fuel;
    }

    /**
     * @return string|null
     */
    public function getClotheType(): ?string
    {
        return $this->clothe_type;
    }

    /**
     * @param string|null $clothe_type
     */
    public function setClotheType(?string $clothe_type): void
    {
        $this->clothe_type = $clothe_type;
    }

    /**
     * @return string|null
     */
    public function getClotheUniverse(): ?string
    {
        return $this->clothe_universe;
    }

    /**
     * @param string|null $clothe_universe
     */
    public function setClotheUniverse(?string $clothe_universe): void
    {
        $this->clothe_universe = $clothe_universe;
    }

    /**
     * @return string|null
     */
    public function getClotheColor(): ?string
    {
        return $this->clothe_color;
    }

    /**
     * @param string|null $clothe_color
     */
    public function setClotheColor(?string $clothe_color): void
    {
        $this->clothe_color = $clothe_color;
    }

    /**
     * @return string|null
     */
    public function getClotheState(): ?string
    {
        return $this->clothe_state;
    }

    /**
     * @param string|null $clothe_state
     */
    public function setClotheState(?string $clothe_state): void
    {
        $this->clothe_state = $clothe_state;
    }

    /**
     * @return string|null
     */
    public function getClotheBrand(): ?string
    {
        return $this->clothe_brand;
    }

    /**
     * @param string|null $clothe_brand
     */
    public function setClotheBrand(?string $clothe_brand): void
    {
        $this->clothe_brand = $clothe_brand;
    }

    /**
     * @return string|null
     */
    public function getImmovableType(): ?string
    {
        return $this->immovable_type;
    }

    /**
     * @param string|null $immovable_type
     */
    public function setImmovableType(?string $immovable_type): void
    {
        $this->immovable_type = $immovable_type;
    }

    /**
     * @return float|null
     */
    public function getImmovableSurface(): ?float
    {
        return $this->immovable_surface;
    }

    /**
     * @param float|null $immovable_surface
     */
    public function setImmovableSurface(?float $immovable_surface): void
    {
        $this->immovable_surface = $immovable_surface;
    }

    /**
     * @return int|null
     */
    public function getImmovableRoom(): ?int
    {
        return $this->immovable_room;
    }

    /**
     * @param int|null $immovable_room
     */
    public function setImmovableRoom(?int $immovable_room): void
    {
        $this->immovable_room = $immovable_room;
    }

    /**
     * @return string|null
     */
    public function getImmovableEnergy(): ?string
    {
        return $this->immovable_energy;
    }

    /**
     * @param string|null $immovable_energy
     */
    public function setImmovableEnergy(?string $immovable_energy): void
    {
        $this->immovable_energy = $immovable_energy;
    }

}